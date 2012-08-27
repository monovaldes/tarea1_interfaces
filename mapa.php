<?php
require_once "database.inc.php";
$dal = new DAL();
?>

<!DOCTYPE HTML>
<html lang="es">
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>
<script type="text/javascript"src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    function initialize() {
        <?php 
        $destino = $dal->obtener_destino($_GET['nombre_destino']);
     //         echo $destino['Latitud'];
   //         echo "var lat=".$destino['Latitud'].";";
    //        echo "var lng=".$destino['Longitud'].";";
        ?>
        var directionsService = new google.maps.DirectionsService();
        var directionsDisplay = new google.maps.DirectionsRenderer();
        var place= new google.maps.LatLng(lat,lng);    


        var santiago = new google.maps.LatLng(-33.458083,-70.657368);
        var myOptions = {
          zoom: 8,
          center: santiago,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
        directionsDisplay.setMap(map);
        var request = {
            origin:santiago,
            destination:place,
            travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request,function(result,status){
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);
            }
        });

    var markersArray = [];
    <?php
//        $puntos_intermedios = $dal->sitios_intermedios($destino);
 //       foreach ($puntos_intermedios as $punto) {
//            echo "markersArray.push(
 //               new google.maps.Marker({
//                    position: new google.maps.LatLng(".$punto['Latitud'].",".$punto['Longitud']."),
 //                   title: ".'"'.$punto['Nombre'].'"'."
 //           })
//            );";
//        }
    ?>
    for (var i=0;i<markersArray.length;i++){
        markersArray[i].setMap(map);
    }
    var marker = new google.maps.Marker({
        position: place,
//        title: <?php echo '"'.$destino['Nombre_localidad'].'"' ?>
    });
    var santiagoMarker = new google.maps.Marker({
        position: santiago,
        title: "Santiago"
    });
    santiagoMarker.setMap(map);
    marker.setMap(map);
    }
</script>
	<title></title>
</head>
<body onload="initialize()">
    <div id="map_canvas" style="width:900px; height:500px"></div>
</body>
</html>
