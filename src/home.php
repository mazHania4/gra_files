<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: /');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gra_files - Home</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css">
    <!-- CSS Principal -->
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar bg-custom sidebar-sticky">
        <div class="user-info text-center p-4">
            <a href="" class="d-flex fs-5 align-items-center text-white text-decoration-none">
                <i class="fa-regular fa-circle-user user-icon"></i>
                <span class="d-none d-sm-inline mx-4"><?php echo htmlspecialchars($_SESSION['username'])?></span>
            </a>
        </div>
        <div class="mx-4 my-2">
            <small class="text-info">Módulo <?= $_SESSION['role'] == 'admin' ? 'Administrador' : 'Empleado'; ?></small>
        </div>
        <div class="m-4">

            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="home.php?folder=/<?= $_SESSION['username'];?>/root" class="nav-link px-0 align-middle">
                        <i class="fa-solid fa-folder-closed"></i> <span class="ms-1 d-none d-sm-inline">Mis Archivos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="home.php?folder=/<?= $_SESSION['username'];?>/shared" class="nav-link px-0 align-middle">
                        <i class="fa-solid fa-square-share-nodes"></i> <span class="ms-1 d-none d-sm-inline">Compartidos</span>
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a href="/api/ctrl/logout.php" class="nav-link text-danger">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="content p-4 flex-grow-1">
        <h2>Gra Files</h2>
        <div class="folder-content mt-3">
            <!-- Se carga el contenido de la carpeta -->
            <?php
            include 'display_folder.php'; 
            ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
