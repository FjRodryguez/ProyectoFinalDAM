<?php 
require_once 'conexion.php';
session_start();
$conn = getConexion();
function getEntrenamientos($conn){
    $id_usuario = $_SESSION['id'];
    $sql = "SELECT id_entrenamiento, nombre FROM entrenamientos WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $html = '';
        while($row = $result->fetch_assoc()) {

            $html .= '<div class="col-md-4">
            <div class="card shadow-sm mb-4">
            <div class="card-body">
            <h4 class="nombre-entrenamiento">'. $row["nombre"] . '</h4>
            <p class="card-text"></p>
            <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
            <form action="../php/misEntrenamientos.php" method="POST">
                <input type="hidden" name="entrenamiento_id" value="' . $row["id_entrenamiento"] . '">
                <input type="hidden" name="entrenamiento_nombre" value="' . $row["nombre"] . '">
                <button type="submit" class="btn btn-sm btn-outline-secondary">Ver</button>
            </form>
            <form action="../php/borrarEntrenamiento.php" method="POST">
                <input type="hidden" name="entrenamiento_id_borrar" value="' . $row["id_entrenamiento"] . '">
                <button type="submit" class="btn btn-sm btn-outline-danger">Borrar</button>
            </form>
            </div>
            </div>
            </div>
            </div>
            </div>';
        }
        return $html;
    }else{
        $stmt->close();
        $conn->close();
    }
}

function getEntrenamiento($result) {
    $html = '';
    if ($result->num_rows > 0) {
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
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<th scope="row">Ejercicio ' . $i . '</th>';
            $html .= '<td>' . $row['repeticiones'] . '</td>';
            $html .= '<td>' . $row['metros'] . '</td>';
            $html .= '<td>' . $row['tiempo'] . '</td>';
            $html .= '<td>' . $row['estilo'] . '</td>';
            $html .= '<td>' . $row['tecnica'] . '</td>';
            $html .= '<td>' . $row['ritmo'] . '</td>';
            $html .= '<td>' . $row['material'] . '</td>';
            $html .= '</tr>';
            $i++;
        }
        $html .= '</tbody></table>';
    }
    return $html;
}
if(isset($_SESSION['id'])){
    $html = getEntrenamientos($conn);
}else{
    $html = '<h4>Regístrate o inicia sesion para crear y ver tus propios entrenamientos</h4>';
    $html .= '<div class="row">
    <div class="col-auto">
        <p><a class="btn btn-outline-primary me-2" href="../php/login.php">Iniciar sesión</a></p>
    </div>
    <div class="col-auto">
        <p><a class="btn btn-primary" href="../php/registrarUsuario.php">Registrarse</a></p>
    </div>
</div>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_entrenamiento = $_POST['entrenamiento_id'];
    $entrenamiento_nombre = $_POST['entrenamiento_nombre'];
    $entrenamientos = '';
    $sql = "SELECT ec.*
        FROM ejercicios_calentamiento ec
        JOIN calentamiento c ON ec.id_parte = c.id_calentamiento
        WHERE c.id_entrenamiento = $id_entrenamiento";

    $result = $conn->query($sql);
    $entrenamientos = "<h2>Entrenamiento: " . $entrenamiento_nombre . "</h2>";
    $entrenamientos .= "<h3>Calentamiento:</h3>";
    $entrenamientos .= getEntrenamiento($result);

    $sql = "SELECT ep.*
        FROM ejercicios_parte_principal ep
        JOIN parte_principal pp ON ep.id_parte = pp.id_parte_principal
        WHERE pp.id_entrenamiento = $id_entrenamiento";

    $result = $conn->query($sql);
    $entrenamientos .= "<h3>Parte principal:</h3>";
    $entrenamientos .= getEntrenamiento($result);

    $sql = "SELECT ev.*
        FROM ejercicios_vuelta_calma ev
        JOIN vuelta_calma vc ON ev.id_parte = vc.id_vuelta_calma
        WHERE vc.id_entrenamiento = $id_entrenamiento";

    $result = $conn->query($sql);
    $entrenamientos .= "<h3>Vuelta a la calma:</h3>";
    $entrenamientos .= getEntrenamiento($result);

    $entrenamientos .= '<div class="d-flex justify-content-right mt-3">
        <button id="btnDescargar" class="btn btn-primary">Descargar</button>
    </div>';

}

include "../html/misEntrenamientos.html";
?>