<?php
// Controlador de Envíos: lista, guarda (crea/edita) y elimina registros
require_once __DIR__ . '/../Modelos/Envio.php';

function listarEnvios(PDO $pdo): void
{
    requerirSesion();
    $envios = Envio::listar($pdo);
    $operativos = Operativo::listar($pdo);
    require __DIR__ . '/../../recursos/vistas/panel/envios.php';
}

function guardarEnvio(PDO $pdo): void
{
    requerirSesion();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['id'])) {
            Envio::actualizar($pdo, (int) $_POST['id'], $_POST);
        } else {
            Envio::crear($pdo, $_POST);
        }
    }
    header('Location: index.php?r=envios');
    exit;
}

function eliminarEnvioControlador(PDO $pdo): void
{
    requerirSesion();
    if (!empty($_GET['id'])) {
        Envio::eliminar($pdo, (int) $_GET['id']);
    }
    header('Location: index.php?r=envios');
    exit;
}
