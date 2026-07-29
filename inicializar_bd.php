<?php
// Script de instalación: crea la base de datos, sus tablas y datos de ejemplo (usuario admin incluido)
require_once __DIR__ . '/config/conexion.php';

$pdo = obtenerConexion();
$entorno = cargarEntorno();
$archivoEsquema = ($entorno['DB_CONEXION'] ?? 'sqlite') === 'mysql' ? 'esquema_mysql.sql' : 'esquema.sql';
$pdo->exec(file_get_contents(__DIR__ . '/baseDatos/' . $archivoEsquema));

$existe = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE correo = 'admin@supplytransport.pe'")->fetchColumn();

if ($existe == 0) {
    $clave = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->prepare('INSERT INTO usuarios (nombre, correo, clave, rol) VALUES (?, ?, ?, ?)')
        ->execute(['Administrador', 'admin@supplytransport.pe', $clave, 'administrador']);

    $pdo->exec("INSERT INTO operativos (nombre, telefono, placa_vehiculo, estado) VALUES ('Juan Pérez', '999111222', 'ABC-123', 'activo')");
    $pdo->exec("INSERT INTO operativos (nombre, telefono, placa_vehiculo, estado) VALUES ('Luis Ramos', '999333444', 'XYZ-789', 'activo')");

    $pdo->exec("INSERT INTO envios (cliente, origen, destino, operativo_id, estado) VALUES ('Minera Sur SAC', 'Lima', 'Arequipa', 1, 'en camino')");
    $pdo->exec("INSERT INTO envios (cliente, origen, destino, operativo_id, estado) VALUES ('Agroindustrias Norte', 'Lima', 'Trujillo', 2, 'pendiente')");

    echo "Base de datos inicializada correctamente.\n";
    echo "Usuario administrador -> correo: admin@supplytransport.pe / clave: admin123\n";
} else {
    echo "La base de datos ya estaba inicializada, no se duplicaron datos.\n";
}
