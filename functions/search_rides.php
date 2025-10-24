<?php
require '../database/connection.php';

$query = "SELECT r.idRide, r.idVehiculo, r.nombre, r.salida, r.llegada, r.hora, r.fecha, r.espacios, r.costo_espacio 
          FROM ride r
          INNER JOIN vehiculos v ON r.idVehiculo = v.idVehiculo
          WHERE r.espacios > 0";

$result = mysqli_query($conn, $query);

// Generate Bootstrap cards for each ride
if (mysqli_num_rows($result) > 0) {
    echo '<div class="row g-4">';
    while ($ride = mysqli_fetch_assoc($result)) {
        echo '<div class="col-md-4">';
        echo '<div class="card h-100 shadow-sm">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">Desde: ' . htmlspecialchars($ride['salida']) . '</h5>';
        echo '<h6 class="card-subtitle mb-2">Hacia: ' . htmlspecialchars($ride['llegada']) . '</h6>';
        echo '<p class="card-text"><strong>Vehiculo:</strong> ' . htmlspecialchars($ride['idVehiculo']) . '</p>';
        echo '<p class="card-text"><strong>Fecha:</strong> ' . htmlspecialchars($ride['fecha']) . '</p>';
        echo '<p class="card-text"><strong>Precio por espacio:</strong> $' . htmlspecialchars($ride['costo_espacio']) . '</p>';
        echo '<button class="btn btn-primary w-100" onclick="bookRide(' . $ride['idRide'] . ')">Book Ride</button>';
        echo '</div>'; // End card-body
        echo '</div>'; // End card
        echo '</div>'; // End col
    }
    echo '</div>'; // End row
} else {
    echo '<div class="alert alert-info" role="alert">No rides available</div>';
}

mysqli_close($conn);