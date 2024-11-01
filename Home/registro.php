<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/registro.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form class="registration-form" action="../Registro&Seccion/registro.php" method="POST">
                <h2>Crear Cuenta</h2>
                <div class="input-group">
                    <input type="text" id="name" name="usuario" required>
                    <label for="name">Nombre de Usuario</label>
                </div>
                <div class="input-group">
                    <input type="email" id="email" name="email" required>
                    <label for="email">Correo Electrónico</label>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="contraseña" required>
                    <label for="password">Contraseña</label>
                </div>
                <div class="input-group">
                    <input type="password" id="confirm-password" name="confirmar_contraseña" required>
                    <label for="confirm-password">Confirmar Contraseña</label>
                </div>
                <button type="submit">Registrarse</button>
                <p class="login-link">¿Ya tienes una cuenta? <a href="#">Iniciar Sesión</a></p>
            </form>
        </div>
        <div class="image-container">
            <img src="images/perfume.png" alt="Perfume" class="perfume-image">
        </div>
    </div>
</body>
</html>