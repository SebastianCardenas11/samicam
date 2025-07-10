// Declaraciones globales (solo una vez al inicio)
let tableHistorico;
let tableDetalle;
let chartCapital;
let chartComparativa;
let chartTopFuncionarios, chartViaticosMes, chartCapitalMes, chartCiudadesFrecuentes;
let chartPolarArea = null;
let listaDepartamentos = [];

// --- Carga dinámica de departamentos y ciudades/municipios de Colombia (nueva API) ---
function cargarDepartamentosColombia() {
    const selectDepartamento = document.getElementById('selectDepartamento');
    selectDepartamento.innerHTML = '<option value="">Cargando departamentos...</option>';
    fetch('https://api-colombia.com/api/v1/Department')
        .then(response => response.json())
        .then(data => {
            listaDepartamentos = data; // Guardar la lista globalmente
            selectDepartamento.innerHTML = '<option value="">Seleccione un departamento</option>';
            data.forEach(dep => {
                const option = document.createElement('option');
                option.value = dep.id;
                option.textContent = dep.name;
                selectDepartamento.appendChild(option);
            });
        })
        .catch(() => {
            selectDepartamento.innerHTML = '<option value="">Error al cargar departamentos</option>';
        });
}

function obtenerNombreDepartamento(id) {
    if (!listaDepartamentos || listaDepartamentos.length === 0) return 'Desconocido';
    // Convertir ambos a string y quitar ceros a la izquierda para comparar
    const idStr = String(id).replace(/^0+/, '');
    const dep = listaDepartamentos.find(d => String(d.id).replace(/^0+/, '') === idStr);
    return dep ? dep.name : 'Desconocido';
}

function cargarCiudadesColombia(departamentoId) {
    const selectCiudad = document.getElementById('selectCiudad');
    selectCiudad.innerHTML = '<option value="">Cargando ciudades...</option>';
    if (!departamentoId) {
        selectCiudad.innerHTML = '<option value="">Seleccione un departamento primero</option>';
        return;
    }
    fetch('https://api-colombia.com/api/v1/Department/' + encodeURIComponent(departamentoId) + '/cities')
        .then(response => response.json())
        .then(data => {
            selectCiudad.innerHTML = '<option value="">Seleccione una ciudad o municipio</option>';
            data.forEach(mun => {
                const option = document.createElement('option');
                option.value = mun.name;
                option.textContent = mun.name;
                selectCiudad.appendChild(option);
            });
        })
        .catch(() => {
            selectCiudad.innerHTML = '<option value="">Error al cargar ciudades</option>';
        });
}

// Al abrir el modal, cargar departamentos y limpiar ciudades
function openModalViatico() {
    document.getElementById('formViaticos').reset();
    const hoy = new Date();
    document.getElementById('txtFechaAprobacion').valueAsDate = hoy;
    document.getElementById('txtFechaSalida').valueAsDate = hoy;
    document.getElementById('txtFechaRegreso').valueAsDate = hoy;
    cargarFuncionariosValidos();
    cargarDepartamentosColombia();
    const selectCiudad = document.getElementById('selectCiudad');
    selectCiudad.innerHTML = '<option value="">Seleccione un departamento primero</option>';
    // Reasignar el evento cada vez que se abre el modal
    const selectDepartamento = document.getElementById('selectDepartamento');
    const inputDeptoNombre = document.getElementById('lugar_comision_departamento_nombre');
    selectDepartamento.onchange = function() {
        const depId = this.value;
        // Guardar el nombre del departamento seleccionado
        if (inputDeptoNombre) {
            const selectedOption = this.options[this.selectedIndex];
            inputDeptoNombre.value = selectedOption ? selectedOption.text : '';
        }
        if (!depId) {
            selectCiudad.innerHTML = '<option value="">Seleccione un departamento primero</option>';
            return;
        }
        cargarCiudadesColombia(depId);
    };
    $('#modalViaticos').modal('show');
}

function openModalPresupuesto() {
    document.getElementById('formPresupuestoViaticos').reset();
    const anio = document.getElementById('txtAnio').value;
    cargarPresupuestoActual(anio);
    $('#modalPresupuestoViaticos').modal('show');
}

