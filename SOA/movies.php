<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Películas</h1>

<form method="POST">
    <button type="submit" name="listar">Listar Películas</button>
    <button type="submit" name="contar_actores">Contar Actores por Película</button>

    <h3>Buscar películas por palabras clave en la sinopsis</h3>
    <input type="text" name="word1" placeholder="Palabra 1">
    <input type="text" name="word2" placeholder="Palabra 2">
    <button type="submit" name="buscar_sinopsis">Buscar</button>

    <h3>Buscar películas por actor</h3>
    <input type="text" name="actor_name" placeholder="Nombre del actor">
    <button type="submit" name="buscar_actor">Buscar</button>

    <h3>Filtrar por mejores puntuaciones</h3>
    <label>Desde:</label>
    <input type="date" name="startDate">
    <label>Hasta:</label>
    <input type="date" name="endDate">
    <button type="submit" name="filtrar_puntuaciones">Filtrar</button>
</form>

<?php

$data = file_get_contents('movies.json');
$movies = json_decode($data, true);

if (isset($_POST['listar'])) {
    echo "<h2>Lista de Películas</h2>";
    echo "<table>
            <tr>
                <th>Título</th>
                <th>Año</th>
                <th>Duración</th>
            </tr>";
    foreach ($movies as $movie) {
        echo "<tr>
                <td>" . $movie['title'] . "</td>
                <td>" . $movie['year'] . "</td>
                <td>" . $movie['duration'] . "</td>
              </tr>";
    }
    echo "</table>";
}

if (isset($_POST['contar_actores'])) {
    echo "<h2>Contar Actores por Película</h2>";
    echo "<table>
            <tr>
                <th>Título</th>
                <th>Actores/Actrices</th>
            </tr>";
    foreach ($movies as $movie) {
        $actorCount = count($movie['actors']);
        echo "<tr>
                <td>" . $movie['title'] . "</td>
                <td>" . $actorCount . "</td>
              </tr>";
    }
    echo "</table>";
}

if (isset($_POST['buscar_sinopsis'])) {
    $word1 = strtolower($_POST['word1']);
    $word2 = strtolower($_POST['word2']);

    echo "<h2>Buscar Películas por Palabras Clave</h2>";
    echo "<table>
            <tr>
                <th>Título</th>
                <th>Sinopsis</th>
            </tr>";
    foreach ($movies as $movie) {
        if (stripos(strtolower($movie['storyline']), $word1) !== false && stripos(strtolower($movie['storyline']), $word2) !== false) {
            echo "<tr>
                    <td>" . $movie['title'] . "</td>
                    <td>" . $movie['storyline'] . "</td>
                  </tr>";
        }
    }
    echo "</table>";
}

if (isset($_POST['buscar_actor'])) {
    $actorName = $_POST['actor_name'];

    echo "<h2>Buscar Películas por Actor</h2>";
    echo "<table>
            <tr>
                <th>Título</th>
            </tr>";
    foreach ($movies as $movie) {
        if (in_array($actorName, $movie['actors'])) {
            echo "<tr>
                    <td>" . $movie['title'] . "</td>
                  </tr>";
        }
    }
    echo "</table>";
}

if (isset($_POST['filtrar_puntuaciones'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $filteredMovies = array_filter($movies, function($movie) use ($startDate, $endDate) {
        return $movie['releaseDate'] >= $startDate && $movie['releaseDate'] <= $endDate;
    });

    usort($filteredMovies, function($a, $b) {
        $averageA = array_sum($a['ratings']) / count($a['ratings']);
        $averageB = array_sum($b['ratings']) / count($b['ratings']);
        return $averageB <=> $averageA;
    });

    echo "<h2>Top 3 Películas por Mejor Puntuación</h2>";
    echo "<table>
            <tr>
                <th>Título</th>
                <th>Póster</th>
            </tr>";
    for ($i = 0; $i < min(3, count($filteredMovies)); $i++) {
        echo "<tr>
                <td>" . $filteredMovies[$i]['title'] . "</td>
                <td><img src='" . $filteredMovies[$i]['posterurl'] . "' alt='" . $filteredMovies[$i]['title'] . "' width='100'></td>
              </tr>";
    }
    echo "</table>";
}

?>
</body>
</html>
