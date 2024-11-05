<?php
session_start(); // Se agregó el punto y coma
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Asegúrate de que el archivo CSS esté bien enlazado -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Añadido jQuery -->
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="logo">
                <img src="../Home/images/logo.png" alt="Logo" class="logo-img"> <!-- Cambia por la ruta correcta -->
            </div>
            
            <!-- Login Form -->
            <div id="login-form" class="form-content">
                <h1>Welcome Back Admin</h1>
                <form method="post" action="sesion_admin.php">
                    <div class="input-group">
                        <label for="username">Usuario</label>
                        <input type="text" id="username" name="usuario" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="contraseña" required>
                    </div>
                    <button type="submit" name="login" class="sign-in-btn">Sign In</button>
                </form>
                <p class="switch-form">New admin? <a href="#" id="show-register">Create an account</a></p>
                <p class="forgot-password"><a href="#">Forgot password?</a></p>
            </div>

            <!-- Register Form -->
            <div id="register-form" class="form-content" style="display: none;">
                <h2>Register New Admin</h2>
                <form id="adminRegisterForm" method="post" action="registro_admin.php">
                    <div class="input-group">
                        <label for="reg-name">Nombre</label>
                        <input type="text" id="reg-name" name="nombre" required>
                    </div>
                    <div class="input-group">
                        <label for="reg-email">Correo electrónico</label>
                        <input type="email" id="reg-email" name="correo" required>
                    </div>
                    <div class="input-group">
                        <label for="reg-username">Usuario de acceso</label>
                        <input type="text" id="reg-username" name="usuario" required>
                    </div>
                    <div class="input-group">
                        <label for="reg-password">Clave de acceso</label>
                        <input type="password" id="reg-password" name="contraseña" required>
                    </div>
                    <div class="input-group">
                        <label for="reg-cedula">Cédula</label>
                        <input type="text" id="reg-cedula" name="cedula" required>
                    </div>
                    <div class="input-group">
                        <label for="reg-phone">Teléfono de contacto</label>
                        <input type="tel" id="reg-phone" name="telefono" required>
                    </div>
                    <button type="submit" name="register" class="sign-in-btn">Register</button>
                </form>
                <p class="switch-form"><a href="#" id="show-login">Back to Login</a></p>
            </div>
        </div>
        <div class="image-container">
            <!-- Imagen de fondo, definida en CSS -->
        </div>
    </div>
    
    <!-- Modal para el código de verificación -->
    <div id="verificationModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Verificar Código</h2>
            <form id="verificationForm" method="post" action="verificar_codigo.php">
                <label for="codigo">Ingrese su código de verificación</label>
                <input type="text" id="codigo" name="codigo" required>
                <input type="hidden" name="correo" id="correo" id="hiddenCorreo">
                <button type="submit">Verificar</button>
            </form>
        </div>
    </div>

    <!-- Modal de error -->
    <div id="errorModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Error</h2>
            <p id="errorMessage"></p>
            <button id="closeErrorModal">Cerrar</button>
        </div>
    </div>

    <script>
        // Alternar entre el formulario de login y registro
        document.getElementById('show-register').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        });

        document.getElementById('show-login').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('register-form').style.display = 'none';
        });

        document.getElementById('adminRegisterForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const password = document.getElementById('reg-password').value;
            const forbiddenWords = ["admin", "administrador"];

            // Validación de contraseña
            if (!validatePassword(password, forbiddenWords)) {
                showErrorModal("La contraseña debe tener al menos 8 caracteres, incluir letras, números y caracteres especiales, y no puede contener palabras como 'admin' o 'administrador'.");
                return;
            }

            // Continuar con el envío si la contraseña es válida
            submitForm(this);
        });

        // Validación de la contraseña
        function validatePassword(password, forbiddenWords) {
            return password.length >= 8 && 
                   /[a-zA-Z]/.test(password) && 
                   /\d/.test(password) && 
                   /[\W_]/.test(password) && 
                   !forbiddenWords.some(word => password.toLowerCase().includes(word));
        }

        // Enviar el formulario usando AJAX
        function submitForm(formElement) {
            const formData = $(formElement).serialize(); // Serializa los datos del formulario
            const action = $(formElement).attr('action');

            $.ajax({
                type: 'POST',
                url: action,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#hiddenCorreo').val(data.correo);
                        $('#verificationModal').show();
                    } else {
                        showErrorModal(data.message);
                    }
                },
                error: function() {
                    showErrorModal("Ocurrió un error al procesar tu solicitud. Intenta nuevamente.");
                }
            });
        }
        $('#verificationForm').on('submit', function(e) {
    e.preventDefault(); // Prevenir el comportamiento predeterminado del formulario

    const codigo = $('#codigo').val();
    const correo = $('#correo').val(); // Obtener el correo del campo oculto
    const action = $(this).attr('action'); // Obtener la URL del atributo action del formulario

    $.ajax({
        type: 'POST',
        url: action,
        data: { codigo: codigo, correo: correo }, // Enviar el código y el correo
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                $('#verificationModal').hide(); // Cerrar el modal
                window.location.href = 'index.php'; // Redirigir al usuario
            } else {
                showErrorModal(response.message); // Mostrar el mensaje de error
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            showErrorModal("Ocurrió un error al verificar el código. Intenta nuevamente.");
        }
    });
});





        // Mostrar el modal de error
        function showErrorModal(message) {
            $('#errorMessage').text(message);
            $('#errorModal').show();
        }

        // Cerrar los modales
        $('.close').on('click', function() {
            $(this).closest('.modal').hide();
        });

        // Cerrar el modal de error al hacer clic en el botón "Cerrar"
        $('#closeErrorModal').on('click', function() {
            $('#errorModal').hide();
        });

        // Cerrar el modal de verificación cuando se hace clic fuera del modal
        $(window).on('click', function(event) {
            if ($(event.target).is('#verificationModal')) {
                $('#verificationModal').hide();
            }
            if ($(event.target).is('#errorModal')) {
                $('#errorModal').hide();
            }
        });
    </script>
</body>
</html>
