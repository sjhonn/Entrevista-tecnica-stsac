<?php
// Controlador de Operativos: lista, guarda (crea/edita) y elimina registros
require_once __DIR__ . '/../Modelos/Operativo.php';

function listarOperativos(PDO $pdo): void
{
    requerirSesion();
    $operativos = Operativo::listar($pdo);
    require __DIR__ . '/../../recursos/vistas/panel/operativos.php';
}

function guardarOperativo(PDO $pdo): void
{
    requerirSesion();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['id'])) {
            Operativo::actualizar($pdo, (int) $_POST['id'], $_POST);
        } else {
            Operativo::crear($pdo, $_POST);
        }
    }
    header('Location: index.php?r=operativos');
    exit;
}

function eliminarOperativoControlador(PDO $pdo): void
{
    requerirSesion();
    if (!empty($_GET['id'])) {
        Operativo::eliminar($pdo, (int) $_GET['id']);
    }
    header('Location: index.php?r=operativos');
    exit;
}
