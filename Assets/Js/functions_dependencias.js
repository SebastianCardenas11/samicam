let tableDependencias;
document.addEventListener('DOMContentLoaded', function () {
    tableDependencias = $('#tableDependencias').DataTable({
        "ajax": {
            "url": base_url + "/dependencias/getDependencias",
            "dataSrc": ""
        },
        "columns": [
            { "data": "dependencia_pk", "className": "text-center" },
            { "data": "nombre", "className": "text-center" },
            { "data": "options", "className": "text-center", "orderable": false }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "responsive": true,
        "destroy": true,
        "pageLength": 10,
        "order": [[0, "desc"]]
    });

    // Evento para abrir modal de nuevo
    window.openModal = function () {
        document.querySelector('#idDependencia').value = "";
        document.querySelector('#txtNombreDependencia').value = "";
        document.querySelector('#titleModal').innerHTML = "Nueva S.D.O";
        document.querySelector('#btnText').innerHTML = "Guardar";
        $('#modalFormDependencias').modal('show');
    };

    // Guardar o actualizar dependencia
    document.querySelector('#formDependencias').onsubmit = function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        let id = document.querySelector('#idDependencia').value;
        let url = base_url + "/dependencias/setDependencia";
        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(function (objData) {
                if (objData.status) {
                    $('#modalFormDependencias').modal('hide');
                    tableDependencias.ajax.reload();
                    Swal.fire('Éxito', objData.msg, 'success');
                } else {
                    Swal.fire('Atención', objData.msg, 'error');
                }
            });
    };

    // Ver dependencia
    window.fntViewInfo = function (id) {
        fetch(base_url + "/dependencias/getDependencia/" + id)
            .then(res => res.json())
            .then(function (objData) {
                if (objData.status) {
                    document.querySelector('#celId').innerHTML = objData.data.dependencia_pk;
                    document.querySelector('#celNombre').innerHTML = objData.data.nombre;
                    $('#modalViewDependencias').modal('show');
                } else {
                    Swal.fire('Atención', objData.msg, 'error');
                }
            });
    };

    // Editar dependencia
    window.fntEditInfo = function (element, id) {
        fetch(base_url + "/dependencias/getDependencia/" + id)
            .then(res => res.json())
            .then(function (objData) {
                if (objData.status) {
                    document.querySelector('#idDependencia').value = objData.data.dependencia_pk;
                    document.querySelector('#txtNombreDependencia').value = objData.data.nombre;
                    document.querySelector('#titleModal').innerHTML = "Editar S.D.O";
                    document.querySelector('#btnText').innerHTML = "Actualizar";
                    $('#modalFormDependencias').modal('show');
                } else {
                    Swal.fire('Atención', objData.msg, 'error');
                }
            });
    };

    // Eliminar dependencia
    window.fntDelInfo = function (id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                let formData = new FormData();
                formData.append('idDependencia', id);
                fetch(base_url + "/dependencias/delDependencia", {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(function (objData) {
                        if (objData.status) {
                            tableDependencias.ajax.reload();
                            Swal.fire('Eliminado', objData.msg, 'success');
                        } else {
                            Swal.fire('Atención', objData.msg, 'error');
                        }
                    });
            }
        });
    };
}); 