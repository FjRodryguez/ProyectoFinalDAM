<?php 
require_once 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $conn = getConexion();
    $id_usuario = $_SESSION['id'];
    $sql = "SELECT premium FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        if($row['premium'] == 0){
            $sql = "UPDATE usuarios SET premium = 1 WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            if ($stmt->execute() === FALSE) {
                echo "Error al actualizar el usuario: " . $conn->error;
            }else{
                $_SESSION['premium'] = 1;
            }
        }
    }
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
    }
include "../html/pricing.html";
?>