<?php

if (!isset($_SESSION['idUsuario']) || $_SESSION['idRoles'] != 3) {
    header("Location: ../index.php?msg=invalid");
    exit();
}

require_once '../database/queries.php';
require_once '../database/connection.php';
$conn = getConnection_BD();
$usuarios = obtenerUsuariosActivos($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel de Administrador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../css/login.css?v=2">
</head>
<body>
<?php include '../templates/nav.php'; ?>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-<?= $_GET['msg'] === 'desactivado' ? 'success' : 'danger' ?> text-center" role="alert">
        <?= $_GET['msg'] === 'desactivado' ? 'Usuario desactivado correctamente.' : 'Ocurrió un error al desactivar el usuario.' ?>
    </div>
<?php endif; ?>
 
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-start h-100">

      <div class="col-12 col-md-11 col-lg-10 col-xl-9">
        <div class="card fondo" style="border-radius: 1rem;">
          <div class="card-body p-5">

            <h2 class="fw-bold mb-4 text-center">Registrar Administrador</h2>
            <p class="text-center mb-4">Completa la información para crear una cuenta administrativa.</p>

            <form action="../functions/users.php" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="idRoles" value="3">

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nombre</label>
                  <input type="text" name="nombre" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Apellido</label>
                  <input type="text" name="apellido" class="form-control form-control-lg" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Cédula</label>
                  <input type="text" name="cedula" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Fecha de Nacimiento</label>
                  <input type="date" name="nacimiento" class="form-control form-control-lg" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Correo Electrónico</label>
                  <input type="email" name="correo" class="form-control form-control-lg" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Teléfono</label>
                  <input type="text" name="telefono" class="form-control form-control-lg" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Fotografía</label>
                <input type="file" name="fotografia" class="form-control form-control-lg" accept="image/*">
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Contraseña</label>
                  <input type="password" name="contrasena" class="form-control form-control-lg" required>
                </div>                
                <div class="col-md-6 mb-3">
                  <label class="form-label">Confirmar Contraseña</label>
                  <input type="password" name="contrasena_confirm" class="form-control form-control-lg" required>
                </div>
              </div>

              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-outline-light btn-lg">Registrar Administrador</button>
              </div>

            </form>
            <p class="text-center mt-3">
                <a href="../index.php" class="text-white-50 fw-bold">Cerrar Sesion</a>
            </p>

          </div>
        </div>
      </div>
      
      <div class="col-12 col-md-11 col-lg-10 col-xl-9 mt-4">
        <div class="card fondo text-white p-4" style="border-radius: 20px; box-shadow: 0 4px 24px rgba(39, 174, 96, 0.12);">
          <h3 class="fw-bold mb-4 text-center" style="color: #eaf7d2;">Usuarios Activos</h3>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead style="background-color: #2ECC71; color: #fffde8;">
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Cédula</th>
                  <th>Correo</th>
                  <th>Rol</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody style="background-color: #fffde8; color: #13281F;">
                <?php foreach($usuarios as $user): ?>
                <tr>
                <td><?= htmlspecialchars($user['nombre']) ?></td>
                <td><?= htmlspecialchars($user['apellido']) ?></td>
                <td><?= htmlspecialchars($user['cedula']) ?></td>
                <td><?= htmlspecialchars($user['correo']) ?></td>
                <td><?= htmlspecialchars($user['nombreRol']) ?></td>
                <td>
                   <form method="POST" action="../functions/adminActions.php" style="display:inline;">
                    <input type="hidden" name="idUsuario" value="<?= $user['idUsuario'] ?>">
                    <input type="hidden" name="accion" value="desactivar">
                    <button type="submit" class="btn btn-danger btn-sm">Desactivar</button>
                </form>
                </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>