<?php
session_start();

if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 1) {
    header("Location: ../index.php?msg=invalid");
    exit();
}

require_once '../database/connection.php';
require_once '../database/queries.php';

$conn = getConnection_BD();
$idRide = $_GET['id'] ?? null;

if (!$idRide) {
    header("Location: ../pages/dashboard.php?msg=error");
    exit();
}

$ride = obtenerRidePorId($conn, $idRide);

if (!$ride) {
    header("Location: ../pages/dashboard.php?msg=unauthorized");
    exit();
}

$vehiculo = obtenerVehiculoPorId($conn, $ride['idVehiculo']);
if (!$vehiculo || $vehiculo['idUsuario'] != $_SESSION['idUsuario']) {
    header("Location: ../pages/dashboard.php?msg=unauthorized");
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Ride</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css?v=2"> 
</head>
<body>

<section class="vh-100">
  <div class="container py-5 h-100" style="padding-top: 40px; padding-bottom: 40px;">
    <div class="row d-flex justify-content-center align-items-start h-100">

      <div class="col-12 col-md-12 col-lg-12 col-xl-10 mx-auto">
        <div class="card fondo text-white" style="border-radius: 20px; box-shadow: 0 4px 24px rgba(39, 174, 96, 0.12);">
          <div class="card-body p-4">

            <h2 class="fw-bold mb-4 text-center">Editar Ride</h2>
            <p class="text-center mb-4">Actualiza la información de tu ride.</p>

            <div class="mb-3">
              <a href="../pages/dashboard.php" class="btn btn-outline-light">← Volver al Dashboard</a>
            </div>

            <form action="../functions/update_rides.php" method="POST">
              <input type="hidden" name="idRide" value="<?= $ride['idRide'] ?>">
              <input type="hidden" name="accion" value="actualizar">

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Vehículo</label>
                  <select name="vehiculo" class="form-control form-control-lg" required>
                    <option value="">Seleccione un vehículo</option>
                    <?php
                      $vehiculos = obtenerVehiculosPorUsuario($conn, $idUsuario);
                      foreach ($vehiculos as $veh) {
                        $selected = ($veh['idVehiculo'] == $ride['idVehiculo']) ? 'selected' : '';
                        echo "<option value='" . $veh['idVehiculo'] . "' $selected>" . $veh['marca'] . " " . $veh['modelo'] . " - " . $veh['color'] . "</option>";
                      } //selected para que cargue el vehiculo seleccionado
                    ?>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nombre</label>
                  <input type="text" name="nombre" class="form-control form-control-lg" value="<?= htmlspecialchars($ride['nombre']) ?>" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Salida</label>
                  <input type="text" name="salida" class="form-control form-control-lg" value="<?= htmlspecialchars($ride['salida']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Llegada</label>
                  <input type="text" name="llegada" class="form-control form-control-lg" value="<?= htmlspecialchars($ride['llegada']) ?>" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Hora</label>
                  <input type="time" name="hora" class="form-control form-control-lg" value="<?= htmlspecialchars($ride['hora']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Fecha</label>
                  <input type="date" name="fecha" class="form-control form-control-lg" value="<?= htmlspecialchars($ride['fecha']) ?>" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Espacios</label>
                  <input type="number" name="espacios" class="form-control form-control-lg" min="1" max="<?= htmlspecialchars($ride['espacios']) ?>" value="<?= htmlspecialchars($ride['espacios']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Precio por espacio</label>
                  <input type="number" name="precio_espacio" class="form-control form-control-lg" min="1" value="<?= htmlspecialchars($ride['costo_espacio']) ?>" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <button type="submit" class="btn btn-outline-light btn-lg w-100">Actualizar Ride</button>
                </div>
                <div class="col-md-6 mb-3">
                  <button type="button" class="btn btn-outline-danger btn-lg w-100" onclick="confirmarEliminar()">Eliminar Ride</button>
                </div>
              </div>

            </form>

            <form id="formEliminar" action="../functions/update_rides.php" method="POST" style="display: none;">
              <input type="hidden" name="idRide" value="<?= $ride['idRide'] ?>">
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
  if (confirm('¿Estás seguro de que quieres eliminar este ride? Esta acción no se puede deshacer.')) {
    document.getElementById('formEliminar').submit();
  }
}
</script>
</body>
</html>