<?php
// Genera un respaldo del sistema: copia de la base de datos + Excel de cada tabla, todo comprimido en un .zip
session_start();
if (empty($_SESSION['usuario_id'])) {
    http_response_code(403);
    exit('No autorizado');
}

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../app/Modelos/Operativo.php';
require_once __DIR__ . '/../app/Modelos/Envio.php';

$pdo = obtenerConexion();
$entorno = cargarEntorno();
$carpetaRespaldos = __DIR__ . '/../baseDatos/respaldos';
if (!is_dir($carpetaRespaldos)) {
    mkdir($carpetaRespaldos, 0777, true);
}

$fecha = date('Y-m-d_His');
$nombreZip = "respaldo_{$fecha}.zip";
$rutaZip = "$carpetaRespaldos/$nombreZip";

$zip = new ZipArchive();
$zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// si es SQLite, incluir el archivo de base de datos completo
if (($entorno['DB_CONEXION'] ?? 'sqlite') !== 'mysql') {
    $rutaSqlite = __DIR__ . '/../baseDatos/supply_transport.sqlite';
    if (file_exists($rutaSqlite)) {
        $zip->addFile($rutaSqlite, 'base_datos.sqlite');
    }
}

// exportar cada tabla a un archivo Excel (CSV) dentro del zip
$tablas = ['operativos' => Operativo::listar($pdo), 'envios' => Envio::listar($pdo)];
foreach ($tablas as $nombreTabla => $filas) {
    $csv = "\xEF\xBB\xBF";
    if (!empty($filas)) {
        $csv .= implode(',', array_keys($filas[0])) . "\r\n";
        foreach ($filas as $fila) {
            $csv .= implode(',', array_map(fn ($valor) => '"' . str_replace('"', '""', (string) $valor) . '"', $fila)) . "\r\n";
        }
    }
    $zip->addFromString("$nombreTabla.csv", $csv);
}
$zip->close();

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $nombreZip . '"');
header('Content-Length: ' . filesize($rutaZip));
readfile($rutaZip);
exit;
