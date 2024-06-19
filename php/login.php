<?php
session_start();

require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $conn = getConexion();
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['premium'] = $row['premium'];
            $_SESSION['loggedin'] = true;
            header("Location: index.php");
            exit();
        } else {
            $mensaje = '<p style="color: red;">Contraseña incorrecta</p>';
        }
    } else {
        echo "Usuario no encontrado.";
    }
    
    $stmt->close();
    $conn->close();
}
include "../html/login.html";
?>