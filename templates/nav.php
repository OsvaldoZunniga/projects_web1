<?php
require '../functions/users.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$email = $_SESSION['correo'] ?? ''; //esto es para ubicar por medio del correo la foto de perfil del usuario y mostrarla
?>
<nav class="navbar navbar-expand-lg" style="background-color:  #13281F; color:#f1f6e9">
  <div class="container-fluid px-4">
    <a class="navbar-brand d-flex align-items-center text-decoration-none" href="#" style="color: #f1f6e9;">
      <img src="../assets/logo.jpg" alt="Logo" height="35" class="me-2 rounded-circle">
      <span class="fw-bold">Aventones</span>
    </a>

    <div class="profile d-flex align-items-center">
      <a href="../pages/profile_settings.php">
        <img src="../<?php echo htmlspecialchars(getProfileIcon($email), ENT_QUOTES, 'UTF-8'); ?>" 
             alt="Profile" class="rounded-circle border border-light" height="35" style="cursor: pointer;">
      </a>
      
      <a href="../functions/signIn.php?logout=true" class="btn btn-success ms-3" style="background-color: #2ECC71; border-color: #2ECC71;">
        <i class="fas fa-sign-out-alt me-1"></i>
        Cerrar Sesión
      </a>
    </div>
  </div>
</nav>