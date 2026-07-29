<?php require __DIR__ . '/../compartido/cabecera.php'; ?>
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
  <h3 class="mb-0"><i class="fa-solid fa-users me-2"></i>Operativos</h3>
  <div class="d-flex flex-wrap gap-2">
    <a href="exportar.php?tipo=operativos&formato=excel" class="btn btn-outline-success btn-sm"><i class="fa-solid fa-file-excel me-1"></i>Excel</a>
    <a href="exportar.php?tipo=operativos&formato=pdf" target="_blank" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-file-pdf me-1"></i>PDF</a>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalOperativo" onclick="nuevoOperativo()"><i class="fa-solid fa-plus me-1"></i>Nuevo</button>
  </div>
</div>

<div class="table-responsive shadow-sm rounded bg-white">
  <table class="table table-hover align-middle mb-0">
    <thead class="table-dark">
      <tr><th>#</th><th>Nombre</th><th>Teléfono</th><th>Placa</th><th>Estado</th><th class="text-end">Acciones</th></tr>
    </thead>
    <tbody>
      <?php foreach ($operativos as $op): ?>
      <tr>
        <td><?= (int) $op['id'] ?></td>
        <td><?= htmlspecialchars($op['nombre']) ?></td>
        <td><?= htmlspecialchars($op['telefono']) ?></td>
        <td><?= htmlspecialchars($op['placa_vehiculo']) ?></td>
        <td><span class="badge bg-<?= $op['estado'] === 'activo' ? 'success' : 'secondary' ?>"><?= htmlspecialchars($op['estado']) ?></span></td>
        <td class="text-end">
          <button class="btn btn-sm btn-outline-primary" onclick='editarOperativo(<?= json_encode($op, JSON_HEX_APOS) ?>)'><i class="fa-solid fa-pen"></i></button>
          <a class="btn btn-sm btn-outline-danger" href="index.php?r=operativos_eliminar&id=<?= (int) $op['id'] ?>" onclick="return confirm('¿Eliminar este operativo?')"><i class="fa-solid fa-trash"></i></a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php if (empty($operativos)): ?>
      <tr><td colspan="6" class="text-center text-muted py-4">Aún no hay operativos registrados.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- modal único para crear y editar un operativo -->
<div class="modal fade" id="modalOperativo" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="index.php?r=operativos_guardar">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-user-gear me-1"></i>Operativo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="campo_id">
        <div class="mb-2">
          <label class="form-label">Nombre</label>
          <input class="form-control" name="nombre" id="campo_nombre" required>
        </div>
        <div class="mb-2">
          <label class="form-label">Teléfono</label>
          <input class="form-control" name="telefono" id="campo_telefono">
        </div>
        <div class="mb-2">
          <label class="form-label">Placa del vehículo</label>
          <input class="form-control" name="placa_vehiculo" id="campo_placa">
        </div>
        <div class="mb-2">
          <label class="form-label">Estado</label>
          <select class="form-select" name="estado" id="campo_estado">
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
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
