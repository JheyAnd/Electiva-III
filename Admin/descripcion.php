<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['descripcion'];
    $id = $_POST['id'] ?? null;
    
    // Sanitizar el contenido HTML (opcional, dependiendo de tus necesidades)
    $descripcion = strip_tags($descripcion, '<p><br><strong><em><ul><ol><li><table><tr><td><th><img><a><h1><h2><h3><blockquote>');
    
    if ($id) {
        // Actualizar producto existente
        $sql = "UPDATE productos SET descripcion = ?, fecha_actualizacion = NOW() WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("si", $descripcion, $id);
    } else {
        // Insertar nuevo producto
        $sql = "INSERT INTO productos (descripcion, fecha_creacion, fecha_actualizacion) VALUES (?, NOW(), NOW())";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $descripcion);
    }
    
    $response = ['success' => false];
    
    if ($stmt->execute()) {
        $response['success'] = true;
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>