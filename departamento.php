<!DOCTYPE html>
<html>
<head>
    <title>Programas de Subsidios - Departamentos</title>
</head>
<body>
    <h1>Programas de Subsidios - Departamentos</h1>
    <?php
        $mongo = new MongoDB\Driver\Manager("mongodb://mongoadmin:unaClav3@localhost:27017");
        $query = new MongoDB\Driver\Query([]);
        $result = $mongo->executeQuery("examen4.departamentos", $query);
        if (!$result) {
            echo '<p>Error al realizar la consulta.</p>';
        } else {
            echo '<table>';
            echo '<tr><th>ID</th><th>Nombre</th><th>Acciones</th></tr>';
            foreach ($result as $document) {
                echo '<tr>';
                echo '<td>' . $document->_id . '</td>';
                echo '<td>' . $document->nombre . '</td>';
                echo '<td><a href="editar_departamento.php?id=' . $document->_id . '">Editar</a> | <a href="borrar_departamento.php?id=' . $document->_id . '">Borrar</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    ?>
    <br>
    <a href="agregar_departamento.php">Agregar departamento</a>
    <br>
    <a href="index.php">Volver a la página principal</a>
</body>
</html>
