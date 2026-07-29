<?php
// Modelo Usuario: acceso a la tabla usuarios para el proceso de autenticación
class Usuario
{
    public static function buscarPorCorreo(PDO $pdo, string $correo): array|false
    {
        $consulta = $pdo->prepare('SELECT * FROM usuarios WHERE correo = :correo');
        $consulta->execute(['correo' => $correo]);
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }
}
