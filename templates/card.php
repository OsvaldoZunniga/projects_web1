<div class="col-md-3">
  <a href="../pages/vehicles_settings.php?id=<?= $vehiculo['idVehiculo'] ?>" class="text-decoration-none"> <!-- Enlace a laconfiguración del vehículo -->
    <div class="card shadow border-0 h-100 card-clickable" 
         style="border-radius: 0.8rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: transform 0.2s, box-shadow 0.2s;">
      
      <?php if (!empty($vehiculo['foto'])): ?>
        <img src="../<?= $vehiculo['foto'] ?>" 
             class="card-img-top" 
             alt="<?= $vehiculo['marca'] ?> <?= $vehiculo['modelo'] ?>"
             style="height: 200px; object-fit: cover; border-radius: 0.8rem 0.8rem 0 0;">
      <?php endif; ?>
      
      <div class="card-body text-center">
        <h5 class="fw-bold mb-3" style="color: #1A281E;">
          <?= $vehiculo['marca'] ?> <?= $vehiculo['modelo'] ?>
        </h5>
        <p class="text-muted mb-1">
          <strong>Placa:</strong> <?= $vehiculo['placa'] ?>
        </p>
        <p class="text-muted mb-1">
          <strong>Modelo:</strong> <?= $vehiculo['modelo'] ?>
        </p>
      </div>
    </div>
  </a>
</div>

