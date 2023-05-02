<!DOCTYPE html>
<html>
<head>
	<title>Municipios</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		table {
		  border-collapse: collapse;
		  width: 100%;
		}

		th, td {
		  text-align: left;
		  padding: 8px;
		}

		tr:nth-child(even){background-color: #f2f2f2}

		th {
		  background-color: #4CAF50;
		  color: white;
		}
	</style>
</head>
<body>
	<h1>Municipios</h1>
	<table>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Departamento</th>
		</tr>
		<?php
			require_once "vendor/autoload.php";
			$collection = (new MongoDB\Client)->Examen4TopicosBasesDatos->municipios;

			$municipios = $collection->aggregate([
				[
					'$lookup' => [
						'from' => 'departamentos',
						'localField' => 'nombre_departamento',
						'foreignField' => 'nombre',
						'as' => 'departamento'
					]
				],
				[
					'$unwind' => '$departamento'
				],
				[
					'$project' => [
						'_id' => 1,
						'nombre_municipio' => 1,
						'nombre_departamento' => '$departamento.nombre'
					]
				]
			]);

			foreach ($municipios as $municipio) {
				echo "<tr>";
				echo "<td>" . $municipio->_id . "</td>";
				echo "<td>" . $municipio->nombre_municipio . "</td>";
				echo "<td>" . $municipio->nombre_departamento . "</td>";
				echo "</tr>";
			}
		?>
	</table>
</body>
</html>
