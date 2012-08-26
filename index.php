<?php
require "db_mysql.php";
$mysql = new mysql(); 
$mysql->connect();
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
			// Ejecutar la consulta
			$resultado = $mysql->query("SELECT * FROM Localidad");


			// Usar el resultado
			// Si se intenta imprimir $resultado no será posible acceder a la información del recurso
			// Se debe usar una de las funciones de resultados de mysql
			// Consulte también mysql_result(), mysql_fetch_array(), mysql_fetch_row(), etc.
			while ($fila = mysql_fetch_assoc($resultado)) {
			    $localidades[] = $fila['Nombre_localidad'];
			}

			// Liberar los recursos asociados con el conjunto de resultados
			// Esto se ejecutado automáticamente al finalizar el script.
			mysql_free_result($resultado);
		?>


 		var subjects = <?php echo $localidades?>;   
		$('#search').typeahead({source: subjects})  
	</script>
</footer>

</body>
</html>
