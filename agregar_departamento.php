<!DOCTYPE html>
<html>
<head>
	<title>Agregar departamento</title>
</head>
<body>
	<h1>Agregar departamento</h1>

	<?php
	// Conectarse a MongoDB
	$manager = new MongoDB\Driver\Manager("mongodb://mongoadmin:unaClav3@localhost:27017");

	// Procesar el formulario de creación de departamento
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Obtener los datos del formulario
		$nombre = $_POST['nombre'];

		// Insertar el nuevo departamento en la base de datos
		$bulk = new MongoDB\Driver\BulkWrite();
		$bulk->insert(['nombre' => $nombre]);
		$result = $manager->executeBulkWrite('examen4.departamentos', $bulk);

		// Redireccionar al usuario de vuelta a la lista de departamentos
		header('Location: departamento.php');
		exit;
	}
	?>

	<form method="post">
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre"><br>

		<input type="submit" value="Agregar departamento">
	</form>
</body>
</html>
