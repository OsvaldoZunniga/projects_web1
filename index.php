<?php
require_once 'database/connection.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SubiteyReza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css?v=2">


</head>
<body>
    <!-- alertas que muestra diferentes mensajes segun lo que se reciba en la URL con el $_GET -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="container mt-3">
            <?php if ($_GET['msg'] == 'pending'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                     Tu cuenta está pendiente de activación. Revisa tu correo para activarla.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'activated'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Tu cuenta ha sido activada correctamente. Ahora puedes iniciar sesión.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'inactive'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Tu cuenta está inactiva. Contacta al administrador.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'invalid'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Enlace inválido o cuenta ya activada.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'user_not_found'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Usuario no encontrado.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'wrong_pass'): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Contraseña incorrecta.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'passwrd_!match'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Las contraseñas no coinciden.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'img_upload_error'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Error al subir la imagen. Por favor, intenta de nuevo.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'logout_success'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    Has cerrado sesión exitosamente. ¡Hasta pronto!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card fondo text-white" style="width:400px; padding:2.5rem 2rem;">
        
            <h2 class="text-center mb-3 fw-bold">BIENVENIDO</h2>
            <p class="text-center mb-4 text-white-50">Inicia sesión aquí</p>
            <form action="/functions/signIn.php" method="POST">
                <input type="email" name="correo" class="form-control mb-3" placeholder="Email" required />
                <input type="password" name="contrasena" class="form-control mb-3" placeholder="Contraseña" required />
                <button class="btn btn-outline-light" type="submit">Iniciar Sesión</button>
            </form>
            <div class="mt-4">
                <p class="mb-2">¿No tienes una cuenta? <a href="/pages/signUpUsers.php" class="text-white-50 fw-bold">Regístrate aquí</a></p>
                <p class="mb-0 text-center"><a href="/pages/public_rides.php" class="text-white-50 fw-bold"><i class="fas fa-eye me-1"></i>Ver Rides Disponibles</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>