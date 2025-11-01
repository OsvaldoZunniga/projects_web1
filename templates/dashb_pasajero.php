<?php

if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 2) {
    header("Location: ../index.php?msg=invalid");
    exit();
}

require_once '../database/connection.php';
require_once '../database/queries.php';

$conn = getConnection_BD();
$idUsuario = $_SESSION['idUsuario'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasajero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet"/>
</head>
<body>
<?php include '../templates/nav.php'; ?>

    <!-- aqui van a ir los rides activos (tal vez no vaya aqui)-->
    <div class="row mt-5">
      <div class="col-12">
        <div class="card shadow border-0" style="border-radius: 1rem; min-height: 400px;">
          <div class="card-body p-4">
            <h3 class="fw-bold mb-4" style="color: #1A281E;">Rides Activos</h3>
            <div class="row g-4" id="reservas-container">
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- aqui van a ir las reservas -->
    <div class="row mt-5">
      <div class="col-12">
        <div class="card shadow border-0" style="border-radius: 1rem; min-height: 400px;">
          <div class="card-body p-4">
            <h3 class="fw-bold mb-4" style="color: #1A281E;">Mis Reservas</h3>
            <div class="row g-4" id="reservas-container">
              
            </div>
          </div>
        </div>
      </div>
    </div>

  </div> 

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>