<?php
    require '../functions/users.php';
    session_start();
    $email = $_SESSION['correo'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>navigation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="../assets/logo.jpg" alt="Logo" height="30">
            </a>
            
            <form class="d-flex mx-auto" style="width: 40%;">
                <input class="form-control me-2" type="search" placeholder="Buscar Ride">
                <button class="btn btn-outline-success" type="submit">🔍</button>
            </form>
            <div class="profile d-flex align-items-center position-absolute end-0 top-50 translate-middle-y me-3">
                <a href="../pages/profile_settings.php">
                    <img src="../<?php echo htmlspecialchars(getProfileIcon($email), ENT_QUOTES, 'UTF-8'); ?>" alt="Profile" class="rounded-circle" height="30" style="cursor: pointer;">
                </a>
            </div>
        </div>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>