<?php
// Archivo: actualizar_descripcion.php

/* Iniciar la sesión y verificar si el usuario está logueado
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
    */

// Incluir el archivo de conexión
require_once '../db/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $producto_id = $_POST['producto_id'];
    $descripcion = $_POST['descripcion'];
    
    // Preparar la consulta SQL
    $sql = "UPDATE productos SET descripcion = ? WHERE id = ?";
    
    // Preparar y ejecutar la sentencia
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("si", $descripcion, $producto_id);
        
        if ($stmt->execute()) {
            // Éxito
            header("Location: productos.php");
        } else {
            // Error
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la descripción']);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
    }
    
    $conexion->close();
}
?>
