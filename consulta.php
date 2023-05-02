<?php
// Conectarse a la base de datos
$conexion = new MongoDB\Driver\Manager("mongodb://mongoadmin:unaClav3@localhost:27017");

// Obtener los datos del formulario
$mes = sprintf('%02d', $_POST['mes']);
$ano = $_POST['ano'];
$tipo = $_POST['tipo'];

// Crear la consulta de agregación
$consulta = [
  [
    '$lookup' => [
      'from' => 'beneficiarios',
      'localField' => 'id_beneficiario',
      'foreignField' => 'id_beneficiario',
      'as' => 'beneficiario'
    ]
  ],
  [
    '$unwind' => '$beneficiario'
  ],
  [
    '$match' => [
      'fecha_asignacion' => [
        '$gte' => new MongoDB\BSON\UTCDateTime(strtotime("$ano-$mes-01") * 1000),
        '$lt' => new MongoDB\BSON\UTCDateTime(strtotime("$ano-$mes-01 +1 month") * 1000)
      ],
      'id_subsidio' => intval($tipo),
      'beneficiario.genero' => 'femenino'
    ]
  ],
  [
    '$group' => [
      '_id' => null,
      'count' => ['$sum' => 1]
    ]
  ],
  [
    '$project' => [
      '_id' => 0,
      'count' => 1
    ]
  ]
];

// Ejecutar la consulta
$comando = new MongoDB\Driver\Command([
  'aggregate' => 'asignacion_subsidios',
  'pipeline' => $consulta
]);

$resultados = $conexion->executeQuery('examen4.asignacion_subsidios', new MongoDB\Driver\Query($consulta), ['cursor' => 'mongodb']);


// Obtener el resultado
if (!$resultados) {
  $resultado = 'No se encontraron resultados';
} else {
  $documento = current($resultados->toArray());
  $resultado = 'El número de mujeres con subsidio tipo ' . $tipo . ' en el mes de ' . $mes . ' del año ' . $ano . ' es: ' . $documento->count;
}
?>
