// Script para manejar departamentos y ciudades en el modal de funcionarios
document.addEventListener('DOMContentLoaded', function() {
    // Cargar departamentos al abrir el modal
    const modalFuncionario = document.getElementById('modalFormFuncionario');
    if (modalFuncionario) {
        modalFuncionario.addEventListener('shown.bs.modal', function() {
            cargarDepartamentos('txtDepartamentoExpedicion');
            cargarDepartamentos('txtDepartamentoNacimiento');
        });
    }
    
    // Event listener para departamento de expedición
    const deptExpedicion = document.getElementById('txtDepartamentoExpedicion');
    if (deptExpedicion) {
        deptExpedicion.addEventListener('change', function() {
            const departamentoId = this.value;
            if (departamentoId) {
                cargarCiudades(departamentoId, 'txtCiudadExpedicion');
            } else {
                document.getElementById('txtCiudadExpedicion').innerHTML = '<option value="">Selecciona una ciudad</option>';
                document.getElementById('txtCiudadExpedicion').disabled = true;
            }
        });
    }
    
    // Event listener para departamento de nacimiento
    const deptNacimiento = document.getElementById('txtDepartamentoNacimiento');
    if (deptNacimiento) {
        deptNacimiento.addEventListener('change', function() {
            const departamentoId = this.value;
            if (departamentoId) {
                cargarCiudades(departamentoId, 'txtCiudadNacimiento');
            } else {
                document.getElementById('txtCiudadNacimiento').innerHTML = '<option value="">Selecciona una ciudad</option>';
                document.getElementById('txtCiudadNacimiento').disabled = true;
            }
        });
    }
    
    // Función para obtener ubicación completa antes de enviar el formulario
    const form = document.getElementById('formFuncionario');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Obtener ubicación completa para expedición
            const ubicacionExpedicion = obtenerUbicacionCompleta('txtDepartamentoExpedicion', 'txtCiudadExpedicion');
            if (ubicacionExpedicion) {
                let inputExpedicion = document.getElementById('txtLugarExpedicion');
                if (!inputExpedicion) {
                    inputExpedicion = document.createElement('input');
                    inputExpedicion.type = 'hidden';
                    inputExpedicion.id = 'txtLugarExpedicion';
                    inputExpedicion.name = 'txtLugarExpedicion';
                    form.appendChild(inputExpedicion);
                }
                inputExpedicion.value = ubicacionExpedicion;
            }
            
            // Obtener ubicación completa para nacimiento
            const ubicacionNacimiento = obtenerUbicacionCompleta('txtDepartamentoNacimiento', 'txtCiudadNacimiento');
            if (ubicacionNacimiento) {
                let inputNacimiento = document.getElementById('txtLugarNacimiento');
                if (!inputNacimiento) {
                    inputNacimiento = document.createElement('input');
                    inputNacimiento.type = 'hidden';
                    inputNacimiento.id = 'txtLugarNacimiento';
                    inputNacimiento.name = 'txtLugarNacimiento';
                    form.appendChild(inputNacimiento);
                }
                inputNacimiento.value = ubicacionNacimiento;
            }
        });
    }
});