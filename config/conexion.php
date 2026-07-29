<?php
// Conexión única a la base de datos: usa SQLite en local y MySQL en producción según .env

function cargarEntorno(): array {
    $ruta = __DIR__ . '/../.env';
    if (!file_exists($ruta)) {
        $ruta = __DIR__ . '/../.env.example';
    }
    $variables = [];
    foreach (file($ruta) as $linea) {
        $linea = trim($linea);
        if ($linea === '' || $linea[0] === '#' || !str_contains($linea, '=')) {
            continue;
        }
        [$clave, $valor] = explode('=', $linea, 2);
        $variables[trim($clave)] = trim($valor, " \t\n\r\0\x0B\"");
    }
    return $variables;
}

function obtenerConexion(): PDO {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $entorno = cargarEntorno();

    if (($entorno['DB_CONEXION'] ?? 'sqlite') === 'mysql') {
        $dsn = "mysql:host={$entorno['DB_HOST']};dbname={$entorno['DB_NOMBRE']};charset=utf8mb4";
        $pdo = new PDO($dsn, $entorno['DB_USUARIO'] ?? 'root', $entorno['DB_CLAVE'] ?? '');
    } else {
        $rutaSqlite = __DIR__ . '/../baseDatos/supply_transport.sqlite';
        $pdo = new PDO('sqlite:' . $rutaSqlite);
        $pdo->exec('PRAGMA foreign_keys = ON');
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
