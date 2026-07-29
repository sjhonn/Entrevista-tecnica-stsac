<?php
// Modelo Envio: operaciones CRUD sobre la tabla envios, incluye datos del operativo asignado
class Envio
{
    public static function listar(PDO $pdo): array
    {
        $sql = 'SELECT envios.*, operativos.nombre AS operativo_nombre
                FROM envios
                LEFT JOIN operativos ON operativos.id = envios.operativo_id
                ORDER BY envios.id DESC';
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId(PDO $pdo, int $id): array|false
    {
        $consulta = $pdo->prepare('SELECT * FROM envios WHERE id = :id');
        $consulta->execute(['id' => $id]);
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public static function crear(PDO $pdo, array $datos): void
    {
        $consulta = $pdo->prepare(
            'INSERT INTO envios (cliente, origen, destino, operativo_id, estado) VALUES (:cliente, :origen, :destino, :operativo_id, :estado)'
        );
        $consulta->execute([
            'cliente' => $datos['cliente'],
            'origen' => $datos['origen'],
            'destino' => $datos['destino'],
            'operativo_id' => $datos['operativo_id'] ?: null,
            'estado' => $datos['estado'] ?? 'pendiente',
        ]);
    }

    public static function actualizar(PDO $pdo, int $id, array $datos): void
    {
        $consulta = $pdo->prepare(
            'UPDATE envios SET cliente = :cliente, origen = :origen, destino = :destino, operativo_id = :operativo_id, estado = :estado WHERE id = :id'
        );
        $consulta->execute([
            'cliente' => $datos['cliente'],
            'origen' => $datos['origen'],
            'destino' => $datos['destino'],
            'operativo_id' => $datos['operativo_id'] ?: null,
            'estado' => $datos['estado'] ?? 'pendiente',
            'id' => $id,
        ]);
    }

    public static function eliminar(PDO $pdo, int $id): void
    {
        $consulta = $pdo->prepare('DELETE FROM envios WHERE id = :id');
        $consulta->execute(['id' => $id]);
    }
}
