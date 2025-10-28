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
    
    <?php if (isset($_GET['msg'])): ?>
        <div class="container mt-3">
            <?php if ($_GET['msg'] == 'ride_error'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Ride no registrado. Por favor, intenta de nuevo.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'ride_success'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Ride registrado exitosamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>



<div class="container mt-4 text-center">
    <?php
        switch ($idRol) {
            case 3:
                include '../templates/dashB_Admin.php';
                break;
            case 2: 
                include '../templates/dashb_pasajero.php';
                break;
            case 1: 
                include '../templates/dashb_chofer.php';
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
