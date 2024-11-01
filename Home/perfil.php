<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario - Lociones y Fragancias</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            color: #333;
            transition: background-color 0.3s, color 0.3s;
        }

        header {
            background-color: #fff;
            color: #333;
            padding: 20px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        header img {
            width: 50px;
            height: auto;
        }

        header .theme-toggle {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        main {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: minmax(200px, auto);
            gap: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s ease, background-color 0.3s, color 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h2 {
            margin: 0;
            color: #444;
            font-size: 18px;
            transition: color 0.3s;
        }

        /* Estilos para la ventana modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            color: #333;
            width: 80%;
            max-width: 500px;
            text-align: left;
            transition: background-color 0.3s, color 0.3s;
        }

        .modal-content h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .modal-content p {
            margin-bottom: 15px;
            font-size: 16px;
            color: #555;
        }

        .dark-mode {
            background-color: #333;
            color: #fff;
        }

        .dark-mode header {
            background-color: #111;
            color: #fff;
        }

        .dark-mode .card {
            background-color: #444;
            color: #fff;
            border: 1px solid #666;
        }

        .dark-mode .card h2 {
            color: #fff;
        }

        .dark-mode .modal-content {
            background-color: #111;
            color: #fff;
        }

        .dark-mode .modal-content p {
            color: #ccc;
        }
    </style>
</head>
<body>

<header>
    <img src="logo.png" alt="Logo">
    <h1>Perfil de Usuario</h1>
    <button class="theme-toggle" onclick="toggleTheme()">Modo Noche</button>
</header>

<main>

    <!-- Tarjetas de perfil -->
    <div class="card" onclick="openModal('profileModal')">
        <h2>Información</h2>
    </div>
    <div class="card" onclick="openModal('loginSecurityModal')">
        <h2>Inicio de Sesión y Seguridad</h2>
    </div>
    <div class="card" onclick="openModal('giftsDiscountsModal')">
        <h2>Regalos y Descuentos</h2>
    </div>
    <div class="card" onclick="openModal('addressesModal')">
        <h2>Direcciones de Usuario</h2>
    </div>
    <div class="card" onclick="openModal('paymentsModal')">
        <h2>Tus Pagos</h2>
    </div>
    <div class="card" onclick="openModal('devicesModal')">
        <h2>Tus Dispositivos</h2>
    </div>

</main>

<!-- Modal Información -->
<div id="profileModal" class="modal" onclick="closeModal(event, 'profileModal')">
    <div class="modal-content">
        <h2>Información</h2>
        <p>Nombre: María López</p>
        <p>Correo: maria.lopez@example.com</p>
        <p>Teléfono: +57 321 555 5555</p>
        <p>Dirección: Calle 10 #25-30, Quibdó, Chocó</p>
    </div>
</div>

<!-- Modal Inicio de Sesión y Seguridad -->
<div id="loginSecurityModal" class="modal" onclick="closeModal(event, 'loginSecurityModal')">
    <div class="modal-content">
        <h2>Inicio de Sesión y Seguridad</h2>
        <p>Editar nombre de usuario y número de teléfono móvil</p>
    </div>
</div>

<!-- Modal Regalos y Descuentos -->
<div id="giftsDiscountsModal" class="modal" onclick="closeModal(event, 'giftsDiscountsModal')">
    <div class="modal-content">
        <h2>Regalos y Descuentos</h2>
        <p>Ver saldo y descuentos o canjear regalo</p>
    </div>
</div>

<!-- Modal Direcciones de Usuario -->
<div id="addressesModal" class="modal" onclick="closeModal(event, 'addressesModal')">
    <div class="modal-content">
        <h2>Direcciones de Usuario</h2>
        <p>Editar, eliminar o establecer una dirección predeterminada</p>
    </div>
</div>

<!-- Modal Tus Pagos -->
<div id="paymentsModal" class="modal" onclick="closeModal(event, 'paymentsModal')">
    <div class="modal-content">
        <h2>Tus Pagos</h2>
        <p>Ver todas las transacciones, administrar métodos de pago y configuraciones</p>
    </div>
</div>

<!-- Modal Tus Dispositivos -->
<div id="devicesModal" class="modal" onclick="closeModal(event, 'devicesModal')">
    <div class="modal-content">
        <h2>Tus Dispositivos</h2>
        <p>Solucionar problemas de dispositivos, administrar o cancelar suscripciones digitales</p>
    </div>
</div>

<script>
    // Función para abrir modal
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    // Función para cerrar modal al hacer clic fuera del contenido
    function closeModal(event, modalId) {
        if (event.target.classList.contains('modal')) {
            document.getElementById(modalId).style.display = 'none';
        }
    }

    // Función para alternar entre Modo Noche y Modo Día
    function toggleTheme() {
        document.body.classList.toggle('dark-mode');

        // Cambiar texto del botón de modo
        var themeToggleButton = document.querySelector('.theme-toggle');
        if (document.body.classList.contains('dark-mode')) {
            themeToggleButton.textContent = 'Modo Día';
        } else {
            themeToggleButton.textContent = 'Modo Noche';
        }
    }
</script>

</body>
</html>
