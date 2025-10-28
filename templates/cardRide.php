<div class="col-md-4 mb-4">
  <a href="detalles_ride.php?id=<?= $ride['idRide'] ?>" class="text-decoration-none">
    <div class="card shadow border-0 h-100 card-clickable" 
         style="border-radius: 0.8rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: transform 0.2s, box-shadow 0.2s;">
      
      <div class="card-header text-white text-center" style="background-color: #1A281E; border-radius: 0.8rem 0.8rem 0 0;">
        <h5 class="mb-0 fw-bold"><?= htmlspecialchars($ride['nombre']) ?></h5>
      </div>
      
      <div class="card-body">
        
        <div class="mb-3 pb-3 border-bottom">
          <p class="text-muted mb-1">
            <i class="fas fa-car me-2"></i>
            <strong>Vehículo:</strong> <?= htmlspecialchars($ride['marca']) ?> <?= htmlspecialchars($ride['modelo']) ?>
          </p>
          <p class="text-muted mb-0">
            <i class="fas fa-palette me-2"></i>
            <strong>Color:</strong> <?= htmlspecialchars($ride['color']) ?>
          </p>
        </div>
        
        
        <div class="mb-3 pb-3 border-bottom">
          <p class="text-muted mb-1">
            <i class="fas fa-map-marker-alt me-2 text-success"></i>
            <strong>Salida:</strong> <?= htmlspecialchars($ride['salida']) ?>
          </p>
          <p class="text-muted mb-0">
            <i class="fas fa-map-marker-alt me-2 text-danger"></i>
            <strong>Llegada:</strong> <?= htmlspecialchars($ride['llegada']) ?>
          </p>
        </div>
        
        
        <div class="mb-3 pb-3 border-bottom">
          <p class="text-muted mb-1">
            <i class="fas fa-calendar-alt me-2"></i>
            <strong>Fecha:</strong> <?= date('d/m/Y', strtotime($ride['fecha'])) ?>
          </p>
          <p class="text-muted mb-0">
            <i class="fas fa-clock me-2"></i>
            <strong>Hora:</strong> <?= date('h:i A', strtotime($ride['hora'])) ?>
          </p>
        </div>
        
        
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <i class="fas fa-users me-2"></i>
            <strong>Espacios:</strong>
            <span class="badge bg-primary"><?= $ride['espacios'] ?></span>
          </div>
          <div>
            <h5 class="mb-0 text-success fw-bold">
              ₡<?= number_format($ride['costo_espacio'], 2) ?>
            </h5>
          </div>
        </div>
      </div>
    </div>
  </a>
</div>