<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../svc/auth_svc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $authService = new AuthService();
    $user = $authService->authenticate($username, $password);

    if ($user) {
        // Guardar el nombre y tipo de usuario en la sesión
        $_SESSION['username'] = $user['_id'];
        $_SESSION['role'] = $user['role'];
        header("Location: /home.php?folder=/".$user['_id']."/root");
        exit();
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: /");
        exit();
    }
}
?>
