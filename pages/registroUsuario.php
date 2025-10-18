<?php
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet"/> 
</head>
<body>

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-6">
        <div class="card fondo text-white" style="border-radius: 1rem;">
          <div class="card-body p-5">

            <h2 class="fw-bold mb-4 text-center">Registro de Usuario</h2>

            <form action="procesar_registro.php" method="POST" enctype="multipart/form-data"> //cambiar nombre del archivo

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nombre</label>
                  <input type="text" name="nombre" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Apellido</label>
                  <input type="text" name="apellido" class="form-control form-control-lg" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Cédula</label>
                <input type="text" name="cedula" class="form-control form-control-lg" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Fecha de Nacimiento</label>
                <input type="date" name="nacimiento" class="form-control form-control-lg" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="correo" class="form-control form-control-lg" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control form-control-lg" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Fotografía</label>
                <input type="file" name="fotografia" class="form-control form-control-lg" accept="image/*">
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Contraseña</label>
                  <input type="password" name="contrasena" class="form-control form-control-lg" required>
                </div>

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-outline-light btn-lg">Registrar</button>
              </div>
            </form>

            <p class="text-center mt-3">¿Ya tienes cuenta? 
              <a href="login.php" class="text-white-50 fw-bold">Inicia sesión aquí</a>
            </p>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
