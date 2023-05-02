<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Borrar Tipo de Subsidio</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<header>
		<h1>Borrar Tipo de Subsidio</h1>
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

			// Creamos un filtro para buscar el tipo de subsidio con el id dado
			$filter = ['_id' => new MongoDB\BSON\ObjectId($id)];

			// Creamos un comando de eliminación para la colección "tipo_subsidio"
			$delete = new MongoDB\Driver\BulkWrite();
			$delete->delete($filter);

			// Ejecutamos el comando de eliminación para la colección "tipo_subsidio"
			try {
				$result = $manager->executeBulkWrite('examen4.tipo_subsidio', $delete);
				printf("<p class='success'>El tipo de subsidio ha sido eliminado correctamente.</p>");
				
			} catch (Exception $e) {
				printf("<p class='error'>Error al eliminar tipo de subsidio con id %s: %s</p>", $id, $e->getMessage());
			}
		} else {
			printf("<p class='error'>No se especificó el id del tipo de subsidio a eliminar.</p>");
		}
		?>
	</main>
</body>
</html>
