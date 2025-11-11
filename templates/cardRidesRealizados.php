
			<div class="col-md-4 mb-4">
				<div class="card shadow border-0 h-100" style="border-radius: 0.8rem; transition: transform 0.2s;">
					<div class="card-header text-white text-center" style="background-color: #2ECC71; border-radius: 0.8rem 0.8rem 0 0;">
						<h5 class="mb-0 fw-bold"><?= htmlspecialchars($rideRealizado['nombre']) ?></h5>
					</div>
					<div class="card-body">
						<div class="mb-3 pb-3 border-bottom">
							<p class="text-muted mb-1">
								<i class="fas fa-car me-2"></i>
								<strong>Vehículo:</strong> <?= htmlspecialchars($rideRealizado['marca']) ?> <?= htmlspecialchars($rideRealizado['modelo']) ?>
							</p>
							<p class="text-muted mb-0">
								<i class="fas fa-palette me-2"></i>
								<strong>Color:</strong> <?= htmlspecialchars($rideRealizado['color']) ?>
							</p>
						</div>
						<div class="mb-3 pb-3 border-bottom">
							<p class="text-muted mb-1">
								<i class="fas fa-map-marker-alt me-2 text-success"></i>
								<strong>Salida:</strong> <?= htmlspecialchars($rideRealizado['salida']) ?>
							</p>
							<p class="text-muted mb-0">
								<i class="fas fa-map-marker-alt me-2 text-danger"></i>
								<strong>Llegada:</strong> <?= htmlspecialchars($rideRealizado['llegada']) ?>
							</p>
						</div>
						<div class="mb-3 pb-3 border-bottom">
							<p class="text-muted mb-1">
								<i class="fas fa-calendar-alt me-2"></i>
								<strong>Fecha:</strong> <?= date('d/m/Y', strtotime($rideRealizado['fecha'])) ?>
							</p>
							<p class="text-muted mb-0">
								<i class="fas fa-clock me-2"></i>
								<strong>Hora:</strong> <?= date('h:i A', strtotime($rideRealizado['hora'])) ?>
							</p>
						</div>
						<div class="d-flex justify-content-between align-items-center">
							<div>
								<i class="fas fa-users me-2"></i>
								<strong>Espacios:</strong>
								<span class="badge bg-primary"><?= htmlspecialchars($rideRealizado['espacios']) ?></span>
							</div>
							<div>
								<h5 class="mb-0 text-success fw-bold">
									₡<?= number_format($rideRealizado['costo_espacio'], 2) ?> c/u 
								</h5>
							</div>
						</div>
						<div class="mt-3 text-center">
							<span class="badge bg-success">Realizado</span>
						</div>
					</div>
				</div>
			</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
