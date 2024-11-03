<?php
include("../db/conexion.php");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM productos WHERE id = $id";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
        echo json_encode($producto);
    } else {
        echo json_encode([]);
    }
}
?>
