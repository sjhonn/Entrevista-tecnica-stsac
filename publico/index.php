<?php
// Enrutador principal: define las rutas disponibles del sistema (patrón front controller)
session_start();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../app/Controladores/AutenticacionControlador.php';
require_once __DIR__ . '/../app/Controladores/OperativoControlador.php';
require_once __DIR__ . '/../app/Controladores/EnvioControlador.php';

$pdo = obtenerConexion();
$ruta = $_GET['r'] ?? 'login';

switch ($ruta) {
    case 'login':
        procesarLogin($pdo);
        break;
    case 'logout':
        cerrarSesion();
        break;
    case 'panel':
        requerirSesion();
        require __DIR__ . '/../recursos/vistas/panel/panel.php';
        break;
    case 'operativos':
        listarOperativos($pdo);
        break;
    case 'operativos_guardar':
        guardarOperativo($pdo);
        break;
    case 'operativos_eliminar':
        eliminarOperativoControlador($pdo);
        break;
    case 'envios':
        listarEnvios($pdo);
        break;
    case 'envios_guardar':
        guardarEnvio($pdo);
        break;
    case 'envios_eliminar':
        eliminarEnvioControlador($pdo);
        break;
    default:
        http_response_code(404);
        echo 'Página no encontrada';
}
