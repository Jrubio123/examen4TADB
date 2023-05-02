<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Agregar Tipo de Subsidio</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<header>
		<h1>Agregar Tipo de Subsidio</h1>
	</header>
	<main>
		<?php
		require 'vendor/autoload.php';

		// Conectamos con MongoDB usando las credenciales
		$manager = new MongoDB\Driver\Manager('mongodb://mongoadmin:unaClav3@localhost:27017');

		// Verificamos si se envió el formulario
		if (isset($_POST['submit'])) {
			// Obtenemos los datos enviados por el formulario
			$idSubsidio = $_POST['id_subsidio'];
			$nombreSubsidio = $_POST['nombre_subsidio'];
			$montoSubsidio = $_POST['monto_subsidio'];

			// Verificamos si el id de subsidio ya existe en la base de datos
			$filter = ['id_subsidio' => $idSubsidio];
			$query = new MongoDB\Driver\Query($filter);
			$result = $manager->executeQuery('examen4.tipo_subsidio', $query)->toArray();
			if (count($result) > 0) {
				printf("<p class='error'>El id de subsidio '%s' ya existe en la base de datos.</p>", $idSubsidio);
			} else {
				// Creamos un documento con los datos del nuevo tipo de subsidio
				$tipoSubsidio = [
					'id_subsidio' => $idSubsidio,
					'nombre_subsidio' => $nombreSubsidio,
					'monto_subsidio' => $montoSubsidio,
				];

				// Creamos un comando de inserción para la colección "tipo_subsidio"
				$insert = new MongoDB\Driver\BulkWrite();
				$insert->insert($tipoSubsidio);

				// Ejecutamos el comando de inserción para la colección "tipo_subsidio"
				try {
					$result = $manager->executeBulkWrite('examen4.tipo_subsidio', $insert);
					printf("<p class='success'>El tipo de subsidio '%s' ha sido agregado correctamente.</p>", $nombreSubsidio);
				} catch (Exception $e) {
					printf("<p class='error'>Error al agregar tipo de subsidio '%s': %s</p>", $nombreSubsidio, $e->getMessage());
				}
			}
		}

		// Mostramos el formulario para agregar un nuevo tipo de subsidio
		?>
		<form method="POST">
			<p>
				<label for="id_subsidio">ID Subsidio:</label>
				<input type="text" name="id_subsidio" required>
			</p>
			<p>
				<label for="nombre_subsidio">Nombre Subsidio:</label>
				<input type="text" name="nombre_subsidio" required>
			</p>
			<p>
				<label for="monto_subsidio">Monto Subsidio:</label>
				<input type="number" name="monto_subsidio"required>
</p>
<input type="submit" name="submit" value="Agregar">
</form>
<a href="tipo_subsidio.php" class="back-button">Regresar</a>
</main>

</body>
</html>
