<?php
require 'vendor/autoload.php';

// Conectamos con MongoDB usando las credenciales
$manager = new MongoDB\Driver\Manager('mongodb://mongoadmin:unaClav3@localhost:27017');

// Creamos una opción para ordenar los municipios por nombre
$options = [
    'sort' => ['nombre_municipio' => 1]
];

// Creamos una consulta para obtener todos los municipios
$query = new MongoDB\Driver\Query([], $options);

// Ejecutamos la consulta
$cursor = $manager->executeQuery('examen4.municipios', $query);

// Creamos una tabla para mostrar los municipios
$table = '<table>';
$table .= '<tr><th>ID</th><th>Nombre Municipio</th><th>Nombre Departamento</th><th>Editar</th><th>Borrar</th></tr>';

foreach ($cursor as $municipio) {
    // Obtenemos el id, nombre y departamento del municipio
    $id = $municipio->_id;
    $nombre = $municipio->nombre_municipio;
    $departamento = $municipio->nombre_departamento;

    // Creamos una fila para el municipio
    $table .= "<tr><td>$id</td><td>$nombre</td><td>$departamento</td>";
    $table .= "<td><a href='editar_municipio.php?id=$id'>Editar</a></td>";
    $table .= "<td><a href='borrar_municipio.php?id=$id'>Borrar</a></td></tr>";
}

$table .= '</table>';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Municipios</title>
</head>
<body>
    <h1>Municipios</h1>
    <?php echo $table; ?>
    <br>
    <a href="agregar_municipio.php">Agregar Municipio</a>
    <br>
    <a href="departamento.php">Departamentos</a>
	<br>
    <a href="index.php">Inicio</a>
</body>
</html>
