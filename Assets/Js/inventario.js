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