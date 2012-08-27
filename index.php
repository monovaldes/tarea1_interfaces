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
		  <p>Ingresa tu Destino:
						<input id="search" class="search-query" placeholder="destino"
						data-provide="typeahead" data-items="4" autocomplete="off">
		  </p>
		</div>
	<div class=well>
	<button class="close">&times;</button>
		<div id="mapa">
			<IMG style="align:center" class="img-polaroid" SRC="google-maps.png">
		</div>
	</div>


  </div>
<footer>
	<script src="bootstrap/js/jquery.js"></script> 
	<script src="bootstrap/js/bootstrap.js"></script> 
	<script type="text/javascript">
		<?php
			$localidades = $dal->listado_localidades();
			$temp= array();
			foreach ($localidades as $loc) {
				array_push($temp, $loc->Nombre_localidad . "," . $loc->Nombre_comuna . "," . $loc->Nombre_region); 
			}
			
		?>
		var listado = <?php echo "['" . implode("','", $temp) . "']";?>  
		$('#search').typeahead({
			source: listado,
			 updater:function (item) {
	        //item = selected item
			var substr = item.split(',');
			var nombre_localidad = substr[0];					
			//llamar a mapa.php y pegaro en la div id mapa

        return item;
    	}
		})  
	</script>
</footer>

</body>
</html>