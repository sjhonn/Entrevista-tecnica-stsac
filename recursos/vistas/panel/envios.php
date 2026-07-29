<?php require __DIR__ . '/../compartido/cabecera.php'; ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
  <h3 class="mb-0"><i class="fa-solid fa-box me-2"></i>Envíos</h3>
  <div class="d-flex flex-wrap gap-2">
    <a href="exportar.php?tipo=envios&formato=excel" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-excel me-1"></i>Excel</a>
    <a href="exportar.php?tipo=envios&formato=pdf" target="_blank" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-file-pdf me-1"></i>PDF</a>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEnvio" onclick="nuevoEnvio()"><i class="fa-solid fa-plus me-1"></i>Nuevo</button>
  </div>
</div>

<div class="table-responsive shadow-sm rounded bg-white">
  <table class="table table-hover align-middle mb-0">
    <thead class="table-dark">
      <tr><th>#</th><th>Cliente</th><th>Origen</th><th>Destino</th><th>Operativo</th><th>Estado</th><th class="text-end">Acciones</th></tr>
    </thead>
    <tbody>
      <?php foreach ($envios as $envio): ?>
      <tr>
        <td><?= (int) $envio['id'] ?></td>
        <td><?= htmlspecialchars($envio['cliente']) ?></td>
        <td><?= htmlspecialchars($envio['origen']) ?></td>
        <td><?= htmlspecialchars($envio['destino']) ?></td>
        <td><?= htmlspecialchars($envio['operativo_nombre'] ?? 'Sin asignar') ?></td>
        <td>
          <?php
          $colores = ['pendiente' => 'secondary', 'en camino' => 'warning', 'entregado' => 'success'];
          $color = $colores[$envio['estado']] ?? 'secondary';
          ?>
          <span class="badge bg-<?= $color ?>"><?= htmlspecialchars($envio['estado']) ?></span>
        </td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-primary" onclick='editarEnvio(<?= json_encode($envio, JSON_HEX_APOS) ?>)'><i class="fa-solid fa-pen"></i></button>
          <a class="btn btn-sm btn-outline-danger" href="index.php?r=envios_eliminar&id=<?= (int) $envio['id'] ?>" onclick="return confirm('¿Eliminar este envío?')"><i class="fa-solid fa-trash"></i></a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($envios)): ?>
      <tr><td colspan="7" class="text-center text-muted py-4">Aún no hay envíos registrados.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- modal único para crear y editar un envío -->
<div class="modal fade" id="modalEnvio" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="index.php?r=envios_guardar">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-box-open me-1"></i>Envío</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="campo_envio_id">
        <div class="mb-2">
          <label class="form-label">Cliente</label>
          <input class="form-control" name="cliente" id="campo_cliente" required>
        </div>
        <div class="row">
          <div class="col-6 mb-2">
            <label class="form-label">Origen</label>
            <input class="form-control" name="origen" id="campo_origen" required>
          </div>
          <div class="col-6 mb-2">
            <label class="form-label">Destino</label>
            <input class="form-control" name="destino" id="campo_destino" required>
          </div>
        </div>
        <div class="mb-2">
          <label class="form-label">Operativo asignado</label>
          <select class="form-select" name="operativo_id" id="campo_operativo_id">
            <option value="">Sin asignar</option>
            <?php foreach ($operativos as $op): ?>
              <option value="<?= (int) $op['id'] ?>"><?= htmlspecialchars($op['nombre']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Estado</label>
          <select class="form-select" name="estado" id="campo_envio_estado">
            <option value="pendiente">Pendiente</option>
            <option value="en camino">En camino</option>
            <option value="entregado">Entregado</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Guardar</button>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../compartido/pie.php'; ?>
