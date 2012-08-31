<?php
require_once "database.inc.php";
$dal = new DAL();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" charset="utf-8" />
    <title>ACME USM - Mapa Rutero</title>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <style type="text/css">html,body{background-color:#001A33;} </style>
</head>
<body onload="initialize()">
  <div class="container">
  	<br />
  	<form action="mapa.php" method="get">
		<div class="well">
		  <p>Origen:
						<input name="origen" id="origen" class="search-query" placeholder="origen"
						data-provide="typeahead" data-items="4" autocomplete="off">
		  </p>
  		  <p>Destino:
						<input name="destino" id="destino" class="search-query" placeholder="destino"
						data-provide="typeahead" data-items="4" autocomplete="off">
		  </p>
		  	<p><input name="visitarpuntos" id="visitarpuntos" type="checkbox" onClick="jeje()"> Quiero Visitar sitios en el camino</p>
		  	<p id="ptsint"><input name="puntosintermedios" id="puntosintermedios" type="checkbox" onClick="jeje()"> Conozco los Sitios que visitaré</p>
		    <p><button type="submit" class="btn">Buscar</button></p>
		</div>
		<div id="locales" class="well">
			<ul class="nav nav-tabs">
			  <li id="a1" class="active" onClick="activa_a1()">
			    <a  href="#">Alojamiento</a></li>
			  <li id="a2" onClick="activa_a2()"><a  href="#">Comida</a></li>
			  <li id="a3" onClick="activa_a3()"><a  href="#">Entretención</a></li>
			</ul>

			<div id="b1">
			<?php  
			    $locales = $dal->establecimientos();
			    foreach ($locales as $punto) {
			    	if($punto->Establecimiento_tipo == "Alojamiento")
				    	echo '<label style="width: 250px" class="checkbox" rel="popover" data-content="Ubicacion: '.$punto->Ubicacion.' , Teléfono: '.$punto->Telefono.'" data-original-title="'.$punto->Nombre.'" data-trigger="hover">
									<input name="lugares[]" value="'.$punto->Nombre.'" type="checkbox"> '.$punto->Nombre.'
								</label>';
			 		}
			?>
			</div>
			<div id="b2">
			<?php  
			    $locales = $dal->establecimientos();
			    foreach ($locales as $punto) {
			    	if($punto->Establecimiento_tipo == "Comida")
				    	echo '<label style="width: 250px" class="checkbox" rel="popover" data-content="Ubicacion: '.$punto->Ubicacion.' , Teléfono: '.$punto->Telefono.'" data-original-title="'.$punto->Nombre.'" data-trigger="hover">
									<input name="lugares[]" value="'.$punto->Nombre.'" type="checkbox"> '.$punto->Nombre.'
								</label>';
			 		}
			?>
			</div>
			<div id="b3">
			<?php  
			    $locales = $dal->establecimientos();
			    foreach ($locales as $punto) {
			    	if($punto->Establecimiento_tipo == "Entretención")
				    	echo '<label style="width: 250px" class="checkbox" rel="popover" data-content="Ubicacion: '.$punto->Ubicacion.' , Teléfono: '.$punto->Telefono.'" data-original-title="'.$punto->Nombre.'" data-trigger="hover">
									<input name="lugares[]" value="'.$punto->Nombre.'" type="checkbox"> '.$punto->Nombre.'
								</label>';
				 		}
			?>
			</div>

        </div>
	</form>
		<div class="well">
        <button rel="tooltip" data-placement="right" data-original-title="Limpiar el Mapa" id="limpiar" class="close" onClick="window.location.href='http://interfaces.inf.santiago.usm.cl/16744844/'">&lambda;</button>
        <div id="map_canvas" style="width:900px; height:500px"></div>
        </div>


  </div>
<footer>
	<script src="bootstrap/js/jquery.js"></script> 
	<script src="bootstrap/js/bootstrap.js"></script> 
  <script type="text/javascript"src="https://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
	
	function initialize() {


	var santiago = new google.maps.LatLng(-33.458083,-70.657368);

	var myOptions = {
	zoom: 8,
	center: santiago,
	mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"),
	myOptions);


	}


		<?php
			$localidades = $dal->listado_localidades();
			$temp= array();
			foreach ($localidades as $loc) {
				array_push($temp, $loc->Nombre_localidad . "," . $loc->Nombre_comuna . "," . $loc->Nombre_region); 
			}
			
		?>
		var listado = <?php echo "['" . implode("','", $temp) . "']";?>  
		$('#origen').typeahead({
			source: listado,
			 updater:function (item) {
	        //item = selected item
			var substr = item.split(',');
			var nombre_origen = substr[0];					
			//llamar a mapa.php y pegaro en la div id mapa
			//window.location.href = "http://interfaces.inf.santiago.usm.cl/16744844/mapa.php?nombre_destino="+nombre_localidad;
        return item;
    	}
		})
		$('#destino').typeahead({
			source: listado,
			 updater:function (item) {
	        //item = selected item
			var substr = item.split(',');
			var nombre_destino = substr[0];					
			//llamar a mapa.php y pegaro en la div id mapa
			//window.location.href = "http://interfaces.inf.santiago.usm.cl/16744844/mapa.php?nombre_destino="+nombre_localidad;
        return item;
    	}
		})
		$('#limpiar').tooltip();
		$('.checkbox').popover();
	</script>

<script>
  var locales = document.getElementById('locales');
  locales.style.display = 'none';
  var puntosinter = document.getElementById('ptsint');
  puntosinter.style.display = 'none';                
  var switchElement = document.getElementById('puntosintermedios');
  var switchElement2 = document.getElementById('visitarpuntos');
  function jeje() {
        if (switchElement.checked)
                locales.style.display = '';
        else
                locales.style.display = 'none';   
        if (switchElement2.checked)
                puntosinter.style.display = '';
        else
                puntosinter.style.display = 'none';   
                    
  }

	var a1 = document.getElementById('a1');
	var a2 = document.getElementById('a2');
	var a3 = document.getElementById('a3');

	var b1 = document.getElementById('b1');
	var b2 = document.getElementById('b2');
	var b3 = document.getElementById('b3');

  	b2.style.display = 'none';
  	b3.style.display = 'none';

  function activa_a1(){
  	b1.style.display = '';
  	b2.style.display = 'none';
  	b3.style.display = 'none';
  	a1.setAttribute("class", "active");
  	a2.setAttribute("class", "");
  	a3.setAttribute("class", ""); 	
  }
  function activa_a2(){
  	b2.style.display = '';
  	b1.style.display = 'none';
  	b3.style.display = 'none';
  	a2.setAttribute("class", "active");
  	a1.setAttribute("class", "");
  	a3.setAttribute("class", ""); 	
  }
  function activa_a3(){
  	b3.style.display = '';
  	b2.style.display = 'none';
  	b1.style.display = 'none';
  	a3.setAttribute("class", "active");
  	a2.setAttribute("class", "");
  	a1.setAttribute("class", ""); 	
  }

</script>


</footer>

</body>
</html>