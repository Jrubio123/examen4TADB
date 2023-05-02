<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Editar Municipio</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Editar Municipio</h1>
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

            // Creamos un comando de consulta para la colección "municipios"
            $queryMunicipios = new MongoDB\Driver\Query($filter);

            // Ejecutamos el comando de consulta para la colección "municipios"
            try {
                $result = $manager->executeQuery('examen4.municipios', $queryMunicipios)->toArray();
                $municipio = $result[0];
            } catch (Exception $e) {
                printf("Error al obtener municipio con id %s: %s", $id, $e->getMessage());
            }

            // Creamos un comando de consulta para la colección "departamentos"
            $queryDepartamentos = new MongoDB\Driver\Query([]);

            // Ejecutamos el comando de consulta para la colección "departamentos"
            try {
                $result = $manager->executeQuery('examen4.departamentos', $queryDepartamentos)->toArray();
                $departamentos = $result;
            } catch (Exception $e) {
                printf("Error al obtener departamentos: %s", $e->getMessage());
            }

            // Mostramos el formulario de edición con los datos del municipio
            ?>
            <form action="editar_municipio.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $municipio->_id ?>">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $municipio->nombre_municipio ?>">
                <label for="departamento">Departamento:</label>
                <select name="departamento">
                    <?php foreach ($departamentos as $departamento) { ?>
                        <option value="<?php echo $departamento->nombre ?>" <?php if ($departamento->nombre == $municipio->nombre_departamento) {
                               echo 'selected';
                           } ?>>
                            <?php echo $departamento->nombre ?>
                        </option>
                    <?php } ?>
                </select>
                <button type="submit">Actualizar Municipio</button>
            </form>
            <?php
        } else {
            // Redirigimos al usuario de vuelta a la página de municipios si no se recibió un id válido
            header('Location: municipios.php');
        }

        // Verificamos si se envió un formulario para actualizar el municipio
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtenemos los datos del formulario
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $departamento = $_POST['departamento'];

            // Creamos un filtro para buscar el municipio con el id dado
            $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];

            // Creamos un comando de actualización para la colección "municipios"
            $update = new MongoDB\Driver\BulkWrite();
            $update->update($filter, [
                '$set' => [
                    'nombre_municipio' => $nombre,
                    'nombre_departamento' => $departamento
                ]
            ]);

            // Ejecutamos el comando de actualización para la colección "municipios"
            try {
                $result = $manager->executeBulkWrite('examen4.municipios', $update);
                printf("<p class='success'>Municipio actualizado exitosamente.</p>");
            } catch (Exception $e) {
                printf("<p class='error'>Error al actualizar municipio: %s</p>", $e->getMessage());
            }
        }
        ?>
    </main>

</body>
</html>