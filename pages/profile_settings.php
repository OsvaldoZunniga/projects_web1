<?php
require_once '../database/connection.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/login.css" rel="stylesheet"/> 
</head>
<body>
    <?php if (isset($_GET['msg'])): ?>
        <div class="container mt-3">
            <?php if ($_GET['msg'] == 'update_error'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Algo salió mal al actualizar tus datos. Por favor, intenta de nuevo.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'update_success'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Tus datos han sido actualizados correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif ($_GET['msg'] == 'passwrd_!match'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Contraseñas no coinciden. Por favor, intenta de nuevo.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>

            <?php elseif ($_GET['msg'] == 'img_upload_error'): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Error al subir la imagen. Por favor, intenta de nuevo.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            
            <?php endif; ?>

        </div>
    <?php endif; ?>
    
    <?php
    
        // llenar el formulario con los datos actuales del usuario
        session_start();
        $conn = getConnection_BD();
        $user_id = $_SESSION['idUsuario'];
        $query = "SELECT nombre, apellido, nacimiento, correo, telefono FROM usuarios WHERE idUsuario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
    
    ?>

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-6">
                <div class="card fondo text-white" style="border-radius: 1rem;">
                <div class="card-body p-5">

                    <h2 class="fw-bold mb-4 text-center">Actualizacion de datos</h2>

                    <ul class="nav nav-tabs mb-4 justify-content-center" id="registroTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab" data-bs-toggle="tab" type="button" role="tab">Perfil</button>
                    </li>
                    </ul>

                    <div class="tab-content" id="registroTabsContent">
                        <div class="tab-pane fade show active" role="tabpanel">
                            <form action="../functions/update_users.php" method="POST" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-lg" required value='<?php echo $user['nombre']; ?>'>
                                </div>
                                <div class="col-md-6 mb-3">
                                <label class="form-label">Apellido</label>
                                <input type="text" name="apellido" class="form-control form-control-lg" required value='<?php echo $user['apellido']; ?>'>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" name="nacimiento" class="form-control form-control-lg" required value='<?php echo $user['nacimiento']; ?>'>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="correo" class="form-control form-control-lg" required value='<?php echo $user['correo']; ?>'>
                                </div>
                                <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control form-control-lg" required value='<?php echo $user['telefono']; ?>'>
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
                                <button type="submit" class="btn btn-outline-light btn-lg">Actualizar info</button>
                            </div>
                            </form>
                            <p class="text-center mt-3">
                                <a href="/pages/dashboard.php" class="text-white-50 fw-bold">Regresar al dashboard</a>
                            </p>
                        </div>

                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
