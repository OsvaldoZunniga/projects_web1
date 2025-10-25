<?php

if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 1) {
    header("Location: ../index.php?msg=invalid");
    exit();
}
require_once '../database/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet"/>
</head>
<body>
<?php include '../templates/nav.php'; ?>
  <div class="container my-5">
    <div class="row justify-content-center g-4">

      <div class="col-md-5">
        <div class="card shadow border-0 h-100 text-center" style="border-radius: 1rem;">
          <div class="card-body d-flex flex-column justify-content-center align-items-center p-5">
            <h3 class="fw-bold mb-4" style="color: #1A281E;">Gestión de Vehículos</h3>
            <p class="mb-4 text-muted">Administra tu información de vehículos registrados.</p>
            <a href="vehicles.php" class="btn btn-outline-dark btn-lg px-4">Ir a Vehículos</a>
          </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="card shadow border-0 h-100 text-center" style="border-radius: 1rem;">
          <div class="card-body d-flex flex-column justify-content-center align-items-center p-5">
            <h3 class="fw-bold mb-4" style="color: #1A281E;">Gestión de Rides</h3>
            <p class="mb-4 text-muted">Crea, actualiza o consulta tus viajes disponibles.</p>
            <a href="rides.php" class="btn btn-outline-dark btn-lg px-4">Ir a Rides</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>