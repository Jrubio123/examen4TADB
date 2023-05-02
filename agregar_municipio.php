<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Agregar Municipio</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
	<header>
		<h1>Agregar Municipio</h1>
	</header>
	<main>
		<?php
		require 'vendor/autoload.php';

		// Conectamos con MongoDB usando las credenciales
		$manager = new MongoDB\Driver\Manager('mongodb://mongoadmin:unaClav3@localhost:27017');

		// Creamos un comando de consulta para la colección "departamentos"
		$queryDepartamentos = new MongoDB\Driver\Query([]);

		// Ejecutamos el comando de consulta para la colección "departamentos"
		try {
			$result = $manager->executeQuery('examen4.departamentos', $queryDepartamentos)->toArray();
			$departamentos = $result;
		} catch (Exception $e) {
			printf("Error al obtener departamentos: %s", $e->getMessage());
		}

		// Verificamos si se envió un formulario para agregar un nuevo municipio
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Obtenemos los datos del formulario
			$nombre = $_POST['nombre'];
			$departamento = $_POST['departamento'];

			// Creamos un documento con los datos del municipio
			$municipio = [
				'nombre_municipio' => $nombre,
				'nombre_departamento' => $departamento,
			];

			// Creamos un comando de inserción para la colección "municipios"
			$bulk = new MongoDB\Driver\BulkWrite;
			$bulk->insert($municipio);

			// Ejecutamos el comando de inserción para la colección "municipios"
			try {
				$result = $manager->executeBulkWrite('examen4.municipios', $bulk);
				echo "<p>El municipio $nombre ha sido agregado exitosamente.</p>";
			} catch (Exception $e) {
				printf("Error al agregar municipio: %s", $e->getMessage());
			}
		}
		?>
		<form action="agregar_municipio.php" method="POST">
			<label for="nombre">Nombre:</label>
			<input type="text" name="nombre" required>
			<label for="departamento">Departamento:</label>
			<select name="departamento" required>
				<option value="">Selecciona un departamento</option>
				<?php foreach ($departamentos as $departamento) { ?>
					<option value="<?php echo $departamento->nombre ?>"><?php echo $departamento->nombre ?></option>
				<?php } ?>
			</select>
			<button type="submit">Agregar Municipio</button>
		</form>
		<a href="municipios.php">Volver a Municipios</a>
	</main>
</body>
</html>
