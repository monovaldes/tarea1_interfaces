<?php
require_once "database.inc.php";
$dal = new DAL();
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" charset="utf-8" />
    <title>Tarea 1 Interfaces - 16744844-5</title>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <style type="text/css">html,body{background-color:#001A33;} </style>
		<script src="https://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
		<script type="text/javascript">
	  function initialize() {
	    var latlng = new google.maps.LatLng(-33.429149,-70.650742);
	    var myOptions = {
	      zoom: 8,
	      center: latlng,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    };
	    var map = new google.maps.Map(document.getElementById("map_canvas"),
	        myOptions);
	  }
		</script>

</head>
<body>
			<div class="navbar">
		  <div class="navbar-inner">
		    <a class="brand" href="#">ACME USM</a>
		    <ul class="nav">

		    </ul>
		  </div>
		</div>
  <div class="container">

		<div class="well">
		  <h2>Bienvenido!</h2>
		  <p>Ingresa tu Destino:</p>
		  <p>
						<input id="search" type="text" class="search-query" placeholder="destino"
						data-provide="typeahead" data-items="4">
				    <button type="submit" class="btn btn-primary">Ver</a>
		  </p>
		</div>
<div class=well>
<button class="close">&times;</button>
 <div id="map_canvas" style="width:900px; height:500px"></div>
</div>



  </div>
<footer>
	<script src="bootstrap/js/jquery.js"></script> 
	<script src="bootstrap/js/bootstrap.js"></script> 
	<script type="text/javascript">
		initialize()
		<?php
			$localidades = $dal->listado_localidades();
			$temp= array();
			foreach ($localidades as $loc) {
				array_push($temp, $loc->Nombre_localidad . "," . $loc->Nombre_comuna . "," . $loc->Nombre_region); 
			}
			
		?>
		var listado = <?php echo "['" . implode("','", $temp) . "']";?>  
		$('#search').typeahead({source: listado})  
	</script>
</footer>

</body>
</html>
