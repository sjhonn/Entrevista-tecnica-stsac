<?php require __DIR__ . '/../compartido/cabecera.php'; ?>
<div class="row justify-content-center">
  <div class="col-11 col-sm-8 col-md-5 col-lg-4 mt-5">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <div class="text-center mb-4">
          <i class="fa-solid fa-truck-fast fa-2x text-primary"></i>
          <h4 class="mt-2 mb-0">Supply Transport</h4>
          <small class="text-muted">Ingresa a tu panel</small>
        </div>
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger py-2"><i class="fa-solid fa-circle-exclamation me-1"></i><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" required autofocus>
          </div>
          <div class="mb-3">
            <label class="form-label">Clave</label>
            <input type="password" name="clave" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100"><i class="fa-solid fa-right-to-bracket me-1"></i>Ingresar</button>
        </form>
        <p class="text-muted small text-center mt-3 mb-0">Demo: admin@supplytransport.pe / admin123</p>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../compartido/pie.php'; ?>
