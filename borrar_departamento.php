<?php
require 'vendor/autoload.php';

// Conectamos con MongoDB usando las credenciales
$manager = new MongoDB\Driver\Manager('mongodb://mongoadmin:unaClav3@localhost:27017');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenemos el id del departamento a borrar
    $id = $_POST['id'];

    // Creamos un filtro para buscar el departamento con el id dado
    $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];

    // Creamos un comando de eliminación
    $command = new MongoDB\Driver\Command([
        'delete' => 'departamentos',
        'deletes' => [['q' => $filter, 'limit' => 1]],
        'writeConcern' => new MongoDB\Driver\WriteConcern(1)
    ]);

    // Ejecutamos el comando de eliminación
    try {
        $result = $manager->executeCommand('examen4', $command);
        printf("Departamento con id %s eliminado correctamente.", $id);
    } catch (Exception $e) {
        printf("Error al eliminar departamento con id %s: %s", $id, $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Borrar Departamento</title>
</head>
<body>
    <h1>Borrar Departamento</h1>
    <form method="POST">
        <label for="id">ID del departamento a borrar:</label>
        <input type="text" name="id">
        <input type="submit" value="Borrar">
    </form>
	<a href="departamento.php">Volver a departamento</a>
</body>
</html>
