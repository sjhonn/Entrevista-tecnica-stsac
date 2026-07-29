<!doctype html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de <?= htmlspecialchars(ucfirst($tipo)) ?> — Supply Transport</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<style>
  @media print { .no-imprimir { display: none; } body { padding: 0 !important; } }
</style>
</head>
<body class="p-4">
  <div class="no-imprimir mb-3 d-flex justify-content-between">
    <h5 class="mb-0"><i class="fa-solid fa-file-pdf"></i> Vista previa del reporte</h5>
    <button class="btn btn-primary btn-sm" onclick="window.print()">Guardar como PDF</button>
  </div>
  <h3>Reporte de <?= htmlspecialchars(ucfirst($tipo)) ?></h3>
  <p class="text-muted">Supply Transport S.A.C. — generado el <?= date('d/m/Y H:i') ?></p>
  <table class="table table-bordered table-sm">
    <thead>
      <tr><?php foreach (array_keys($filas[0] ?? []) as $columna): ?><th><?= htmlspecialchars($columna) ?></th><?php endforeach; ?></tr>
    </thead>
    <tbody>
      <?php foreach ($filas as $fila): ?>
        <tr><?php foreach ($fila as $valor): ?><td><?= htmlspecialchars((string) $valor) ?></td><?php endforeach; ?></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
