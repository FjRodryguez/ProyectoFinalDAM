<?php
session_start();
function generarBotones() {
    return '
    <button type="button" class="btn btn-outline-primary me-2" onclick="inicioSesion()">Iniciar sesión</button>
    <button type="button" class="btn btn-primary" onclick="formulario()">Registrarse</button>
    ';
}

$html = generarBotones();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    if($_SESSION['premium'] === 1){
        $html = '<button type="button" class="btn btn-warning me-2">'. $_SESSION['nombre'] .'</button>';
    }else{
        $html = '<button type="button" class="btn btn-primary me-2">'. $_SESSION['nombre'] .'</button>';
    }
    $html .= '<a href="logout.php" class="btn btn-danger">Cerrar sesión</a>';
}

include "../html/index.html";
?>