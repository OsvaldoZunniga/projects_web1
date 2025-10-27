<?php

if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 1) {
    header("Location: ../index.php?msg=invalid");
    exit();
}

require_once '../database/connection.php';
require_once '../database/queries.php';

$conn = getConnection_BD();
$idUsuario = $_SESSION['idUsuario'];
$vehiculos = obtenerVehiculosPorUsuario($conn, $idUsuario);
$rides = obtenerRidesPorUsuario($conn, $idUsuario);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chofer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet"/>
</head>
<body>
<?php include '../templates/nav.php'; ?>
  <div class="container my-5">
    <div class="row g-4">

      <div class="col-md-6">
        <div class="card shadow border-0 h-100 text-center" style="border-radius: 1rem;">
          <div class="card-body d-flex flex-column justify-content-center align-items-center p-5">
            <h3 class="fw-bold mb-4" style="color: #1A281E;">Registro de Vehículos</h3>
            <p class="mb-4 text-muted">Registra la información de tus vehículos aquí.</p>
            <a href="../pages/addVehicle.php" class="btn btn-outline-dark btn-lg px-4">Ir al registro</a>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card shadow border-0 h-100 text-center" style="border-radius: 1rem;">
          <div class="card-body d-flex flex-column justify-content-center align-items-center p-5">
            <h3 class="fw-bold mb-4" style="color: #1A281E;">Gestión de Rides</h3>
            <p class="mb-4 text-muted">Crea, actualiza o consulta tus viajes disponibles.</p>
            <a href="../pages/addRides.php" class="btn btn-outline-dark btn-lg px-4">Ir a Rides</a>
          </div>
        </div>
      </div>

    </div>

    <!-- aqui van vehículos -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="card shadow border-0" style="border-radius: 1rem; min-height: 400px;">
          <div class="card-body p-4">
            <h3 class="fw-bold mb-4" style="color: #1A281E;">Mis Vehículos</h3>
            <div class="row g-4" id="vehiculos-container">
              <?php if (empty($vehiculos)): ?> 
                <p class="text-muted text-center">No hay vehículos registrados aún.</p>
              <?php else: ?>
                <?php foreach($vehiculos as $vehiculo): ?>
                  <?php 
                    $item = [
                      'id' => $vehiculo['idVehiculo'],
                      'imagen' => $vehiculo['foto'],
                      'titulo' => $vehiculo['marca'],
                      'campos' => [
                        'Placa' => $vehiculo['placa'],
                        'Modelo' => $vehiculo['modelo']
                      ],
                      'link' => '../pages/vehicles_settings.php?id=' . $vehiculo['idVehiculo']
                    ];
                    include 'card.php'; 
                  ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- aqui van rides -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="card shadow border-0" style="border-radius: 1rem; min-height: 400px;">
          <div class="card-body p-4">
            <h3 class="fw-bold mb-4" style="color: #1A281E;">Rides Registrados</h3>
            <div class="row g-4" id="rides-container">
              <?php
                if (empty($rides)): ?>
                  <p class="text-muted text-center">No hay rides registrados aún.</p>
                <?php else: ?>
                  <?php foreach ($rides as $ride):
                    $item = [
                      'idRide' => $ride['idRide'],
                      'nombre' => $ride['nombre'],
                      'marca' => $ride['marca'],
                      'modelo' => $ride['modelo'],
                      'color' => $ride['color'],
                      'salida' => $ride['salida'],
                      'llegada' => $ride['llegada'],
                      'fecha' => $ride['fecha'],
                      'hora' => $ride['hora'],
                      'espacios' => $ride['espacios'],
                      'costo_espacio' => $ride['costo_espacio']
                    ];
                    include 'cardRide.php';
                  endforeach; ?>
                <?php endif; ?>

               
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>