<?php
// Exporta operativos o envíos a Excel (CSV con BOM UTF-8) o a una vista imprimible en PDF
session_start();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../app/Modelos/Operativo.php';
require_once __DIR__ . '/../app/Modelos/Envio.php';

if (empty($_SESSION['usuario_id'])) {
    http_response_code(403);
    exit('No autorizado');
}

$pdo = obtenerConexion();
$tipo = $_GET['tipo'] === 'envios' ? 'envios' : 'operativos';
$formato = $_GET['formato'] ?? 'excel';
$filas = $tipo === 'envios' ? Envio::listar($pdo) : Operativo::listar($pdo);

if ($formato === 'excel') {
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $tipo . '.csv"');
    $salida = fopen('php://output', 'w');
    fputs($salida, "\xEF\xBB\xBF"); // BOM para que Excel muestre bien las tildes/ñ
    if (!empty($filas)) {
        fputcsv($salida, array_keys($filas[0]));
    }
    foreach ($filas as $fila) {
        fputcsv($salida, $fila);
    }
    fclose($salida);
    exit;
}

// formato = pdf -> vista imprimible que el usuario guarda como PDF con el navegador
require __DIR__ . '/../recursos/vistas/panel/reporte_imprimible.php';