function cargarFuncionariosValidos() {
    const selectFuncionarios = document.getElementById('listFuncionarios');
    selectFuncionarios.innerHTML = '<option value="">Seleccione un funcionario</option>';
    
    fetch(base_url + '/FuncionariosViaticos/getFuncionariosValidos')
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)) {
                data.forEach(funcionario => {
                    const option = document.createElement('option');
                    option.value = funcionario.idefuncionario;
                    option.textContent = funcionario.nombre_completo;
                    option.dataset.tipo = funcionario.tipo_cont;
                    selectFuncionarios.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error al cargar funcionarios:', error);
            Swal.fire('Error', 'No se pudieron cargar los funcionarios', 'error');
        });

    // Evento para autollenar cargo y dependencia
    selectFuncionarios.onchange = function() {
        const idFuncionario = this.value;
        if (!idFuncionario) {
            document.getElementById('txtCargo').value = '';
            document.getElementById('txtDependencia').value = '';
            return;
        }
        fetch(base_url + '/FuncionariosPlanta/getFuncionario/' + idFuncionario)
            .then(response => response.json())
            .then(data => {
                if (data.status && data.data) {
                    document.getElementById('txtCargo').value = data.data.cargo_nombre || '';
                    document.getElementById('txtDependencia').value = data.data.dependencia_nombre || '';
                } else {
                    document.getElementById('txtCargo').value = '';
                    document.getElementById('txtDependencia').value = '';
                }
            })
            .catch(() => {
                document.getElementById('txtCargo').value = '';
                document.getElementById('txtDependencia').value = '';
            });
    };
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

// ========== NUEVOS GRÁFICOS ========== //
function cargarGraficosAvanzados(anio) {
  // Top funcionarios (por cantidad y valor total)
  fetch(`${base_url}/FuncionariosViaticos/getHistoricoViaticos/${anio}`)
    .then(res => res.json())
    .then(data => {
      let top = Array.isArray(data) ? data.sort((a,b)=>b.total_viaticos_asignados-b.total_viaticos_asignados).slice(0,10) : [];
      let labels = top.map(x=>x.nombre_completo);
      let valuesCantidad = top.map(x=>parseInt(x.total_viaticos_asignados));
      let valuesValor = top.map(x=>parseFloat(x.total_valor_viaticos));
      const ctx = document.getElementById('barTopFuncionarios').getContext('2d');
      if(chartTopFuncionarios) chartTopFuncionarios.destroy();
      chartTopFuncionarios = new Chart(ctx, {
        type: 'bar',
        data: {
          labels,
          datasets: [
            {
              label: 'Cantidad de Viáticos',
              data: valuesCantidad,
              backgroundColor: 'rgba(37,99,235,0.3)',
              borderColor: '#2563eb',
              borderWidth: 1
            },
            {
              label: 'Valor Total de Viáticos',
              data: valuesValor,
              backgroundColor: 'rgba(34,197,94,0.3)',
              borderColor: '#22c55e',
              borderWidth: 1,
              yAxisID: 'y1'
            }
          ]
        },
        options: {
          responsive:true,
          plugins:{
            legend:{position:'top'},
            tooltip: {
              enabled: true,
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  let value = context.parsed.y !== undefined ? context.parsed.y : context.parsed;
                  if(label.includes('Valor Total')) {
                    return `${label}: $${value.toLocaleString('es-CO')}`;
                  }
                  return `${label}: ${value}`;
                }
              }
            }
          },
          scales:{
            x:{ticks:{autoSkip:false, maxRotation:45, minRotation:30}},
            y:{beginAtZero:true, title:{display:true, text:'Cantidad'}},
            y1:{
              beginAtZero:true,
              position:'right',
              grid:{drawOnChartArea:false},
              title:{display:true, text:'Valor Total ($)'}
            }
          }
        }
      });
    });
  // Viáticos por mes
  fetch(`${base_url}/FuncionariosViaticos/getViaticosPorMes/${anio}`)
    .then(res => res.json())
    .then(data => {
      let meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
      let labels = meses;
      let values = Array(12).fill(0);
      if(Array.isArray(data)) data.forEach(x=>{ values[(x.mes-1)] = parseFloat(x.total); });
      // Llenar la mini tabla de meses destacados
      let topMeses = values.map((valor, i) => ({ mes: meses[i], valor })).sort((a,b)=>b.valor-a.valor).slice(0,3);
      const tbody = document.getElementById('tbodyMesesDestacados');
      if (tbody) {
        tbody.innerHTML = '';
        topMeses.forEach(m => {
          const tr = document.createElement('tr');
          tr.innerHTML = `<td>${m.mes}</td><td>$${m.valor.toLocaleString('es-CO')}</td>`;
          tbody.appendChild(tr);
        });
      }
      const ctx = document.getElementById('barViaticosMes').getContext('2d');
      if(chartViaticosMes) chartViaticosMes.destroy();
      chartViaticosMes = new Chart(ctx, {
        type: 'bar',
        data: {
          labels,
          datasets: [
            {
              label: 'Viáticos Entregados',
              data: values,
              backgroundColor: 'rgba(22,163,74,0.3)',
              borderColor: '#16a34a',
              borderWidth: 1
            },
            {
              label: 'Línea',
              data: values,
              type: 'line',
              borderColor: '#16a34a',
              backgroundColor: 'rgba(22,163,74,0.1)',
              fill: false,
              tension: 0.3,
              pointRadius: 4,
              pointBackgroundColor: '#16a34a',
              order: 0
            }
          ]
        },
        options: {
          responsive:true,
          plugins:{
            legend:{position:'top'},
            tooltip: {
              enabled: true,
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  let value = context.parsed.y !== undefined ? context.parsed.y : context.parsed;
                  return `${label}: ${value}`;
                }
              }
            }
          },
          scales:{
            x:{ticks:{autoSkip:false, maxRotation:45, minRotation:30}},
            y:{beginAtZero:true}
          }
        }
      });
    });
  // Capital por mes (área apilada)
  fetch(`${base_url}/FuncionariosViaticos/getCapitalPorMes/${anio}`)
    .then(res => res.json())
    .then(data => {
      let meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
      let total = parseFloat(data.capital_total||0);
      let disponible = parseFloat(data.capital_disponible||0);
      let usados = total-disponible;
      let arrDisponible = Array(12).fill(disponible);
      let arrUsados = Array(12).fill(usados);
      const ctx = document.getElementById('lineCapitalMes').getContext('2d');
      if(chartCapitalMes) chartCapitalMes.destroy();
      chartCapitalMes = new Chart(ctx, {
        type: 'line',
        data: {
          labels: meses,
          datasets: [
            {
              label: 'Capital Usado',
              data: arrUsados,
              backgroundColor: 'rgba(239,68,68,0.3)',
              borderColor: '#ef4444',
              fill: true,
              stack: 'Stack 0',
              tension: 0.3
            },
            {
              label: 'Capital Disponible',
              data: arrDisponible,
              backgroundColor: 'rgba(34,197,94,0.3)',
              borderColor: '#22c55e',
              fill: true,
              stack: 'Stack 0',
              tension: 0.3
            }
          ]
        },
        options: {
          responsive:true,
          plugins:{
            legend:{position:'top'},
            tooltip: {
              enabled: true,
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  let value = context.parsed.y !== undefined ? context.parsed.y : context.parsed;
                  return `${label}: $${value.toLocaleString('es-CO')}`;
                }
              }
            }
          },
          scales:{
            x:{ticks:{autoSkip:false, maxRotation:45, minRotation:30}},
            y:{beginAtZero:true, title:{display:true, text:'Valor ($)'}}
          }
        }
      });
    });
  // Ciudades más frecuentes
  fetch(`${base_url}/FuncionariosViaticos/getTopCiudadesComision/${anio}`)
    .then(res => res.json())
    .then(data => {
      let labels = Array.isArray(data) ? data.map(x=>x.lugar_comision_ciudad) : [];
      let values = Array.isArray(data) ? data.map(x=>parseInt(x.frecuencia)) : [];
      const ctx = document.getElementById('barCiudadesFrecuentes').getContext('2d');
      if(chartCiudadesFrecuentes) chartCiudadesFrecuentes.destroy();
      if(labels.length === 0) {
        ctx.clearRect(0,0,ctx.canvas.width,ctx.canvas.height);
        ctx.font = '18px sans-serif';
        ctx.fillStyle = '#888';
        ctx.textAlign = 'center';
        ctx.fillText('No hay datos para mostrar', ctx.canvas.width/2, ctx.canvas.height/2);
        return;
      }
      chartCiudadesFrecuentes = new Chart(ctx, {
        type: 'bar',
        data: { labels, datasets: [{ label: 'Frecuencia', data: values, backgroundColor: 'rgba(234,179,8,0.3)', borderColor:'#eab308', borderWidth:1 }] },
        options: {
          responsive:true,
          plugins:{
            legend:{display:false},
            tooltip: {
              enabled: true,
              callbacks: {
                label: function(context) {
                  let label = context.dataset.label || '';
                  let value = context.parsed.y !== undefined ? context.parsed.y : context.parsed;
                  return `${label}: ${value}`;
                }
              }
            }
          },
          scales:{ y:{beginAtZero:true} }
        }
      });
    });
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
    const btnFiltrar = document.getElementById('btnFiltrar');
    if (btnFiltrar) {
        btnFiltrar.addEventListener('click', function() {
            const anioSeleccionado = document.getElementById('selectAnio').value;
            inicializarGraficos(anioSeleccionado);
            cargarHistoricoViaticos(anioSeleccionado);
            cargarDetalleViaticos(anioSeleccionado);
        });
    } else {
        console.warn('No se encontró el botón btnFiltrar');
    }

    // Evento para el botón de reporte anual
    const btnReporteAnual = document.getElementById('btnReporteAnual');
    if (btnReporteAnual) {
        btnReporteAnual.addEventListener('click', function() {
            const anio = document.getElementById('selectAnio').value;
            window.location.href = base_url + '/FuncionariosViaticos/generarReporteAnual/' + anio;
        });
    } else {
        console.warn('No se encontró el botón btnReporteAnual');
    }
    
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
                    inicializarGraficos(anioActual);
                    cargarHistoricoViaticos(anioActual);
                    cargarDetalleViaticos(anioActual);
                    // Actualizar gráfico Polar Area si existe
                    const anioPolar = document.getElementById('selectAnioPolar');
                    if (anioPolar) {
                        cargarPolarAreaCapital(anioPolar.value);
                    }
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
    } else {
        console.warn('No se encontró el formulario formPresupuestoViaticos');
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
                Swal.fire({
                    icon: 'error',
                    title: 'Fecha no válida',
                    text: 'La fecha de salida no puede ser anterior a la fecha actual',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }
            
            if (fechaRegreso < fechaSalida) {
                Swal.fire('Error', 'La fecha de regreso debe ser posterior a la fecha de salida', 'error');
                return false;
            }
            
            guardarViatico(this);
        });
        
        // Validar fecha de salida al cambiar
        const txtFechaSalida = document.getElementById('txtFechaSalida');
        if (txtFechaSalida) {
            txtFechaSalida.addEventListener('change', function() {
                const fechaSalida = new Date(this.value);
                const fechaActual = new Date();
                fechaActual.setHours(0, 0, 0, 0);
                fechaSalida.setHours(0, 0, 0, 0);
                
                // Permitir fecha igual o posterior a la actual
                if (fechaSalida < fechaActual) {
                    Swal.fire('Error', 'La fecha de salida no puede ser anterior a la fecha actual', 'error');
                    this.valueAsDate = fechaActual;
                }
                
                // Actualizar fecha de regreso mínima
                const txtFechaRegreso = document.getElementById('txtFechaRegreso');
                if (txtFechaRegreso) {
                    txtFechaRegreso.min = this.value;
                }
            });
        } else {
            console.warn('No se encontró el input txtFechaSalida');
        }
    } else {
        console.warn('No se encontró el formulario formViaticos');
    }

    // Cargar gráficos avanzados al cargar y al cambiar año
    const anioPolar = document.getElementById('selectAnioPolar');
    if(anioPolar) {
      cargarGraficosAvanzados(anioPolar.value);
      document.getElementById('btnFiltrarPolar').addEventListener('click', function() {
        cargarGraficosAvanzados(anioPolar.value);
      });
    }
});

