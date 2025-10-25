<?php
session_start();

if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 1) {
    header("Location: ../index.php?msg=invalid");
    exit();
}
require_once '../database/connection.php';
$idUsuario = $_SESSION['idUsuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar Vehículo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/login.css" rel="stylesheet"/> 
</head>
<body>

<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-start h-100">

      <div class="col-12 col-md-11 col-lg-10 col-xl-9">
        <div class="card fondo" style="border-radius: 1rem;">
          <div class="card-body p-5">

            <h2 class="fw-bold mb-4 text-center">Registrar Vehículo</h2>
            <p class="text-center mb-4">Completa la información de tu vehículo.</p>

            <form action="../functions/vehicles.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="idUsuario" value="<?= $idUsuario ?>">

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Placa</label>
                  <input type="text" name="placa" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Color</label>
                  <input type="text" name="color" class="form-control form-control-lg" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Marca</label>
                  <input type="text" name="marca" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Modelo</label>
                  <input type="text" name="modelo" class="form-control form-control-lg" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Año</label>
                   <input type="text" name="anio" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Capacidad de Asientos</label>
                  <input type="number" name="capacidad" class="form-control form-control-lg" min="1" max="10" value="1" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Fotografía del Vehículo</label>
                <input type="file" name="foto" class="form-control form-control-lg" accept="image/*">
              </div>

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-outline-light btn-lg">Registrar Vehículo</button>
              </div>

               <div class="mb-3">
                 <a href="../pages/dashboard.php" class="btn btn-outline-light">← Volver al Dashboard</a>
              </div>

            </form>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
