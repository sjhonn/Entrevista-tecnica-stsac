<?php
require_once __DIR__ . '/../../../app/Modelos/Operativo.php';
require_once __DIR__ . '/../../../app/Modelos/Envio.php';
$totalOperativos = count(Operativo::listar($pdo));
$totalEnvios = count(Envio::listar($pdo));
require __DIR__ . '/../compartido/cabecera.php';
?>
<h3 class="mb-4"><i class="fa-solid fa-gauge me-2"></i>Panel de control</h3>
<div class="row g-3">
  <div class="col-12 col-md-4">
    <div class="card text-bg-primary shadow-sm h-100">
      <div class="card-body">
        <h6><i class="fa-solid fa-users me-1"></i>Operativos registrados</h6>
        <p class="fs-3 fw-bold mb-2"><?= $totalOperativos ?></p>
        <a href="index.php?r=operativos" class="btn btn-sm btn-light">Ver todos</a>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="card text-bg-success shadow-sm h-100">
      <div class="card-body">
        <h6><i class="fa-solid fa-box me-1"></i>Envíos registrados</h6>
        <p class="fs-3 fw-bold mb-2"><?= $totalEnvios ?></p>
        <a href="index.php?r=envios" class="btn btn-sm btn-light">Ver todos</a>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-4">
    <div class="card text-bg-warning shadow-sm h-100">
      <div class="card-body">
        <h6><i class="fa-solid fa-database me-1"></i>Respaldo del sistema</h6>
        <p class="small mb-2">Descarga la base de datos + Excel de todas las tablas.</p>
        <a class="btn btn-sm btn-dark" href="respaldo_generar.php"><i class="fa-solid fa-download me-1"></i>Generar respaldo</a>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../compartido/pie.php'; ?>
