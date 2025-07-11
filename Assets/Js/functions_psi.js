// functions_psi.js

let tblPrestamos, tblSalidas, tblIngresos;

function cargarFuncionariosPorTipo(tipo) {
    let url = tipo === 'planta'
        ? base_url + '/psi/getFuncionariosPlanta'
        : base_url + '/psi/getFuncionariosOps';
    fetch(url)
        .then(res => res.json())
        .then(data => {
            let select = document.getElementById('funcionario_responsable');
            select.innerHTML = '<option value="">Seleccione un funcionario</option>';
            data.forEach(f => {
                select.innerHTML += `<option value="${f.id || f.nombre_completo}" data-dependencia="${f.dependencia || ''}" data-cargo="${f.cargo || ''}">${f.nombre_completo}</option>`;
            });
        });
}

document.addEventListener('DOMContentLoaded', function() {
    initPsiTables();
    // Conectar el botón de nuevo préstamo
    const btnNuevoPrestamo = document.querySelector("#prestamos .btn-primary");
    if(btnNuevoPrestamo) {
        btnNuevoPrestamo.onclick = function() {
            const form = document.getElementById('formPsi');
            if(form) {
                form.reset();
                document.getElementById('id_prestamos').value = '';
                cargarFuncionariosPorTipo('planta');
                document.querySelector('input[name="tipo_funcionario"][value="planta"]').checked = true;
                $('#modalPsi').modal('show');
            } else {
                alert('No se encontró el formulario de préstamo en el DOM.');
            }
        };
    }
    // Evento para los radio buttons
    document.querySelectorAll('input[name="tipo_funcionario"]').forEach(radio => {
        radio.onchange = function() {
            cargarFuncionariosPorTipo(this.value);
        };
    });
    // Autocompletar dependencia y cargo al seleccionar funcionario
    document.getElementById('funcionario_responsable').onchange = function() {
        let selected = this.options[this.selectedIndex];
        document.getElementById('dependencia').value = selected.getAttribute('data-dependencia') || '';
        document.getElementById('cargo_funcionario').value = selected.getAttribute('data-cargo') || '';
    };
    // Conectar el submit del formulario
    document.getElementById('formPsi').onsubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        fetch(base_url + '/psi/setPrestamo', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            $('#modalPsi').modal('hide');
            tblPrestamos.ajax.reload();
        });
    };
});

function initPsiTables() {
    tblPrestamos = $('#tablaPrestamos').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json' },
        ajax: { url: base_url + '/psi/getPrestamos', dataSrc: '' },
        columns: [
            { data: 'dependencia' },
            { data: 'funcionario_responsable' },
            { data: 'cargo_funcionario' },
            { data: 'fecha_prestamo' },
            { data: 'fecha_devolucion' },
            { data: 'item' },
            { data: 'dispositivo' },
            { data: 'marca_modelo' },
            { data: 'activo' },
            { data: 'serial' },
            { data: 'estado' },
            { data: 'mac' },
            { data: 'observaciones' },
            { data: 'status' },
            { data: null, render: function(data, type, row) {
                return `
                  <button class='btn btn-sm btn-info me-1' onclick='openModalPsi("prestamo", ${row.id_prestamo})'>Editar</button>
                  <button class='btn btn-sm btn-danger me-1' onclick='eliminarPrestamoPsi(${row.id_prestamo})'>Eliminar</button>
                  <button class='btn btn-sm btn-secondary' onclick='hojaVidaPsi(${row.id_prestamo})'>Hoja de Vida</button>
                `;
            }}
        ],
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, 'desc']]
    });
    tblSalidas = $('#tablaSalidas').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json' },
        ajax: { url: base_url + '/psi/getSalidas', dataSrc: '' },
        columns: [
            { data: 'id_salida' },
            { data: 'fecha' },
            { data: 'responsable' },
            { data: 'elemento' },
            { data: 'cantidad' },
            { data: 'motivo' },
            { data: 'options' }
        ],
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, 'desc']]
    });
    tblIngresos = $('#tablaIngresos').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json' },
        ajax: { url: base_url + '/psi/getIngresos', dataSrc: '' },
        columns: [
            { data: 'id_ingreso' },
            { data: 'fecha' },
            { data: 'responsable' },
            { data: 'elemento' },
            { data: 'cantidad' },
            { data: 'origen' },
            { data: 'options' }
        ],
        responsive: true,
        bDestroy: true,
        iDisplayLength: 10,
        order: [[0, 'desc']]
    });
}

function openModalPsi(tipo, id = null) {
    if (tipo === 'prestamo') {
        document.getElementById('formPsi').reset();
        document.getElementById('id_prestamos').value = '';
        cargarFuncionariosPorTipo('planta');
        document.querySelector('input[name="tipo_funcionario"][value="planta"]').checked = true;
        if (id) {
            fetch(base_url + '/psi/getPrestamo/' + id)
                .then(res => res.json())
                .then(data => {
                    for (let key in data) {
                        if (document.getElementsByName(key)[0]) {
                            document.getElementsByName(key)[0].value = data[key];
                        }
                    }
                    if(document.getElementById('id_prestamos')){
                        document.getElementById('id_prestamos').value = data.id_prestamos;
                    }
                });
        }
        $('#modalPsi').modal('show');
    }
}

// Aquí irá la lógica para los gráficos con Chart.js

// inventario.js

document.addEventListener('DOMContentLoaded', function() {
    // Ejemplo: cargar impresoras por AJAX (ajusta la URL según tu backend)
    if (document.getElementById('tablaImpresoras')) {
        fetchImpresoras();
    }

    // El manejo del formulario ahora está en el modal
});

function fetchImpresoras() {
    fetch(base_url + '/Inventario/Impresoras/getImpresora')
        .then(response => response.json())
        .then(data => {
            let tbody = document.querySelector('#tablaImpresoras tbody');
            tbody.innerHTML = '';
            data.forEach(row => {
                tbody.innerHTML += `
                <tr>
                    <td>${row.numero_impresora || ''}</td>
                    <td>${row.marca || ''}</td>
                    <td>${row.modelo || ''}</td>
                    <td>${row.serial || ''}</td>
                    <td>${row.consumible || ''}</td>
                    <td>${row.estado || ''}</td>
                    <td>${row.disponibilidad || ''}</td>
                    <td>${row.id_dependencia || ''}</td>
                    <td>${row.oficina || ''}</td>
                    <td>${row.id_funcionario || ''}</td>
                    <td>${row.id_cargo || ''}</td>
                    <td>${row.id_contacto || ''}</td>
                    <td class='text-center'>
                        <!-- Aquí puedes agregar botones de editar/eliminar si lo deseas -->
                    </td>
                </tr>`;
            });
        });
}

function eliminarPrestamoPsi(id) {
    if (!confirm('¿Seguro que desea eliminar este préstamo?')) return;
    fetch(base_url + '/psi/delPrestamo', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + id
    })
    .then(res => res.json())
    .then(data => {
        tblPrestamos.ajax.reload();
    });
}

function hojaVidaPsi(id) {
    // Aquí irá la lógica para la hoja de vida del préstamo
    alert('Funcionalidad de Hoja de Vida próximamente. ID: ' + id);
}

// Aquí puedes agregar más funciones para otros submódulos y para manejar los formularios de ingreso, edición, etc. 