<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Imperial Essencial</title>
    <link rel="stylesheet" href="css/logi.css">
    <!-- Add Font Awesome for social icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        // Función para mostrar la alerta al hacer clic en el botón de Microsoft
        function showAlert() {
            alert("Estamos teniendo problemas con el autenticador. Por favor, inicia sesión con una cuenta de Google o crea una cuenta externa.");
        }
    </script>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <img src="images/logo.png" alt="Imperial Essencial Logo" class="logo">
            <h2>Welcome Back</h2>

            <!-- Mostrar mensaje de error si existe -->
            <?php if (isset($error) && !empty($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <!-- Formulario de inicio de sesión -->
            <form action="../Registro&Seccion/sesion.php" method="POST">
                <div class="input-group">
                    <input type="text" id="usuario" name="usuario" required placeholder=" ">
                    <label for="usuario">Usuario</label>
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="contraseña" required placeholder=" ">
                    <label for="password">Password</label>
                </div>
                <button type="submit">Sign In</button>
            </form>

            <!-- Social Login Options -->
            <div class="social-login">
                <div class="social-buttons">
                    <a href="google-login.php" class="google-btn">
                        <i class="fab fa-google"></i> 
                    </a>
                    <a href="#" class="microsoft-btn" onclick="showAlert()">
                        <i class="fab fa-microsoft"></i> 
                    </a>
                </div>
            </div>

            <div class="forgot-password">
                <a href="registro.php">Create an account</a>
            </div>
            <div class="forgot-password">
                <a href="#">Forgot password?</a>
            </div>
        </div>
        <div class="perfume-image">
            <!-- Aquí puedes agregar una imagen o contenido adicional -->
        </div>
    </div>
</body>
</html>
