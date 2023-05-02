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