function inicializarGraficos(anio) {
    fetch(base_url + '/FuncionariosViaticos/getDetalleViaticos/' + anio)
        .then(response => response.json())
        .then(detalle => {
            // Sumar solo total_liquidado de todos los viáticos activos
            let totalUsado = 0;
            let totalEntregados = 0;
            if (Array.isArray(detalle)) {
                totalUsado = detalle.reduce((acc, item) => acc + (parseFloat(item.total_liquidado) || 0), 0);
                totalEntregados = detalle.length;
            }
            // Obtener el capital total desde el backend
            fetch(base_url + '/FuncionariosViaticos/getCapitalDisponible/' + anio)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }
                    const capitalTotal = parseFloat(data.capitalTotal) || 0;
                    // Calcular viáticos disponibles en el frontend
                    const viaticosDisponibles = capitalTotal - totalUsado;
                    // Mostrar el total de viáticos
                    const cardTotal = document.getElementById('cardTotalViaticos');
                    if (cardTotal) cardTotal.textContent = '$ ' + capitalTotal.toLocaleString();
                    // Mostrar el capital disponible calculado
                    const cardDisponibles = document.getElementById('cardViaticosDisponibles');
                    if (cardDisponibles) cardDisponibles.textContent = '$ ' + viaticosDisponibles.toLocaleString();
                    // Mostrar viáticos usados
                    const cardUsados = document.getElementById('cardViaticosUsados');
                    if (cardUsados) cardUsados.textContent = '$ ' + totalUsado.toLocaleString();
                    // Mostrar viáticos entregados en el año
                    const cardEntregados = document.getElementById('cardViaticosEntregados');
                    if (cardEntregados) cardEntregados.textContent = totalEntregados;
                });
        })
        .catch(error => console.error('Error:', error));
}

