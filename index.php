<?php
require_once "database.inc.php";
$dal = new DAL();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Tarea 1 Interfaces - 16744844-5</title>
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <div class="container">
		<div class="navbar">
		  <div class="navbar-inner">
		    <a class="brand" href="#">Ingresa tu Destino:</a>
		    <ul class="nav">
		    	<form class="navbar-search pull-left">
					<input id="search" type="text" class="search-query" placeholder="destino"
					data-provide="typeahead" data-items="4">
					</form>	
		    </ul>
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
		$('#search').typeahead({source: listado})  
	</script>
</footer>

</body>
</html>
