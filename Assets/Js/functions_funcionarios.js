function openModalImportar() {
    document.getElementById("formImportar").reset();
    $('#modalImportar').modal('show');
}

function importarFuncionarios() {
    let formImportar = document.getElementById("formImportar");
    let formData = new FormData(formImportar);

    if(!document.getElementById("archivo_excel").files[0]) {
        swal("Error", "Por favor seleccione un archivo", "error");
        return false;
    }

    let btnImportar = document.querySelector("#modalImportar .modal-footer .btn-primary");
    btnImportar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Importando...';
    btnImportar.disabled = true;

    fetch(base_url + '/importarFuncionarios/importar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status) {
            $('#modalImportar').modal('hide');
            formImportar.reset();
            swal("Éxito", data.msg, "success");
            tableUsuarios.ajax.reload();
        } else {
            let errorMsg = data.msg;
            if(data.errores) {
                errorMsg += '\n\nErrores encontrados:\n';
                data.errores.forEach(error => {
                    errorMsg += '- ' + error + '\n';
                });
            }
            swal("Error", errorMsg, "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        swal("Error", "Ocurrió un error al procesar la solicitud", "error");
    })
    .finally(() => {
        btnImportar.innerHTML = '<i class="bi bi-upload"></i> Importar';
        btnImportar.disabled = false;
    });
} 