function cargarHistoricoViaticos(anio) {
    fetch(base_url + '/FuncionariosViaticos/getHistoricoViaticos/' + anio)
        .then(response => response.json())
        .then(data => {
            tableHistorico.clear();
            if (Array.isArray(data)) {
                data.forEach(item => {
                    tableHistorico.row.add([
                        item.nombre_completo,
                        item.total_viaticos_asignados || 0,
                        '$ ' + (parseFloat(item.total_valor_viaticos) || 0).toLocaleString()
                    ]);
                });
            }
            tableHistorico.draw();
        })
        .catch(error => console.error('Error:', error));
}

function formatPrecio(valor) {
    return '$ ' + (parseFloat(valor) || 0).toLocaleString('es-CO');
}

function cargarDetalleViaticos(anio) {
    // Esperar a que la lista de departamentos esté cargada
    if (!listaDepartamentos || listaDepartamentos.length === 0) {
        cargarDepartamentosColombia();
        setTimeout(() => cargarDetalleViaticos(anio), 500);
        return;
    }
    fetch(base_url + '/FuncionariosViaticos/getDetalleViaticos/' + anio)
        .then(response => response.json())
        .then(data => {
            tableDetalle.clear();
            if (Array.isArray(data)) {
                data.forEach(item => {
                    const acciones = `
                        <div class="btn-group" role="group">
                            <a href="${base_url}/FuncionariosViaticos/generarReporteViatico/${item.idViatico}" 
                               class="btn btn-primary btn-sm" title="Generar Reporte">
                                <i class="bi bi-file-pdf"></i>
                            </a>
                            <button class="btn btn-danger btn-sm" onclick="eliminarViatico(${item.idViatico})" 
                                    title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>`;
                    tableDetalle.row.add([
                        item.nombre_completo,
                        item.cargo,
                        item.dependencia,
                        item.motivo_gasto,
                        obtenerNombreDepartamento(item.lugar_comision_departamento), // Mostrar nombre
                        item.lugar_comision_ciudad,
                        item.finalidad_comision,
                        item.descripcion,
                        item.fecha_aprobacion ? item.fecha_aprobacion.split(' ')[0] : '',
                        item.fecha_salida ? item.fecha_salida.split(' ')[0] : '',
                        item.fecha_regreso ? item.fecha_regreso.split(' ')[0] : '',
                        item.n_dias,
                        formatPrecio(item.valor_dia),
                        formatPrecio(item.valor_viatico),
                        item.tipo_transporte,
                        formatPrecio(item.valor_transporte),
                        formatPrecio(item.total_liquidado),
                        acciones
                    ]);
                });
            }
            tableDetalle.draw();
        })
        .catch(error => console.error('Error:', error));
}

