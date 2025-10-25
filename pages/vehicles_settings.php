<?php
session_start();

if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 1) {
    header("Location: ../index.php?msg=invalid");
    exit();
}

require_once '../database/connection.php';
require_once '../database/queries.php';

$conn = getConnection_BD();
$idVehiculo = $_GET['id'] ?? null;

if (!$idVehiculo) {
    header("Location: ../pages/dashboard.php?msg=error");
    exit();
}

$vehiculo = obtenerVehiculoPorId($conn, $idVehiculo);

if (!$vehiculo || $vehiculo['idUsuario'] != $_SESSION['idUsuario']) {
    header("Location: ../pages/dashboard.php?msg=unauthorized");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Vehículo</title>
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

            <h2 class="fw-bold mb-4 text-center">Editar Vehículo</h2>
            <p class="text-center mb-4">Actualiza la información de tu vehículo.</p>

            <div class="mb-3">
              <a href="../pages/dashboard.php" class="btn btn-outline-light">← Volver al Dashboard</a>
            </div>

            <form action="../functions/update_vehicles.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="idVehiculo" value="<?= $vehiculo['idVehiculo'] ?>">
              <input type="hidden" name="accion" value="actualizar">

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Placa</label>
                  <input type="text" name="placa" class="form-control form-control-lg" value="<?= htmlspecialchars($vehiculo['placa']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Color</label>
                  <input type="text" name="color" class="form-control form-control-lg" value="<?= htmlspecialchars($vehiculo['color']) ?>" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Marca</label>
                  <input type="text" name="marca" class="form-control form-control-lg" value="<?= htmlspecialchars($vehiculo['marca']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Modelo</label>
                  <input type="text" name="modelo" class="form-control form-control-lg" value="<?= htmlspecialchars($vehiculo['modelo']) ?>" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Año</label>
                  <input type="number" name="anio" class="form-control form-control-lg" value="<?= htmlspecialchars($vehiculo['anio']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Capacidad de Asientos</label>
                  <input type="number" name="capacidad" class="form-control form-control-lg" min="1" max="10" value="<?= htmlspecialchars($vehiculo['capacidad']) ?>" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Cambiar Fotografía (opcional)</label>
                <input type="file" name="foto" class="form-control form-control-lg" accept="image/*">
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <button type="submit" class="btn btn-outline-light btn-lg w-100">Actualizar Vehículo</button>
                </div>
                <div class="col-md-6 mb-3">
                  <button type="button" class="btn btn-outline-danger btn-lg w-100" onclick="confirmarEliminar()">Eliminar Vehículo</button>
                </div>
              </div>

            </form>

            <form id="formEliminar" action="../functions/update_vehicles.php" method="POST" style="display: none;">
              <input type="hidden" name="idVehiculo" value="<?= $vehiculo['idVehiculo'] ?>">
              <input type="hidden" name="accion" value="eliminar">
            </form>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
function confirmarEliminar() {
  if (confirm('¿Estás seguro de que quieres eliminar este vehículo? Esta acción no se puede deshacer.')) {
    document.getElementById('formEliminar').submit();
  }
}
</script>
</body>
</html>
