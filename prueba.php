<?php
// Conectarse a la base de datos
$conexion = new MongoDB\Driver\Manager("mongodb://mongoadmin:unaClav3@localhost:27017");

// Crear la consulta
$consulta = new MongoDB\Driver\Query([
  'id_subsidio' => 2
], [
  'projection' => [
    '_id' => 1,
    'id_beneficiario' => 1
  ]
]);

// Ejecutar la consulta
$resultados = $conexion->executeQuery('examen4.asignacion_subsidios', $consulta);

// Obtener los resultados
foreach ($resultados as $resultado) {
  var_dump($resultado);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Consulta de subsidios</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
	<h2>Consulta de subsidios</h2>
	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>ID Beneficiario</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($resultados as $resultado): ?>
				<tr>
					<td><?php echo $resultado->_id; ?></td>
					<td><?php echo $resultado->id_beneficiario; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

</body>
</html>
