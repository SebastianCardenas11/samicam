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
            <tr id="filaArchivoAdjunto" style="display: none;">
              <td class="fw-bold">Archivo adjunto:</td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <a href="#" id="linkArchivoAdjunto" target="_blank" class="btn btn-outline-primary btn-xs" style="font-size: 11px; max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    <i class="fas fa-download"></i> <span id="nombreArchivoAdjunto"></span>
                  </a>
                  <button type="button" id="btnPrevisualizarArchivo" class="btn btn-outline-info btn-xs" onclick="previsualizarArchivo()" style="font-size: 11px;">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </td>
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

<!-- Modal para previsualizar archivos -->
<div class="modal fade" id="modalPrevisualizarArchivo" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Previsualización de Archivo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="contenidoPreview" class="text-center">
          <!-- Aquí se cargará el contenido del archivo -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <a href="#" id="btnDescargarArchivo" target="_blank" class="btn btn-primary">
          <i class="fas fa-download"></i> Descargar
        </a>
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

/* Estilos para el modal de previsualización */
#contenidoPreview {
  min-height: 300px;
  max-height: 400px;
  overflow: auto;
}

#contenidoPreview iframe {
  width: 100%;
  height: 350px;
  border: none;
}

#contenidoPreview img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.archivo-no-compatible {
  padding: 40px;
  text-align: center;
  color: #6c757d;
}

.archivo-no-compatible i {
  font-size: 4rem;
  margin-bottom: 20px;
  color: #dee2e6;
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

function previsualizarArchivo() {
  if (typeof window.archivoActual === 'undefined' || !window.archivoActual.ruta) {
    Swal.fire('Error', 'No hay archivo para previsualizar', 'error');
    return;
  }

  const contenidoPreview = document.getElementById('contenidoPreview');
  const btnDescargar = document.getElementById('btnDescargarArchivo');
  
  // Configurar botón de descarga
  btnDescargar.href = window.archivoActual.ruta;
  
  // Limpiar contenido anterior
  contenidoPreview.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Cargando...</div>';
  
  // Mostrar modal
  const modalPreview = new bootstrap.Modal(document.getElementById('modalPrevisualizarArchivo'));
  modalPreview.show();
  
  // Generar preview según el tipo de archivo
  setTimeout(() => {
    generarPreview(window.archivoActual.extension, window.archivoActual.ruta, window.archivoActual.nombre);
  }, 300);
}

function generarPreview(extension, ruta, nombre) {
  const contenidoPreview = document.getElementById('contenidoPreview');
  
  switch(extension.toLowerCase()) {
    case 'pdf':
      contenidoPreview.innerHTML = `<iframe src="${ruta}" type="application/pdf"></iframe>`;
      break;
      
    case 'jpg':
    case 'jpeg':
    case 'png':
    case 'gif':
      contenidoPreview.innerHTML = `<img src="${ruta}" alt="${nombre}" class="img-fluid">`;
      break;
      
    case 'txt':
      // Para archivos de texto, hacer una petición para obtener el contenido
      fetch(ruta)
        .then(response => response.text())
        .then(text => {
          contenidoPreview.innerHTML = `<pre style="text-align: left; background: #f8f9fa; padding: 20px; border-radius: 8px; max-height: 500px; overflow-y: auto;">${text}</pre>`;
        })
        .catch(() => {
          contenidoPreview.innerHTML = mostrarArchivoNoCompatible('txt');
        });
      break;
      
    case 'doc':
    case 'docx':
      // Para documentos de Word, mostrar mensaje informativo
      contenidoPreview.innerHTML = `
        <div class="archivo-no-compatible">
          <i class="fas fa-file-word"></i>
          <h5>Documento de Word</h5>
          <p>Los archivos de Word no se pueden previsualizar en el navegador.</p>
          <p><strong>Archivo:</strong> ${nombre}</p>
          <p>Haz clic en "Descargar" para abrir el archivo.</p>
        </div>`;
      break;
      
    default:
      contenidoPreview.innerHTML = mostrarArchivoNoCompatible(extension);
      break;
  }
}

function mostrarArchivoNoCompatible(extension) {
  return `
    <div class="archivo-no-compatible">
      <i class="fas fa-file"></i>
      <h5>Archivo no compatible para previsualización</h5>
      <p>Los archivos .${extension} no se pueden previsualizar en el navegador.</p>
      <p>Haz clic en "Descargar" para abrir el archivo.</p>
    </div>`;
}
</script>