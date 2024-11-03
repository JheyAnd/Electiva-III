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

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Preparar la consulta SQL
    $sql = "SELECT descripcion FROM productos WHERE id = ?";
    
    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $producto = $result->fetch_assoc();
            
            echo json_encode($producto);
        } else {
            echo json_encode(['error' => 'Error al obtener los datos del producto']);
        }
        
        $stmt->close();
    }
    
    $conexion->close();
}
?>