<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Borrar Municipio</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<header>
		<h1>Borrar Municipio</h1>
	</header>
	<main>
		<?php
		require 'vendor/autoload.php';

		// Conectamos con MongoDB usando las credenciales
		$manager = new MongoDB\Driver\Manager('mongodb://mongoadmin:unaClav3@localhost:27017');

		// Verificamos si se recibió un id de municipio como parámetro
		if (isset($_GET['id'])) {
			// Obtenemos el id de municipio de la url
			$id = $_GET['id'];

			// Creamos un filtro para buscar el municipio con el id dado
			$filter = ['_id' => new MongoDB\BSON\ObjectId($id)];

			// Creamos un comando de eliminación para la colección "municipios"
			$command = new MongoDB\Driver\BulkWrite();
			$command->delete($filter);

			// Ejecutamos el comando de eliminación para la colección "municipios"
			try {
				$result = $manager->executeBulkWrite('examen4.municipios', $command);
				printf("<p>El municipio con id %s ha sido borrado exitosamente.</p>", $id);
			} catch (Exception $e) {
				printf("<p>Error al borrar municipio con id %s: %s</p>", $id, $e->getMessage());
			}
		} else {
			// Redirigimos al usuario de vuelta a la página de municipios si no se recibió un id válido
			header('Location: municipios.php');
		}
		?>
		<a href="municipios.php">Regresar a la lista de municipios</a>
	</main>
</body>
</html>
