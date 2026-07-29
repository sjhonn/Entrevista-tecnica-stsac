<!doctype html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Supply Transport S.A.C.</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="css/estilos.css">
</head>
<body class="bg-light">
<?php if (!empty($_SESSION['usuario_id'])): ?>
<!-- barra de navegación superior, visible solo con sesión iniciada -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 shadow-sm">
  <a class="navbar-brand" href="index.php?r=panel"><i class="fa-solid fa-truck-fast me-2"></i>Supply Transport</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="menuPrincipal">
    <ul class="navbar-nav me-auto">
      <li class="nav-item"><a class="nav-link" href="index.php?r=panel"><i class="fa-solid fa-gauge me-1"></i>Panel</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?r=operativos"><i class="fa-solid fa-users me-1"></i>Operativos</a></li>
      <li class="nav-item"><a class="nav-link" href="index.php?r=envios"><i class="fa-solid fa-box me-1"></i>Envíos</a></li>
    </ul>
    <span class="navbar-text text-white me-3">
      <i class="fa-solid fa-user-circle me-1"></i><?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
      <span class="badge bg-secondary ms-1"><?= htmlspecialchars($_SESSION['usuario_rol']) ?></span>
    </span>
    <a href="index.php?r=logout" class="btn btn-outline-light btn-sm"><i class="fa-solid fa-right-from-bracket me-1"></i>Salir</a>
  </div>
</nav>
<?php endif; ?>
<main class="container-fluid px-3 px-md-4 py-4">
