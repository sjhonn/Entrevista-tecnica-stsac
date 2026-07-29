// Controla los modales de creación/edición de Operativos y Envíos, sin dependencias externas

function nuevoOperativo() {
  document.getElementById('campo_id').value = '';
  document.getElementById('campo_nombre').value = '';
  document.getElementById('campo_telefono').value = '';
  document.getElementById('campo_placa').value = '';
  document.getElementById('campo_estado').value = 'activo';
}

function editarOperativo(operativo) {
  document.getElementById('campo_id').value = operativo.id;
  document.getElementById('campo_nombre').value = operativo.nombre;
  document.getElementById('campo_telefono').value = operativo.telefono;
  document.getElementById('campo_placa').value = operativo.placa_vehiculo;
  document.getElementById('campo_estado').value = operativo.estado;
  new bootstrap.Modal(document.getElementById('modalOperativo')).show();
}

function nuevoEnvio() {
  document.getElementById('campo_envio_id').value = '';
  document.getElementById('campo_cliente').value = '';
  document.getElementById('campo_origen').value = '';
  document.getElementById('campo_destino').value = '';
  document.getElementById('campo_operativo_id').value = '';
  document.getElementById('campo_envio_estado').value = 'pendiente';
}

function editarEnvio(envio) {
  document.getElementById('campo_envio_id').value = envio.id;
  document.getElementById('campo_cliente').value = envio.cliente;
  document.getElementById('campo_origen').value = envio.origen;
  document.getElementById('campo_destino').value = envio.destino;
  document.getElementById('campo_operativo_id').value = envio.operativo_id ?? '';
  document.getElementById('campo_envio_estado').value = envio.estado;
  new bootstrap.Modal(document.getElementById('modalEnvio')).show();
}
