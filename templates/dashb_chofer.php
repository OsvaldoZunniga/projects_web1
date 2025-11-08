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
$reservas = obtenerReservasPendientes($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chofer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css?v=2">
</head>
<body>
<?php include '../templates/nav.php'; ?>
  <div class="container-fluid py-5 h-100" style="padding-top: 40px; padding-bottom: 40px;">
    <div class="row g-4">

      <div class="col-md-6">
        <div class="card fondo text-white shadow border-0 h-100 text-center">
          <div class="card-body d-flex flex-column justify-content-center align-items-center p-5">
            <h3 class="fw-bold mb-4" style="color: #eaf7d2;">Registro de Vehículos</h3>
            <p class="mb-4" style="color: #d6e5c0;">Registra la información de tus vehículos aquí.</p>
            <a href="../pages/addVehicle.php" class="btn btn-outline-light btn-lg px-4" style="width:auto;min-width:200px;">Ir al registro</a>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card fondo text-white shadow border-0 h-100 text-center">
          <div class="card-body d-flex flex-column justify-content-center align-items-center p-5">
            <h3 class="fw-bold mb-4" style="color: #eaf7d2;">Gestión de Rides</h3>
            <p class="mb-4" style="color: #d6e5c0;">Crea, actualiza o consulta tus viajes disponibles.</p>
            <a href="../pages/addRide.php" class="btn btn-outline-light btn-lg px-4" style="width:auto;min-width:200px;">Ir a Rides</a>
          </div>
        </div>
      </div>

    </div>

    <div class="row mt-5">
      <div class="col-12">
        <div class="card fondo text-white shadow border-0" style="border-radius: 20px; min-height: 400px; box-shadow: 0 4px 24px rgba(39, 174, 96, 0.12);">
          <div class="card-body p-4">
            <h3 class="fw-bold mb-4" style="color: #eaf7d2;">Mis Vehículos</h3>
            <div class="row g-4" id="vehiculos-container">
              <?php if (empty($vehiculos)): ?> 
                <p class="text-center" style="color: #d6e5c0;">No hay vehículos registrados aún.</p>
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

    <div class="row mt-5">
      <div class="col-12">
        <div class="card fondo text-white shadow border-0" style="border-radius: 20px; min-height: 400px; box-shadow: 0 4px 24px rgba(39, 174, 96, 0.12);">
          <div class="card-body p-4">
            <h3 class="fw-bold mb-4" style="color: #eaf7d2;">Rides Registrados</h3>
            <div class="row g-4" id="rides-container">
              <?php
                if (empty($rides)): ?>
                  <p class="text-center" style="color: #d6e5c0;">No hay rides registrados aún.</p>
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

    <!-- aqui van a ir las reservas -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="card fondo text-white shadow border-0" style="border-radius: 20px; min-height: 400px; box-shadow: 0 4px 24px rgba(39, 174, 96, 0.12);">
          <div class="card-body p-4">
            <h3 class="fw-bold mb-4" style="color: #eaf7d2;">Reservas Pendientes</h3>
            <div class="row g-4" id="rides-container">
              <?php
                if (empty($reservas)): ?>
                  <p class="text-center" style="color: #d6e5c0;">No hay reservas pendientes</p>
                <?php else: ?>
                  <?php foreach ($reservas as $reserva):
                    $reserva = [
                      'idReserva' => $reserva['idReserva'],
                      'idUsuario' => $reserva['idUsuario'],
                      'ride_nombre' => $reserva['ride_nombre'],
                      'estado' => $reserva['estado'],
                      'nombre' => $reserva['nombre'],
                      'apellido' => $reserva['apellido'],
                      'cedula' => $reserva['cedula'],
                      'correo' => $reserva['correo']  
                    ];
                    include 'cardReserva.php';
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