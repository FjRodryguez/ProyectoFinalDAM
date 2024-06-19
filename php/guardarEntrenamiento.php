<?php 
require_once 'conexion.php';
session_start();
$conn = getConexion();
function getIdParte($conn, $idEntrenamiento, $tabla){
    $sql = "INSERT INTO $tabla (id_entrenamiento) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idEntrenamiento);
    $stmt->execute();
    $idParte = $stmt->insert_id;
    return $idParte;
}
function insertarEjercicios($conn, $idParte, $seccionId) {
    if (isset($_POST[$seccionId]['repeticiones'])) {
        $repeticiones = $_POST[$seccionId]['repeticiones'];
        $metros = $_POST[$seccionId]['metros'];
        $minutos = $_POST[$seccionId]['minutos'];
        $segundos = $_POST[$seccionId]['segundos'];
        $estilo = $_POST[$seccionId]['estilo'];
        $tecnica = $_POST[$seccionId]['tecnica'];
        $ritmo = $_POST[$seccionId]['ritmo'];
        $material = $_POST[$seccionId]['material'];
        $totalEjercicios = count($repeticiones);
        $nombreTabla = "ejercicios_" . $seccionId;
        
        for ($i = 0; $i < $totalEjercicios; $i++) {
            $repeticion = $repeticiones[$i];
            $metro = $metros[$i];
            $minuto = (int)$minutos[$i];  
            $segundo = (int)$segundos[$i];  
            $tiempo = ($minuto * 60) + $segundo;
            $estiloEjercicio = $estilo[$i];
            $tecnicaEjercicio = $tecnica[$i];
            $ritmoEjercicio = $ritmo[$i];
            $materialEjercicio = $material[$i];
            
            $sql = "INSERT INTO $nombreTabla (id_parte, repeticiones, metros, tiempo, estilo, tecnica, ritmo, material)
                    VALUES ($idParte, '$repeticion', '$metro', '$tiempo', '$estiloEjercicio', '$tecnicaEjercicio', '$ritmoEjercicio', '$materialEjercicio')";
        
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $partes = array(
        "calentamiento",
        "parte_principal",
        "vuelta_calma"
    );
    
    $nombreEntrenamiento = $_POST['nombreEntrenamiento'];
    $id_usuario = $_SESSION['id']; 
    
    $sql = "INSERT INTO Entrenamientos (nombre, id_usuario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombreEntrenamiento, $id_usuario);
    $stmt->execute();
    $idEntrenamiento = $stmt->insert_id; 
    

    $idCalentamiento = getIdParte($conn, $idEntrenamiento, $partes[0]);
    insertarEjercicios($conn, $idCalentamiento, $partes[0]);

    $idPartePrincipal = getIdParte($conn, $idEntrenamiento, $partes[1]);
    insertarEjercicios($conn, $idPartePrincipal, $partes[1]);

    $idVueltaCalma = getIdParte($conn, $idEntrenamiento, $partes[2]);
    insertarEjercicios($conn, $idVueltaCalma, $partes[2]);

    $stmt->close();
    $conn->close();

    header("Location: ../php/misEntrenamientos.php");
    exit();
}
include "../html/crearEntrenamientos.html";
if (!isset($_SESSION['id'])){
    $mensaje = 'Necesitas iniciar sesión para crear un entrenamiento';
    echo "<script>getModal('$mensaje');</script>";
}else if ($_SESSION['premium'] === 0){
    $id_usuario = $_SESSION['id'];
    $sql = "SELECT COUNT(*) AS total_entrenamientos FROM entrenamientos WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $stmt->bind_result($total_entrenamientos);
    $stmt->fetch();
    
    if ($total_entrenamientos === 3) {
        $mensaje = 'Necesitas ser premium para poder tener más de 3 entrenamientos creados';
        echo "<script>getModal('$mensaje');</script>";
    }
    
    $stmt->close();
}
?>
