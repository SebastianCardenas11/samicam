// inventario.js

document.addEventListener('DOMContentLoaded', function() {
    // Ejemplo: cargar impresoras por AJAX (ajusta la URL según tu backend)
    if (document.getElementById('tablaImpresoras')) {
        fetchImpresoras();
    }
});

function fetchImpresoras() {
    fetch('/Inventario/Impresoras/listar')
        .then(response => response.json())
        .then(data => {
            let tbody = document.querySelector('#tablaImpresoras tbody');
            tbody.innerHTML = '';
            data.forEach(row => {
                tbody.innerHTML += `
                <tr>
                    <td>${row.marca}</td>
                    <td>${row.modelo}</td>
                    <td>${row.serial}</td>
                    <td>${row.consumible}</td>
                    <td>${row.estado}</td>
                    <td>${row.disponibilidad}</td>
                    <td>${row.id_dependencia}</td>
                    <td>${row.oficina}</td>
                    <td>${row.id_funcionario}</td>
                    <td>${row.id_cargo}</td>
                    <td>${row.id_contacto}</td>
                    <td><button class='btn btn-sm btn-warning'>Editar</button></td>
                </tr>`;
            });
        });
}

// Aquí puedes agregar más funciones para otros submódulos y para manejar los formularios de ingreso, edición, etc. 