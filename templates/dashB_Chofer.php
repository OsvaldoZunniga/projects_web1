<?php
if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 1) {
    header("Location: ../index.php?msg=invalid");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de chofer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet"/>
</head>
<body>
    <div class="mt-5">
    <h1 class="fw-bold"> Panel del Chofer</h1>
    <p class="text-white-50">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></p>
    <div class="alert alert-info">Aquí podrás gestionar tus viajes y ver solicitudes de pasajeros.</div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>