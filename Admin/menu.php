<?php

// Puedes establecer una imagen de perfil predeterminada si no hay una definida
$imagen_perfil = $_SESSION['imagen_perfil'] ?? 'imagen/N1-1.png'; // Reemplaza con la ruta de tu imagen predeterminada
$nombre_usuario = $_SESSION['nombre'] ?? 'Admin'; // Asigna un nombre predeterminado si no hay ninguno
?>

<aside class="sidebar">
    <h1>Inventario</h1>
    
    <!-- Bloque para mostrar foto de perfil y nombre del usuario -->
    <div class="user-profile">
        <img src="<?php echo htmlspecialchars($imagen_perfil); ?>" alt="Foto de perfil" class="profile-img">
        <p class="user-name"><?php echo htmlspecialchars($nombre_usuario); ?></p>
        <a href="cerrar_sesion.php" class="logout-icon" title="Cerrar sesión">
            <img src="imagen/poder.png" alt="Cerrar sesión"> <!-- Reemplaza con la ruta de tu icono -->
        </a>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="categorias.php">Categorías</a></li>
            <li><a href="tipo_fragrancia.php">Fragancias</a></li>
            <li><a href="proveedores.php">Proveedores</a></li>
            
            <li>
                <a href="#" class="dropdown-toggle"><span class="arrow">▶</span> Reportes</a>
                <ul class="dropdown">
                    <li><a href="reportes_ventas.php">Ventas</a></li>
                    <li><a href="LibroMayor.php">Libro M-B</a></li>
                </ul>
            </li>
            
            <li>
                <a href="#" class="dropdown-toggle"><span class="arrow">▶</span> Configuración</a>
                <ul class="dropdown">
                    <li><a href="clientes.php">Clientes</a></li>
                    <li><a href="contenido_paginas.php">Contenido Páginas</a></li>
                    <li><a href="transacciones.php">Transacciones</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>

<script>
    // Alternar submenús
    document.querySelectorAll('.dropdown-toggle').forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            
            // Cerrar otros submenús
            document.querySelectorAll('.dropdown-toggle').forEach(function (otherToggle) {
                if (otherToggle !== toggle) {
                    otherToggle.classList.remove('active');
                    otherToggle.nextElementSibling.style.display = 'none';
                }
            });

            // Alternar el submenú actual
            const dropdown = toggle.nextElementSibling;
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                toggle.classList.remove('active');
            } else {
                dropdown.style.display = 'block';
                toggle.classList.add('active');
            }
        });
    });
</script>