function eliminarViatico(idViatico) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('idViatico', idViatico);
            // Mostrar spinner de carga
            Swal.fire({
                title: 'Eliminando...',
                text: 'Actualizando datos',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            fetch(base_url + '/FuncionariosViaticos/deleteViatico', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();
                if (data.status) {
                    Swal.fire('Eliminado', data.msg, 'success');
                    const anioActual = document.getElementById('selectAnio').value;
                    inicializarGraficos(anioActual);
                    cargarHistoricoViaticos(anioActual);
                    cargarDetalleViaticos(anioActual);
                } else {
                    Swal.fire('Error', data.msg, 'error');
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar el viático', 'error');
            });
        }
    });
}

function guardarViatico(formElement) {
    // (Revertido) Ya no se cambia el value del select de departamento
    // Mostrar indicador de carga
    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    let formData = new FormData(formElement);
    fetch(base_url + '/FuncionariosViaticos/setViatico', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        if (data.status) {
            Swal.fire('Éxito', data.msg, 'success');
            $('#modalViaticos').modal('hide');
            formElement.reset();
            
            // Inicializar fechas con la fecha actual
            const hoy = new Date();
            document.getElementById('txtFechaAprobacion').valueAsDate = hoy;
            document.getElementById('txtFechaSalida').valueAsDate = hoy;
            document.getElementById('txtFechaRegreso').valueAsDate = hoy;
            
            // Recargar datos
            const anioActual = document.getElementById('selectAnio').value || new Date().getFullYear();
            inicializarGraficos(anioActual);
            cargarHistoricoViaticos(anioActual);
            cargarDetalleViaticos(anioActual);
        } else {
            Swal.fire('Error', data.msg || 'Error al asignar viático', 'error');
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al procesar la solicitud', 'error');
    });
    
    return false; // Evitar que el formulario se envíe de forma tradicional
}

