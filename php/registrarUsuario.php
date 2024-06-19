<?php
require_once 'conexion.php';
include "../html/formulario.html";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos= $_POST['apellidos'];
    $email = $_POST['email'];
    $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : "";
    $password = $_POST['password'];
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $conn = getConexion();
    $sql = "INSERT INTO usuarios (nombre, apellidos, email, telefono, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellidos, $email, $telefono, $hashedPassword);
    
    if ($stmt->execute()) {
        echo "<script>getModal();</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>