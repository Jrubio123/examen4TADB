<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Editar Tipo de Subsidio</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<header>
		<h1>Editar Tipo de Subsidio</h1>
	</header>
	<main>
		<?php
		require 'vendor/autoload.php';

		// Conectamos con MongoDB usando las credenciales
		$manager = new MongoDB\Driver\Manager('mongodb://mongoadmin:unaClav3@localhost:27017');

		// Verificamos si se recibió un id de tipo de subsidio como parámetro
		if (isset($_GET['id'])) {
			// Obtenemos el id de tipo de subsidio de la url
			$id = $_GET['id'];

			if (isset($_POST['submit'])) {
				// Obtenemos los datos enviados por el formulario
				$nuevoNombreSubsidio = $_POST['nombre_subsidio'];
				$nuevoMontoSubsidio = $_POST['monto_subsidio'];

				// Creamos un filtro para buscar el tipo de subsidio con el id dado
				$filter = ['_id' => new MongoDB\BSON\ObjectId($id)];

				// Creamos un comando de actualización para la colección "tipo_subsidio"
				$update = new MongoDB\Driver\BulkWrite();
				$update->update(
					$filter,
					['$set' => [
						'nombre_subsidio' => $nuevoNombreSubsidio,
						'monto_subsidio' => $nuevoMontoSubsidio,
					]],
					['multi' => false, 'upsert' => false]
				);

				// Ejecutamos el comando de actualización para la colección "tipo_subsidio"
				try {
					$result = $manager->executeBulkWrite('examen4.tipo_subsidio', $update);
					printf("<p class='success'>El tipo de subsidio ha sido actualizado correctamente.</p>");
				} catch (Exception $e) {
					printf("<p class='error'>Error al actualizar tipo de subsidio con id %s: %s</p>", $id, $e->getMessage());
				}
			}

			// Creamos un filtro para buscar el tipo de subsidio con el id dado
			$filter = ['_id' => new MongoDB\BSON\ObjectId($id)];

			// Creamos un comando de consulta para la colección "tipo_subsidio"
			$queryTipoSubsidio = new MongoDB\Driver\Query($filter);

			// Ejecutamos el comando de consulta para la colección "tipo_subsidio"
			try {
				$result = $manager->executeQuery('examen4.tipo_subsidio', $queryTipoSubsidio)->toArray();
				$tipoSubsidio = $result[0];
			} catch (Exception $e) {
				printf("Error al obtener tipo de subsidio con id %s: %s", $id, $e->getMessage());
			}

			// Mostramos el formulario para editar el tipo de subsidio
			?>
			<form method="POST">
				<p>
					<label for="nombre_subsidio">Nombre del Subsidio:</label>
				<input type="text" id="nombre_subsidio" name="nombre_subsidio" value="<?php echo $tipoSubsidio->nombre_subsidio; ?>" required>
			</p>
			<p>
				<label for="monto_subsidio">Monto del Subsidio:</label>
				<input type="number" id="monto_subsidio" name="monto_subsidio" value="<?php echo $tipoSubsidio->monto_subsidio; ?>" min="0" step="0.01" required>
			</p>
			<button type="submit" name="submit">Guardar Cambios</button>
		</form>
		<?php
	} else {
		// Si no se recibió un id de tipo de subsidio como parámetro, mostramos un error
		printf("<p class='error'>Error: Se debe especificar un id de tipo de subsidio.</p>");
	}
	?>
	<a href="tipo_subsidio.php" class="button"> regresar a tipos de subsidios</a>
</main>
</body>
</html>
