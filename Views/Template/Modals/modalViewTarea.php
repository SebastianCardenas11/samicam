<?php 
getModal('modalObservaciones',$data);
?>
<div class="modal fade" id="modalViewTarea" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-black" id="titleModal">Datos de la Tarea</h5>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped">
          <tbody>
            <tr>
              <td class="fw-bold">ID:</td>
              <td id="celId"></td>
            </tr>
            <tr>
              <td class="fw-bold">Creado por:</td>
              <td id="celCreador"></td>
            </tr>
            <tr>
              <td class="fw-bold">Asignado a:</td>
              <td>
                <div id="celAsignado" class="d-flex align-items-center flex-wrap gap-2"></div>
              </td>
            </tr>
            <tr>
              <td class="fw-bold">Tipo:</td>
              <td id="celTipo"></td>
            </tr>
            <tr>
              <td class="fw-bold">Descripción:</td>
              <td id="celDescripcion"></td>
            </tr>
            <tr>
              <td class="fw-bold">Dependencia:</td>
              <td id="celDependencia"></td>
            </tr>
            <tr>
              <td class="fw-bold">Estado:</td>
              <td id="celEstado"></td>
            </tr>
            <tr>
              <td class="fw-bold">Observaciones:</td>
              <td id="celObservacion"></td>
            </tr>
            <tr>
              <td class="fw-bold">Fecha de inicio:</td>
              <td id="celFechaInicio"></td>
            </tr>
            <tr>
              <td class="fw-bold">Fecha de fin:</td>
              <td id="celFechaFin"></td>
            </tr>
            <tr>
              <td class="fw-bold">Tiempo restante:</td>
              <td id="celTiempoRestante"></td>
            </tr>
            <tr>
              <td class="fw-bold">Fecha completada:</td>
              <td id="celFechaCompletada"></td>
            </tr>
          </tbody>
        </table>
        <div class="text-center mt-3" id="divAgregarObservacion">
          <button class="btn btn-primary" type="button" onclick="openModalObservaciones(document.querySelector('#celId').innerText);"><i class="fas fa-comment-plus"></i> Agregar observación</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para ver todos los usuarios asignados -->
<div class="modal fade" id="modalVerUsuarios" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Usuarios Asignados</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="listaCompletaUsuarios" class="d-flex flex-column gap-2"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<style>
.header-primary {
  background-color: #6c757d;
  color: white;
}
.fw-bold {
  font-weight: 600;
}

.usuario-badge {
  display: inline-flex;
  align-items: center;
  background-color: #e9ecef;
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.9em;
  margin: 2px;
}

.ver-mas-btn {
  display: inline-flex;
  align-items: center;
  background-color: #007bff;
  color: white;
  padding: 4px 12px;
  border-radius: 15px;
  font-size: 0.9em;
  border: none;
  cursor: pointer;
  margin: 2px;
}

.ver-mas-btn:hover {
  background-color: #0056b3;
}

.contador-usuarios {
  background-color: rgba(255, 255, 255, 0.2);
  padding: 2px 8px;
  border-radius: 10px;
  margin-left: 5px;
  font-size: 0.85em;
}

#listaCompletaUsuarios .usuario-badge {
  margin: 0;
}
</style>

<script>
function mostrarUsuariosAsignados(usuarios) {
  const contenedor = document.getElementById('celAsignado');
  contenedor.innerHTML = '';

  // Mostrar solo los primeros 2 usuarios
  usuarios.slice(0, 2).forEach(usuario => {
    const badge = document.createElement('div');
    badge.className = 'usuario-badge';
    badge.innerHTML = `<i class="fas fa-user me-1"></i> ${usuario.nombres}`;
    contenedor.appendChild(badge);
  });

  // Si hay más de 2 usuarios, mostrar botón "Ver más"
  if (usuarios.length > 2) {
    const verMasBtn = document.createElement('button');
    verMasBtn.className = 'ver-mas-btn';
    verMasBtn.innerHTML = `<i class="fas fa-users me-1"></i> Ver más <span class="contador-usuarios">+${usuarios.length - 2}</span>`;
    verMasBtn.onclick = () => mostrarTodosLosUsuarios(usuarios);
    contenedor.appendChild(verMasBtn);
  }
}

function mostrarTodosLosUsuarios(usuarios) {
  const listaUsuarios = document.getElementById('listaCompletaUsuarios');
  listaUsuarios.innerHTML = '';
  
  usuarios.forEach(usuario => {
    const badge = document.createElement('div');
    badge.className = 'usuario-badge w-100';
    badge.innerHTML = `<i class="fas fa-user me-2"></i> ${usuario.nombres}`;
    listaUsuarios.appendChild(badge);
  });
  
  const modalVerUsuarios = new bootstrap.Modal(document.getElementById('modalVerUsuarios'));
  modalVerUsuarios.show();
}
</script>