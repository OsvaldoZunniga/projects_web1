<?php
require_once 'database/connection.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SubiteyReza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="/css/login.css" rel="stylesheet"/>
</head>
<body>

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
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card fondo text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Bienvenido</h2>
                                <p class="text-white-50 mb-5">Inicia sesión aquí!</p>

                                <form action="/functions/signIn.php" method="POST">

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" name="correo" id="typeEmailX" class="form-control form-control-lg" required/>
                                        <label class="form-label" for="typeEmailX">Email</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" name="contrasena" id="typePasswordX" class="form-control form-control-lg" required/>
                                        <label class="form-label" for="typePasswordX">Contraseña</label>
                                    </div>             

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Iniciar Sesión</button>
                                </form>

                            </div>
                            <div>
                                <p class="mb-2">¿No tienes una cuenta? 
                                    <a href="/pages/signUpUsers.php" class="text-white-50 fw-bold">Regístrate aquí</a>
                                </p>
                                <p class="mb-0">
                                    <a href="/pages/public_rides.php" class="text-white-50 fw-bold">
                                        <i class="fas fa-eye me-1"></i>Ver Rides Disponibles
                                    </a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>