<?php
// Controlador de autenticación: procesa el login, el logout y protege las rutas privadas
require_once __DIR__ . '/../Modelos/Usuario.php';

function procesarLogin(PDO $pdo): void
{
    $error = null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $correo = trim($_POST['correo'] ?? '');
        $clave = $_POST['clave'] ?? '';
        $usuario = Usuario::buscarPorCorreo($pdo, $correo);

        if ($usuario && password_verify($clave, $usuario['clave'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
            header('Location: index.php?r=panel');
            exit;
        }
        $error = 'Correo o clave incorrectos';
    }
    require __DIR__ . '/../../recursos/vistas/autenticacion/login.php';
}

function cerrarSesion(): void
{
    $_SESSION = [];
    session_destroy();
    header('Location: index.php?r=login');
    exit;
}

function requerirSesion(): void
{
    if (empty($_SESSION['usuario_id'])) {
        header('Location: index.php?r=login');
        exit;
    }
}
