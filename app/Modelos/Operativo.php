<?php
// Modelo Operativo: operaciones CRUD sobre la tabla operativos
class Operativo
{
    public static function listar(PDO $pdo): array
    {
        return $pdo->query('SELECT * FROM operativos ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId(PDO $pdo, int $id): array|false
    {
        $consulta = $pdo->prepare('SELECT * FROM operativos WHERE id = :id');
        $consulta->execute(['id' => $id]);
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public static function crear(PDO $pdo, array $datos): void
    {
        $consulta = $pdo->prepare(
            'INSERT INTO operativos (nombre, telefono, placa_vehiculo, estado) VALUES (:nombre, :telefono, :placa, :estado)'
        );
        $consulta->execute([
            'nombre' => $datos['nombre'],
            'telefono' => $datos['telefono'] ?? '',
            'placa' => $datos['placa_vehiculo'] ?? '',
            'estado' => $datos['estado'] ?? 'activo',
        ]);
    }

    public static function actualizar(PDO $pdo, int $id, array $datos): void
    {
        $consulta = $pdo->prepare(
            'UPDATE operativos SET nombre = :nombre, telefono = :telefono, placa_vehiculo = :placa, estado = :estado WHERE id = :id'
        );
        $consulta->execute([
            'nombre' => $datos['nombre'],
            'telefono' => $datos['telefono'] ?? '',
            'placa' => $datos['placa_vehiculo'] ?? '',
            'estado' => $datos['estado'] ?? 'activo',
            'id' => $id,
        ]);
    }

    public static function eliminar(PDO $pdo, int $id): void
    {
        $consulta = $pdo->prepare('DELETE FROM operativos WHERE id = :id');
        $consulta->execute(['id' => $id]);
    }
}
