<?php
require '../functions/users.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$email = $_SESSION['correo'] ?? '';
?>
<nav class="navbar navbar-expand-lg" style="background-color: #1A281E; color: #fefce0;">
  <div class="container-fluid px-4">
    <a class="navbar-brand d-flex align-items-center text-decoration-none" href="#" style="color: #fefce0;">
      <img src="../assets/logo.jpg" alt="Logo" height="35" class="me-2 rounded-circle">
      <span class="fw-bold">RideConnect</span>
    </a>

    <div class="profile d-flex align-items-center">
      <a href="../pages/profile_settings.php">
        <img src="../<?php echo htmlspecialchars(getProfileIcon($email), ENT_QUOTES, 'UTF-8'); ?>" 
             alt="Profile" class="rounded-circle border border-light" height="35" style="cursor: pointer;">
      </a>
    </div>
  </div>
</nav>