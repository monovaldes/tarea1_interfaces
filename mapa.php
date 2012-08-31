<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" charset="utf-8" />
        <title>Interfaces - 16744844-5</title>
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <style type="text/css">html,body{background-color:#001A33;} </style>
       
    	<title></title>
    </head>
    <body onload="initialize()">
  <div class="container">
    <br />
        <div class=well>
        <button rel="tooltip" data-placement="right" data-original-title="Limpiar el Mapa" id="limpiar" class="close" onClick="window.location.href='http://interfaces.inf.santiago.usm.cl/16744844/'">&lambda;</button>
        <h2> Mapa Rutero</h2>
  
        <div id="map_canvas" style="width:900px; height:500px"></div>
        </div>

    <footer>
        <script src="bootstrap/js/jquery.js"></script> 
        <script src="bootstrap/js/bootstrap.js"></script> 
    </footer>
</body>
<script type="text/javascript"src="https://maps.google.com/maps/api/js?sensor=false"></script>  
<script name="dst" type="text/javascript">
    var variables = new Array();
    <?php
        require_once "database.inc.php";
        $dal = new DAL();
        list($localidad_origen, $comuna, $region) = split('[,.-]', $_GET['origen']);
        list($localidad_destino, $comuna, $region) = split('[,.-]', $_GET['destino']);
        if($_GET['visitarpuntos'] == "on"){
            echo 'var visitas = true;
            ';
            echo 'var markersArray = [];
            ';
            echo 'var wp = [];
            ';
            if($_GET['puntosintermedios'] == "on"){
                echo 'var puntosintermedios = true;
                    ';

                $lugares = $_GET['lugares'];
                for($i = 0; $i<count($lugares); $i++){
                   foreach ($dal->obtener_establecimiento($lugares[$i]) as $punto){
                        echo "markersArray.push(
                          new google.maps.Marker({
                              position: new google.maps.LatLng(".$punto->Latitud.",".$punto->Longitud."),
                              title: ".'"'.$punto->Nombre.'"'."
                          })
                        );
                            ";
                        echo "wp.push({
                        location: new google.maps.LatLng(".$punto->Latitud.",".$punto->Longitud."),
                        stopover: false      
                        });
                            ";
                    }
                }
            }
            else{
                $locales = $dal->establecimientos();#arreglo de todos los locales
                echo 'var puntosintermedios = false;
                    ';

                foreach ($locales as $punto) {
                    echo "markersArray.push(
                      new google.maps.Marker({
                          position: new google.maps.LatLng(".$punto->Latitud.",".$punto->Longitud."),
                          title: ".'"'.$punto->Nombre.'"'."
                      })
                    );
                        ";
                    echo "wp.push({
                    location: new google.maps.LatLng(".$punto->Latitud.",".$punto->Longitud."),
                    stopover: false      
                    });
                        ";
                }
            }
        }
        else
            echo 'var visitas = false;
            ';
        
    ?>

    var nombre_origen = "<?php echo $localidad_origen; ?>";
    var nombre_destino = "<?php echo $localidad_destino; ?>";


    google.maps.LatLng.prototype.distanceFrom = function(p2) {
        var R = 6378137; // earth's mean radius in meters (this was a parameter in V2)
        var rad = function(x) {return x*Math.PI/180;}
        var dLat = rad(p2.lat() - this.lat());
        var dLong = rad(p2.lng() - this.lng());
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(rad(this.lat())) * Math.cos(rad(p2.lat())) * Math.sin(dLong/2) * Math.sin(dLong/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
    return d.toFixed(3);
    }
    function is_within_20k(p1,p2){
      var distance = p1.distanceFrom(p2);
      if(distance<10000)
        return true
      else
        return false
    }

    <?php 
        $destino = $dal->obtener_destino($localidad_destino);
        foreach ($destino as $loc) {
            $dst_lat = $loc->Latitud;
            $dst_lng = $loc->Longitud;
        }

        $origen = $dal->obtener_destino($localidad_origen);
        foreach ($origen as $loc) {
            $org_lat = $loc->Latitud;
            $org_lng = $loc->Longitud;
        }
    ?>     
    function initialize() {
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();

        var origen= new google.maps.LatLng(<?php echo $org_lat; ?>,<?php echo $org_lng; ?>); 
        var destino= new google.maps.LatLng(<?php echo $dst_lat; ?>,<?php echo $dst_lng; ?>);    

        var santiago = new google.maps.LatLng(-33.458083,-70.657368);
        var myOptions = {
          zoom: 8,
          center: santiago,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };


        var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
        directionsDisplay.setMap(map);
        var request = {
            origin:origen,
            destination:destino,
            <?php if($_GET['puntosintermedios'] == "on" && $_GET['visitarpuntos'] == "on") echo 'waypoints: wp,'?>
            travelMode: google.maps.TravelMode.DRIVING
        };
        var camino;
        directionsService.route(request,function(result,status){
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);
            }
           camino = result.routes[0].overview_path;
        });
        if(visitas){
            if(puntosintermedios){ //ahora debo ponerlos como waypoints
                for (var i=0;i<markersArray.length;i++)
                    markersArray[i].setMap(map);
            }
            else{
                setTimeout(function() { //en caso de que requiera mostrar las que estan cerca del camino
                    for (var i=0;i<markersArray.length;i++){
                      for (var j=0;j<camino.length;j++){
                          if(is_within_20k(markersArray[i].position,camino[j])){
                              markersArray[i].setMap(map);
                              break;        
                          }
                      }
                    }
                },1250);    
            }
        }
    }   
    $('#limpiar').tooltip();
</script>
</html>
