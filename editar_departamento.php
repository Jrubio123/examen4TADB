<!DOCTYPE html>
<html>
<head>
	<title>Editar departamento</title>
</head>
<body>
	<h1>Editar departamento</h1>

	<?php
	// Conectarse a MongoDB
	$manager = new MongoDB\Driver\Manager("mongodb://mongoadmin:unaClav3@localhost:27017");

	// Obtener el ID del departamento a editar
	$id = $_GET['id'];

	// Buscar el departamento por ID
	$filter = ['_id' => new MongoDB\BSON\ObjectID($id)];
	$options = [];
	$query = new MongoDB\Driver\Query($filter, $options);
	$result = $manager->executeQuery('examen4.departamentos', $query);
	$departamento = current($result->toArray());

	// Si el departamento no existe, mostrar un error
	if (!$departamento) {
		echo '<p>Error: El departamento no existe.</p>';
		exit;
	}

	// Procesar el formulario de edición de departamento
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Obtener los datos del formulario
		$nombre = $_POST['nombre'];

		// Actualizar los datos del departamento
		$bulk = new MongoDB\Driver\BulkWrite();
		$bulk->update(
			['_id' => new MongoDB\BSON\ObjectID($id)],
			['$set' => [
				'nombre' => $nombre,
			]]
		);
		$result = $manager->executeBulkWrite('examen4.departamentos', $bulk);

		// Redireccionar al usuario de vuelta a la lista de departamentos
		header('Location: departamento.php');
		exit;
	}
	?>

	<form method="post">
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre" value="<?php echo $departamento->nombre; ?>"><br>

		<input type="submit" value="Guardar cambios">
	</form>
</body>
</html>
