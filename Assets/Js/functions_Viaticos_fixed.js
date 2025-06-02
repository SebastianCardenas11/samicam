let tableHistorico;
let tableDetalle;
let chartCapital;
let chartComparativa;

function openModalViatico() {
    document.getElementById('formViaticos').reset();
    const hoy = new Date();
    document.getElementById('txtFechaAprobacion').valueAsDate = hoy;
    document.getElementById('txtFechaSalida').valueAsDate = hoy;
    document.getElementById('txtFechaRegreso').valueAsDate = hoy;
    
    // Cargar funcionarios al abrir el modal
    cargarFuncionariosValidos();
    
    $('#modalViaticos').modal('show');
}

function openModalPresupuesto() {
    document.getElementById('formPresupuestoViaticos').reset();
    const anio = document.getElementById('selectAnio').value;
    cargarPresupuestoActual(anio);
    $('#modalPresupuestoViaticos').modal('show');
}

// Función para cargar funcionarios válidos
function cargarFuncionariosValidos() {
    // Mostrar indicador de carga en el select
    let select = document.getElementById('listFuncionarios');
    if (!select) return;
    
    select.innerHTML = '<option value="">Cargando funcionarios...</option>';
    select.disabled = true;

    fetch(base_url + '/FuncionariosViaticos/getFuncionariosValidos')
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al cargar funcionarios');
            }
            return response.json();
        })
        .then(data => {
            select.innerHTML = '<option value="">Seleccione un funcionario</option>';
            select.disabled = false;

            if (data && data.length > 0) {
                data.forEach(funcionario => {
                    let option = document.createElement('option');
                    option.value = funcionario.idefuncionario;
                    option.textContent = funcionario.nombre_completo;
                    option.dataset.tipo = funcionario.tipo_funcionario;
                    select.appendChild(option);
                });
                
                // Agregar evento para actualizar el tipo de funcionario al cambiar la selección
                select.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption && selectedOption.dataset.tipo) {
                        document.getElementById('tipo_funcionario').value = selectedOption.dataset.tipo;
                    }
                });
            } else {
                select.innerHTML = '<option value="">No hay funcionarios disponibles</option>';
            }
        })
        .catch(error => {
            console.error('Error al cargar funcionarios:', error);
            select.innerHTML = '<option value="">Error al cargar funcionarios</option>';
            select.disabled = false;
        });
}

// Función para cargar el presupuesto actual
function cargarPresupuestoActual(anio) {
    document.getElementById('txtCapitalTotal').value = '';
    
    if (!anio || isNaN(anio)) {
        console.error('Año inválido');
        return;
    }
    
    fetch(base_url + '/FuncionariosViaticos/getCapitalDisponible/' + anio)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data && data.capitalTotal !== undefined) {
                document.getElementById('txtCapitalTotal').value = data.capitalTotal;
            }
        })
        .catch(error => {
            console.error('Error al cargar presupuesto:', error);
        });
}

// Función para recargar los datos después de actualizar el presupuesto
function cargarCapitalDisponible(anio) {
    inicializarGraficos(anio);
    cargarHistoricoViaticos(anio);
    cargarDetalleViaticos(anio);
}

