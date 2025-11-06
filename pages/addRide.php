<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rides</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css?v=2">

</head>
<body>
    <?php 
        include '../templates/nav.php'; 
        
        require_once '../database/connection.php';
        require_once '../database/queries.php';

        $conn = getConnection_BD();
        $idUsuario = $_SESSION['idUsuario'];
        
    ?>


    <section class="vh-100">
    <div class="container py-5 h-100" style="padding-top: 40px; padding-bottom: 40px;">
            <div class="row d-flex justify-content-center align-items-start h-100">

            <div class="col-12 col-md-11 col-lg-10 col-xl-9 mx-auto">
                <div class="card fondo" style="border-radius: 20px;">
                    <div class="card-body p-5">
                    <div class="mb-2">
                        <a href="../pages/dashboard.php" class="btn btn-outline-light">← Volver al Dashboard</a>
                    </div>
                    <h2 class="fw-bold mb-4 text-center">Registrar Ride</h2>
                    <p class="text-center mb-4">Completa la información del ride</p>
                    <form action="../functions/rides.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Vehiculo</label>
                                <select name="vehiculo" class="form-control form-control-lg" required>
                                    <option value="">Seleccione un vehículo</option>
                                    <?php
                                        $vehiculos = obtenerVehiculosPorUsuario($conn, $idUsuario);
                                        foreach ($vehiculos as $vehiculo) {
                                            echo "<option value='" . $vehiculo['idVehiculo'] . "'>" . $vehiculo['marca'] . " " . $vehiculo['modelo'] . " - " . $vehiculo['color'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-lg" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Salida</label>
                                <input type="text" name="salida" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Llegada</label>
                                <input type="text" name="llegada" class="form-control form-control-lg" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">hora</label>
                                <input type="time" name="hora" class="form-control form-control-lg" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">fecha</label>
                                <input type="date" name="fecha" class="form-control form-control-lg" min="1" max="10" value="1" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">espacios</label>
                                <input type="number" name="espacios" class="form-control form-control-lg" min="1" max="10" value="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">precio por espacio</label>
                                <input type="number" name="precio_espacio" class="form-control form-control-lg" min="1" required>
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-outline-light btn-lg">Registrar Ride</button>
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