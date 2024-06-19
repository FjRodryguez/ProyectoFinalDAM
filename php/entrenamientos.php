<?php
session_start();
function cargarEntrenamientosDesdeJSON($archivo) {
    $contenido = file_get_contents($archivo);
    return json_decode($contenido, true); 
}

$rutaJSON = '../JSON/datos.json';
$datos = cargarEntrenamientosDesdeJSON($rutaJSON);

function mostrarContenido($nivel) {
    global $datos;
    $html = '';
    $i = 0;
    if (isset($datos['entrenamientos'])) {
        foreach ($datos['entrenamientos'] as $entrenamiento) {
            if ($entrenamiento['nivel'] === $nivel) {
                $html .= '<div class="card shadow-sm mb-4">
                <div class="card-body">
                <h4 class="nombre-entrenamiento">' . htmlspecialchars($entrenamiento['nombre']) . '</h4>
                <p class="card-text">' . htmlspecialchars($entrenamiento['descripcion']) . '</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                    <form action="../php/entrenamientos.php" method="POST">
                        <input type="hidden" name="id_entrenamiento" value="' . htmlspecialchars($entrenamiento['id']) . '">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Ver</button>
                    </form>
                    </div>
                </div>
                </div>
                </div>';
                $i++;
            }
        }
        return $html;
    } else {
        echo '<div class="error">No se encontraron entrenamientos.</div>';
    }
}

$principiante = mostrarContenido('Principiante');
$intermedio = mostrarContenido('Intermedio');
$avanzado = mostrarContenido('Avanzado');

function getParteEntrenamiento($entrenamiento, $parte){
    $html = '';
        $i = 1;
        $html .= '<table class="table table-striped">';
        $html .= '<thead class="thead-dark">
                    <tr>
                        <th scope="col">Ejercicio</th>
                        <th scope="col">Repeticiones</th>
                        <th scope="col">Metros</th>
                        <th scope="col">Tiempo</th>
                        <th scope="col">Estilo</th>
                        <th scope="col">Técnica</th>
                        <th scope="col">Ritmo</th>
                        <th scope="col">Material</th>
                    </tr>
                    </thead>
                    <tbody>';
        foreach ($entrenamiento[$parte] as $ejercicio) {
            $html .= '<tr>';
            $html .= '<th scope="row">Ejercicio ' . $i . '</th>';
            $html .= '<td>' . htmlspecialchars($ejercicio['repeticiones']) . '</td>';
            $html .= '<td>' . htmlspecialchars($ejercicio['metros']) . '</td>';
            $html .= '<td>' . htmlspecialchars($ejercicio['tiempo']) . '</td>';
            $html .= '<td>' . htmlspecialchars($ejercicio['estilo']) . '</td>';
            $html .= '<td>' . htmlspecialchars($ejercicio['tecnica']) . '</td>';
            $html .= '<td>' . htmlspecialchars($ejercicio['ritmo']) . '</td>';
            $html .= '<td>' . htmlspecialchars($ejercicio['material']) . '</td>';
            $html .= '</tr>';
            $i++;
        }
    
        $html .= '</tbody></table>';
        return $html;
}

function getEntrenamiento($entrenamientoEncontrado){
    $html = "<h2>Entrenamiento: " . $entrenamientoEncontrado['nombre'] . "</h2>";
    $html .= "<h3>Calentamiento:</h3>";
    $html .= getParteEntrenamiento($entrenamientoEncontrado, 'calentamiento');
    $html .= "<h3>Parte principal:</h3>";
    $html .= getParteEntrenamiento($entrenamientoEncontrado, 'parte_principal');
    $html .= "<h3>Vuelta a la calma:</h3>";
    $html .= getParteEntrenamiento($entrenamientoEncontrado, 'vuelta_a_la_calma');

    return $html;
}
function mostrarEntrenamiento($id) {
    global $datos;
    $id = intval($id);
    $entrenamientoEncontrado = null;
    if (isset($datos['entrenamientos'])) {
        foreach ($datos['entrenamientos'] as $entrenamiento) {
            if ($entrenamiento['id'] == $id) {
                $entrenamientoEncontrado = $entrenamiento;
            }
        }
    }

    if ($entrenamientoEncontrado) {
        if($entrenamientoEncontrado['nivel'] === "Avanzado"){
            if(isset($_SESSION['premium']) && $_SESSION['premium'] === 1){
                $html = getEntrenamiento($entrenamientoEncontrado);
            }else{
                $html = '<h4>Entrenamiento solo para premium</h4>';
                $html .= '<p><a class="btn btn-lg btn-primary" href="../php/pricing.php">Hazte premium</a></p>';
            }
        }else{
            $html = getEntrenamiento($entrenamientoEncontrado);
        }
        return $html;
    } else {
        echo '<p>Entrenamiento no encontrado.</p>';
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_entrenamiento = $_POST['id_entrenamiento'];
    $entrenamiento = mostrarEntrenamiento($id_entrenamiento);
    $entrenamiento .= '<div class="d-flex justify-content-right mt-3">
    <button id="btnDescargar" class="btn btn-primary">Descargar</button>
</div>';
}

include '../html/entrenamientos.html';
?>