<?php

if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 2) {
    header("Location: ../index.php?msg=invalid");
    exit();
}

require_once '../database/connection.php';
require_once '../database/queries.php';

$conn = getConnection_BD();
$idUsuario = $_SESSION['idUsuario'];

$filtros = [
    'salida' => $_GET['salida'] ?? '',
    'llegada' => $_GET['llegada'] ?? ''
];

$orden = $_GET['orden'] ?? 'fecha_asc';

$ridesDisponibles = obtenerRidesPublicos($conn, $filtros, $orden);
$reservas = obtenerReservasPorUsuario($conn, $idUsuario);
$ridesRealizados = obtenerRidesRealizadosPorUsuario($conn, $idUsuario);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasajero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css?v=2">
</head>
<body>
<?php include '../templates/nav.php'; ?>

<div class="container-fluid py-5 h-100" style="padding-top: 40px; padding-bottom: 40px; margin:0;">

    <div class="row mb-4">
        <div class="col-12">
            <div class="card fondo text-white shadow border-0">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3" style="color: #eaf7d2;">Buscar Rides</h4>
                    <form method="GET" action="">
                        <div class="row g-3">
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
                                <a href="/pages/dashboard.php" class="btn btn-outline-light btn-lg px-4 ms-2" style="background:#27AE60;color:#fffde8;width:auto;min-width:180px;">
                                    Limpiar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rides Disponibles -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 style="color: #2ECC71;">
                Rides Disponibles (<?= count($ridesDisponibles) ?>)
            </h4>
        </div>
    </div>

    <div class="row mb-5">
        <?php if (empty($ridesDisponibles)): ?>
            <div class="col-12">
                <div class="card fondo text-white border-0 shadow">
                    <div class="card-body text-center p-5">
                        <h4 style="color:#d6e5c0;">No se encontraron rides disponibles</h4>
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
            <?php foreach ($ridesDisponibles as $ride): ?>
                <?php include '../templates/cardRide.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

        <!-- Mis Solicitudes -->
        <div class="row">
                <div class="col-12">
                        <div class="card fondo text-white shadow border-0">
                                <div class="card-body p-4">
                                        <h3 class="fw-bold mb-4" style="color: #eaf7d2;">
                                                Mis Solicitudes de Reserva
                                        </h3>

                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead style="background-color: #2ECC71; color: #fffde8;">
                                                    <tr>
                                                        <th>Reserva</th>
                                                        <th>Ride</th>
                                                        <th>Origen</th>
                                                        <th>Destino</th>
                                                        <th>Fecha</th>
                                                        <th>Hora</th>
                                                        <th>Vehículo</th>
                                                        <th>Estado</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #fffde8; color: #13281F;">
                                                    <?php if (empty($reservas)): ?>
                                                        <tr>
                                                            <td colspan="9" class="text-center">No tienes solicitudes de reserva</td>
                                                        </tr>
                                                    <?php else: ?>
                                                        <?php foreach ($reservas as $res): ?>
                                                            <tr>
                                                                <td><?= htmlspecialchars($res['idReserva']) ?></td>
                                                                <td><?= htmlspecialchars($res['ride_nombre']) ?></td>
                                                                <td><?= htmlspecialchars($res['salida']) ?></td>
                                                                <td><?= htmlspecialchars($res['llegada']) ?></td>
                                                                <td><?= htmlspecialchars($res['fecha']) ?></td>
                                                                <td><?= htmlspecialchars($res['hora']) ?></td>
                                                                <td><?= htmlspecialchars($res['marca']) ?> <?= htmlspecialchars($res['modelo']) ?> - <?= htmlspecialchars($res['color']) ?></td>
                                                                <td><?= htmlspecialchars($res['estado']) ?></td>
                                                                <td>
                                                                    <form method="POST" action="../functions/update_reservas.php" style="display:inline;">
                                                                        <input type="hidden" name="idReserva" value="<?= htmlspecialchars($res['idReserva']) ?>">
                                                                        <input type="hidden" name="action" value="cancelar">
                                                                        <button type="submit" class="btn btn-danger btn-sm" <?= $res['estado'] !== 'Pendiente' && $res['estado'] !== 'Aceptado' ? 'disabled' : '' ?>>Cancelar</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>

                                </div>
                        </div>
                </div>
        </div>

        <div class="row mt-5">
        <div class="col-12">
            <div class="card fondo text-white shadow border-0" style="border-radius: 20px; min-height: 400px; box-shadow: 0 4px 24px rgba(39, 174, 96, 0.12);">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-4" style="color: #eaf7d2;">Rides Realizados</h3>
                <div class="row g-4" id="rides-container">
                <?php
                    if (empty($ridesRealizados)): ?>
                    <p class="text-center" style="color: #d6e5c0;">Aún no se ha realizado ningún ride</p>
                    <?php else: ?>
                    <?php foreach ($ridesRealizados as $rideRealizado):
                        $rideRealizado = [
                        'idRide' => $rideRealizado['idRide'],
                        'nombre' => $rideRealizado['nombre'],
                        'marca' => $rideRealizado['marca'],
                        'modelo' => $rideRealizado['modelo'],
                        'color' => $rideRealizado['color'],
                        'salida' => $rideRealizado['salida'],
                        'llegada' => $rideRealizado['llegada'],
                        'fecha' => $rideRealizado['fecha'],
                        'hora' => $rideRealizado['hora'],
                        'espacios' => $rideRealizado['espacios'],
                        'costo_espacio' => $rideRealizado['costo_espacio']
                        ];
                        include 'cardRidesRealizados.php';
                    endforeach; ?>
                    <?php endif; ?>            
                </div>
            </div>
            </div>
        </div>
        </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>