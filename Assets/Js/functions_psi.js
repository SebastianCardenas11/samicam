// functions_psi.js

let tblPrestamos, tblSalidas, tblIngresos;

document.addEventListener('DOMContentLoaded', function() {
    initPsiTables();
});

function initPsiTables() {
    tblPrestamos = $('#tablaPrestamos').DataTable({
        language: { url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json' },
        ajax: { url: base_url + '/psi/getPrestamos', dataSrc: '' },
        columns: [
            { data: 'id_prestamo' },
            { data: 'fecha' },
            { data: 'responsable' },
            { data: 'elemento' },
            { data: 'cantidad' },
            { data: 'estado' },
            { data: 'options' }
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

function openModalPsi(tipo) {
    // Aquí se puede cargar dinámicamente el formulario según el tipo (prestamo, salida, ingreso)
    $('#modalPsi').modal('show');
    // Lógica para cambiar el contenido del formulario según el tipo
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

// Aquí puedes agregar más funciones para otros submódulos y para manejar los formularios de ingreso, edición, etc. 