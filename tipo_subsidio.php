<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Tipo de Subsidio</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
	<header>
		<h1>Tipo de Subsidio</h1>
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

			// Creamos un comando de consulta para la colección "tipo_subsidio"
			$queryTipoSubsidio = new MongoDB\Driver\Query($filter);

			// Ejecutamos el comando de consulta para la colección "tipo_subsidio"
			try {
				$result = $manager->executeQuery('examen4.tipo_subsidio', $queryTipoSubsidio)->toArray();
				$tipoSubsidio = $result[0];
			} catch (Exception $e) {
				printf("Error al obtener tipo de subsidio con id %s: %s", $id, $e->getMessage());
			}

			// Mostramos los detalles del tipo de subsidio
			?>
			<h2>
				<?php echo $tipoSubsidio->nombre_subsidio ?>
			</h2>
			<p><strong>ID de subsidio:</strong>
				<?php echo $tipoSubsidio->id_subsidio ?>
			</p>
			<p><strong>Monto de subsidio:</strong>
				<?php echo $tipoSubsidio->monto_subsidio ?>
			</p>
			<div class="button-container">
				<a href="editar_tipo_subsidio.php?id=<?php echo $tipoSubsidio->_id ?>" class="button">Editar</a>
				<a href="borrar_tipo_subsidio.php?id=<?php echo $tipoSubsidio->_id ?>" class="button"
					onclick="return confirm('¿Está seguro de que desea eliminar este tipo de subsidio?')">Borrar</a>
				<a href="tipo_subsidio.php" class="button">Agregar Nuevo Tipo de Subsidio</a>
				<a href="index.php" class="button">Volver a Inicio</a>
			</div>
			<?php
		} else {
			// Creamos un comando de consulta para la colección "tipo_subsidio"
			$queryTipoSubsidio = new MongoDB\Driver\Query([]);

			// Ejecutamos el comando de consulta para la colección "tipo_subsidio"
			try {
				$result = $manager->executeQuery('examen4.tipo_subsidio', $queryTipoSubsidio)->toArray();
				$tipoSubsidios = $result;
			} catch (Exception $e) {
				printf("Error al obtener los tipos de subsidio: %s", $e->getMessage());
			}
			// Mostramos la lista de tipos de subsidio
			?>
			<table>
				<thead>
					<tr>
						<th>ID de Subsidio</th>
						<th>Nombre de Subsidio</th>
						<th>Monto de Subsidio</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($tipoSubsidios as $tipoSubsidio) { ?>
						<tr>
							<td>
								<?php echo $tipoSubsidio->id_subsidio ?>
							</td>
							<td>
								<?php echo $tipoSubsidio->nombre_subsidio ?>
							</td>
							<td>
								<?php echo $tipoSubsidio->monto_subsidio ?>
							</td>
							<td>
								
								<a href="editar_tipo_subsidio.php?id=<?php echo $tipoSubsidio->_id ?>" class="button">Editar</a>
								<a href="borrar_tipo_subsidio.php?id=<?php echo $tipoSubsidio->_id ?>" class="button"
									onclick="return confirm('¿Está seguro de que desea eliminar este tipo de subsidio?')">Borrar</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<div class="button-container">
				<a href="agregar_tipo_subsidio.php" class="button">Agregar Nuevo Tipo de Subsidio</a>
				<a href="index.php" class="button">Volver a Inicio</a>
			</div>
			<?php
		}
		?>
	</main>

</body>

</html>