function cargarPolarAreaCapital(anio) {
    // Obtener datos del backend
    fetch(base_url + '/FuncionariosViaticos/getCapitalDisponible/' + anio)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }
            const capitalTotal = parseFloat(data.capitalTotal) || 0;
            const capitalDisponible = parseFloat(data.capitalDisponible) || 0;
            const capitalUsado = capitalTotal - capitalDisponible;
            const ctx = document.getElementById('polarAreaCapital');
            if (!ctx) return;
            // Fijar tamaño del canvas
            ctx.width = 320;
            ctx.height = 320;
            if (chartPolarArea) chartPolarArea.destroy();
            chartPolarArea = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: ['Total', 'Usado', 'Disponible'],
                    datasets: [{
                        data: [capitalTotal, capitalUsado, capitalDisponible],
                        backgroundColor: [
                            'rgba(59,130,246,0.3)', // Total (azul)
                            'rgba(239,68,68,0.3)',  // Usado (rojo)
                            'rgba(34,197,94,0.3)'   // Disponible (verde)
                        ],
                        borderColor: [
                            '#3b82f6',
                            '#ef4444',
                            '#22c55e'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed && typeof context.parsed === 'object' && 'r' in context.parsed
                                        ? context.parsed.r
                                        : (typeof context.parsed === 'number' ? context.parsed : 0);
                                    return `${label}: $${Number(value).toLocaleString('es-CO')}`;
                                }
                            }
                        }
                    },
                    scales: {}
                }
            });
        })
        .catch(error => {
            console.error('Error al cargar datos para el gráfico Polar Area:', error);
        });
}