document.addEventListener('DOMContentLoaded', function() {
    // Verificar que jQuery esté disponible
    if (typeof jQuery === 'undefined') {
        console.error('jQuery no está cargado');
        return;
    }

    const anioActual = new Date().getFullYear();
    const anioElement = document.getElementById('anioActual');
    if (anioElement) {
        anioElement.textContent = anioActual;
    }
    
    // Inicializar tablas solo si existen los elementos
    if (!document.getElementById('tableHistoricoViaticos') || !document.getElementById('tableDetalleViaticos')) {
        console.error('No se encontraron las tablas');
        return;
    }
    
    // Inicializar tablas
    tableHistorico = new DataTable('#tableHistoricoViaticos', {
        language: {
            url: base_url + '/es.json'
        },
        searching: false,
        ordering: true,
        pageLength: 5
    });
    
    tableDetalle = new DataTable('#tableDetalleViaticos', {
        language: {
            url: base_url + '/es.json'
        },
        searching: true,
        ordering: true,
        pageLength: 10
    });

    // Cargar datos iniciales
    inicializarGraficos(anioActual);
    cargarHistoricoViaticos(anioActual);
    cargarDetalleViaticos(anioActual);

    // Evento para el botón de filtrar
    document.getElementById('btnFiltrar').addEventListener('click', function() {
        const anioSeleccionado = document.getElementById('selectAnio').value;
        inicializarGraficos(anioSeleccionado);
        cargarHistoricoViaticos(anioSeleccionado);
        cargarDetalleViaticos(anioSeleccionado);
    });

    // Evento para el botón de reporte anual
    document.getElementById('btnReporteAnual').addEventListener('click', function() {
        const anio = document.getElementById('selectAnio').value;
        window.location.href = base_url + '/FuncionariosViaticos/generarReporteAnual/' + anio;
    });
    
    // Evento para el formulario de presupuesto
    const formPresupuesto = document.getElementById('formPresupuestoViaticos');
    if (formPresupuesto) {
        formPresupuesto.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar datos
            const anio = document.getElementById('txtAnio').value;
            const capitalTotal = document.getElementById('txtCapitalTotal').value;
            
            if (!anio || isNaN(anio) || parseInt(anio) <= 0) {
                Swal.fire('Error', 'El año no es válido', 'error');
                return;
            }
            
            if (!capitalTotal || isNaN(capitalTotal) || parseFloat(capitalTotal) <= 0) {
                Swal.fire('Error', 'El capital total debe ser mayor que cero', 'error');
                return;
            }
            
            // Crear FormData
            let formData = new FormData(this);
            
            // Mostrar indicador de carga
            Swal.fire({
                title: 'Guardando...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Enviar datos
            fetch(base_url + '/FuncionariosViaticos/setPresupuestoAnual', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                Swal.close();
                if(data.status){
                    Swal.fire('Éxito', data.msg, 'success');
                    $('#modalPresupuestoViaticos').modal('hide');
                    // Recargar datos
                    const anioActual = document.getElementById('selectAnio').value;
                    cargarCapitalDisponible(anioActual);
                } else {
                    Swal.fire('Error', data.msg || 'Error desconocido', 'error');
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
            });
        });
    }
    
    // Evento para el formulario de viáticos
    const formViaticos = document.getElementById('formViaticos');
    if (formViaticos) {
        formViaticos.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar que se haya seleccionado un funcionario
            const funcionarioId = document.getElementById('listFuncionarios').value;
            if (!funcionarioId) {
                Swal.fire('Error', 'Debe seleccionar un funcionario', 'error');
                return false;
            }
            
            // Validar fechas
            const fechaSalida = new Date(document.getElementById('txtFechaSalida').value);
            const fechaRegreso = new Date(document.getElementById('txtFechaRegreso').value);
            const fechaActual = new Date();
            
            // Resetear horas, minutos, segundos y milisegundos para comparar solo fechas
            fechaSalida.setHours(0, 0, 0, 0);
            fechaRegreso.setHours(0, 0, 0, 0);
            fechaActual.setHours(0, 0, 0, 0);
            
            // Permitir fecha igual o posterior a la actual
            if (fechaSalida < fechaActual) {
                Swal.fire('Error', 'La fecha de salida no puede ser anterior a la fecha actual', 'error');
                return false;
            }
            
            // Validar que la fecha de regreso sea posterior a la fecha de salida
            if (fechaRegreso < fechaSalida) {
                Swal.fire('Error', 'La fecha de regreso debe ser posterior a la fecha de salida', 'error');
                return false;
            }
            
            // Validar monto
            const monto = parseFloat(document.getElementById('txtMonto').value);
            if (isNaN(monto) || monto <= 0) {
                Swal.fire('Error', 'El monto debe ser mayor que cero', 'error');
                return false;
            }
            
            // Crear FormData
            let formData = new FormData(this);
            
            // Mostrar indicador de carga
            Swal.fire({
                title: 'Guardando...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Enviar datos
            fetch(base_url + '/FuncionariosViaticos/setViatico', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                Swal.close();
                if(data.status){
                    Swal.fire('Éxito', data.msg, 'success');
                    $('#modalViaticos').modal('hide');
                    // Recargar datos
                    const anioActual = document.getElementById('selectAnio').value;
                    cargarCapitalDisponible(anioActual);
                } else {
                    Swal.fire('Error', data.msg || 'Error desconocido', 'error');
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
            });
        });
    }
});