<?php
// sidebar.php
?>
<aside class="sidebar">
    <h1>Inventario</h1>
    <nav>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="categorias.php">Categorías</a></li>
            <li><a href="proveedores.php">Proveedores</a></li>
            
            <!-- Menú desplegable de Reportes -->
            <li>
                <a href="reportes.php" class="dropdown-toggle">Reportes</a>
                <ul class="dropdown">
                    <li><a href="reportes_ventas.php">Ventas</a></li>
                    <li><a href="reportes_inventario.php">Inventario</a></li>
                    <li><a href="reportes_proveedores.php">Proveedores</a></li>
                </ul>
            </li>
            
            <li><a href="configuracion.php">Configuración</a></li>
        </ul>
    </nav>
</aside>