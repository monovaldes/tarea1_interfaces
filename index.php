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
		  	<p><input name="puntosintermedios" id="puntosintermedios" type="checkbox" onClick="jeje()"> Seleccionar Puntos Intermedios</p>
		    <p><button type="submit" class="btn">Buscar</button></p>
		</div>
		<div id="locales" class="well">
			<?php  
			    $locales = $dal->establecimientos();
			    foreach ($locales as $punto) {
			?>

				<label class="checkbox">
					<input name="lugares[]" value="<?php echo $punto->Nombre; ?>" type="checkbox"> <?php echo $punto->Nombre; ?>
				</label>

			<?php
			 	}
			?>
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
	</script>

<script>
  var continue_button = document.getElementById('locales');
  continue_button.style.display = 'none';                
  var switchElement = document.getElementById('puntosintermedios')
  function jeje() {
        if (switchElement.checked)
                continue_button.style.display = '';
        else
                continue_button.style.display = 'none';                
  }
</script>


</footer>

</body>
</html>