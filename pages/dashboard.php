<?php
session_start();

if (!isset($_SESSION['idUsuario'])) {
    header("Location: ../index.php?msg=inactive");
    exit();
}

$idRol = $_SESSION['idRoles'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet"/>
</head>
<body>



<div class="container mt-4 text-center">
    <?php
        switch ($idRol) {
            case 3:
                include '../templates/dashB_Admin.php';
                break;
            case 2: 
                include '../templates/nav.php';
                include '../templates/dashB_Pasajero.php';
                break;
            case 1: 
                include '../templates/nav.php';
                include '../templates/dashB_Chofer.php';
                break;
            default:
                echo '<div class="alert alert-danger"> Rol no reconocido.</div>';
                break;
        }
    ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
