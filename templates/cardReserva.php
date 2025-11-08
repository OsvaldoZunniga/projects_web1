<div class="col-md-4 mb-4">
	<div class="card shadow border-0 h-100 card-clickable" style="border-radius: 0.8rem;">
		<div class="card-header text-white text-center" style="background-color: #2ECC71; border-radius: 0.8rem 0.8rem 0 0;">
			<h6 class="mb-0 fw-bold">Reserva #<?= htmlspecialchars($reserva['idReserva']) ?></h6>
			<small class="d-block">Ride: <?= htmlspecialchars($reserva['ride_nombre'] ?? '') ?></small>
			<small class="d-block">Solicitante: <?= htmlspecialchars($reserva['nombre']) ?> <?= htmlspecialchars($reserva['apellido']) ?> </small>
		</div>

		<div class="card-body">
			<p class="text-muted mb-1"><i class="fas fa-id-card me-2"></i><strong>Cédula:</strong> <?= htmlspecialchars($reserva['cedula']) ?></p>
			<p class="text-muted mb-2"><i class="fas fa-envelope me-2"></i><strong>Correo:</strong> <?= htmlspecialchars($reserva['correo']) ?></p>

			<div class="d-flex justify-content-between align-items-center mt-3">
				<div>
					<span class="badge bg-primary">Estado: <?= htmlspecialchars($reserva['estado']) ?></span>
				</div>
				<div class="text-end">
					<!-- Formulario aceptar -->
					<form method="POST" action="../functions/update_reservas.php" style="display:inline-block; margin-right:6px;">
						<input type="hidden" name="action" value="aceptar">
						<input type="hidden" name="idReserva" value="<?= htmlspecialchars($reserva['idReserva']) ?>">
						<button type="submit" class="btn btn-success btn-sm" <?= $reserva['estado'] !== 'Pendiente' ? 'disabled' : '' ?>>Aceptar</button>
					</form>

					<!-- Formulario cancelar -->
					<form method="POST" action="../functions/update_reservas.php" style="display:inline-block;">
						<input type="hidden" name="action" value="cancelar">
						<input type="hidden" name="idReserva" value="<?= htmlspecialchars($reserva['idReserva']) ?>">
						<button type="submit" class="btn btn-danger btn-sm" <?= $reserva['estado'] !== 'Pendiente' ? 'disabled' : '' ?>>Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
