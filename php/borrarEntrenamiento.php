<?php
require_once 'conexion.php';
session_start();
$conn = getConexion();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION['id'];
    $id_entrenamiento = $_POST['entrenamiento_id_borrar'];

    $conn->begin_transaction();

    try {

        $sql = "DELETE FROM ejercicios_vuelta_calma WHERE id_parte IN (SELECT id_vuelta_calma FROM vuelta_calma WHERE id_entrenamiento = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_entrenamiento);
        $stmt->execute();
        $stmt->close();

        // Borrar vuelta a la calma
        $sql = "DELETE FROM vuelta_calma WHERE id_entrenamiento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_entrenamiento);
        $stmt->execute();
        $stmt->close();

        $sql = "DELETE FROM ejercicios_parte_principal WHERE id_parte IN (SELECT id_parte_principal FROM parte_principal WHERE id_entrenamiento = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_entrenamiento);
        $stmt->execute();
        $stmt->close();

        $sql = "DELETE FROM parte_principal WHERE id_entrenamiento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_entrenamiento);
        $stmt->execute();
        $stmt->close();

        $sql = "DELETE FROM ejercicios_calentamiento WHERE id_parte IN (SELECT id_calentamiento FROM calentamiento WHERE id_entrenamiento = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_entrenamiento);
        $stmt->execute();
        $stmt->close();

        $sql = "DELETE FROM calentamiento WHERE id_entrenamiento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_entrenamiento);
        $stmt->execute();
        $stmt->close();

        $sql = "DELETE FROM entrenamientos WHERE id_entrenamiento = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_entrenamiento);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        $conn->close();
        header("Location: misEntrenamientos.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error al intentar borrar el entrenamiento: " . $e->getMessage();
    }
}
?>