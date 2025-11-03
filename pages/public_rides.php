<?php
require_once '../database/connection.php';
require_once '../database/queries.php';
$conn = getConnection_BD();

$filtros = [
    'salida' => $_GET['salida'] ?? '',
    'llegada' => $_GET['llegada'] ?? ''
];

$orden = $_GET['orden'] ?? 'fecha_asc';

$rides = obtenerRidesPublicos($conn, $filtros, $orden);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rides Disponibles - RideConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css?v=2"> 
</head>
<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #1A281E; color: #fefce0;">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center text-decoration-none" href="../index.php" style="color: #fefce0;">
                <img src="../assets/logo.jpg" alt="Logo" height="35" class="me-2 rounded-circle">
                <span class="fw-bold">RideConnect</span>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="../index.php" style="color: #fefce0;">
                    Iniciar Sesión
                </a>
            </div>
        </div>
    </nav>

    <div class="container py-5 h-100" style="padding-top: 40px; padding-bottom: 40px;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card fondo text-white shadow border-0 text-center">
                    <div class="card-body p-4">
                        <h1 class="fw-bold mb-2" style="color: #eaf7d2;">Rides Disponibles</h1>
                        <p style="color: #d6e5c0;">Encuentra el viaje perfecto para tu destino</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros y Ordenamiento -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card fondo text-white shadow border-0">
                    <div class="card-body p-4">
                        <form method="GET" action="">
                            <div class="row g-3">
                                <!-- Búsqueda por ubicaciones -->
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" style="color: #1A281E;">
                                        Lugar de Salida
                                    </label>
                                    <input type="text" class="form-control" name="salida" 
                                           value="<?= htmlspecialchars($filtros['salida']) ?>" 
                                           placeholder="Ej: San José, Cartago...">
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" style="color: #1A281E;">
                                        Lugar de Llegada
                                    </label>
                                    <input type="text" class="form-control" name="llegada" 
                                           value="<?= htmlspecialchars($filtros['llegada']) ?>" 
                                           placeholder="Ej: Heredia, Alajuela...">
                                </div>
                                
                                <!-- Ordenamiento -->
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" style="color: #1A281E;">
                                        Ordenar por
                                    </label>
                                    <select class="form-select" name="orden">
                                        <option value="fecha_asc" <?= $orden === 'fecha_asc' ? 'selected' : '' ?>>
                                            Fecha (Más próximo)
                                        </option>
                                        <option value="fecha_desc" <?= $orden === 'fecha_desc' ? 'selected' : '' ?>>
                                            Fecha (Más lejano)
                                        </option>
                                        <option value="salida_asc" <?= $orden === 'salida_asc' ? 'selected' : '' ?>>
                                            Origen (A-Z)
                                        </option>
                                        <option value="salida_desc" <?= $orden === 'salida_desc' ? 'selected' : '' ?>>
                                            Origen (Z-A)
                                        </option>
                                        <option value="llegada_asc" <?= $orden === 'llegada_asc' ? 'selected' : '' ?>>
                                            Destino (A-Z)
                                        </option>
                                        <option value="llegada_desc" <?= $orden === 'llegada_desc' ? 'selected' : '' ?>>
                                            Destino (Z-A)
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-outline-light btn-lg px-4" style="width:auto;min-width:180px;">
                                        Buscar Rides
                                    </button>
                                    <a href="public_rides.php" class="btn btn-outline-light btn-lg px-4 ms-2" style="background:#27AE60;color:#fffde8;width:auto;min-width:180px;">
                                        Limpiar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <h4 style="color: #1A281E;">
                    Rides Disponibles (<?= count($rides) ?>)
                </h4>
            </div>
        </div>

        <div class="row">
            <?php if (empty($rides)): ?>
                <div class="col-12">
                    <div class="card fondo text-white border-0 shadow">
                        <div class="card-body text-center p-5">
                            <h4 style="color:#d6e5c0;">No se encontraron rides</h4>
                            <p style="color:#d6e5c0;">
                                <?php if (!empty($filtros['salida']) || !empty($filtros['llegada'])): ?>
                                    Intenta modificar tus criterios de búsqueda
                                <?php else: ?>
                                    No hay rides disponibles en este momento
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php 
                $isPublicPage = true; // Variable para indicar que es página pública
                foreach ($rides as $ride): ?>
                    <?php include '../templates/cardRide.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="alertaRegistroModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card fondo text-white" style="border-radius: 20px;">
                <div class="modal-header" style="background-color: #2ECC71; color: #fefce0; border-radius: 20px 20px 0 0;">
                    <h5 class="modal-title fw-bold">
                        Registro Requerido
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                        <h5 style="color: #eaf7d2;">¡Debes estar registrado para reservar el ride!</h5>
                        <p style="color: #d6e5c0;">
                            Para poder solicitar una reserva necesitas crear una cuenta en nuestra plataforma.
                        </p>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <a href="../index.php" class="btn btn-outline-dark btn-lg px-4">
                        Ir a Registrarse/Iniciar Sesión
                    </a>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Seguir Navegando
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function mostrarAlertaRegistro() {
            const modal = new bootstrap.Modal(document.getElementById('alertaRegistroModal'));
            modal.show();
        }
    </script>
</body>
</html>