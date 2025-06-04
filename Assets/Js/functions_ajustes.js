document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('formAjustesPerfil');
    if(form){
        form.onsubmit = function(e){
            e.preventDefault();
            let formData = new FormData(form);
            fetch(base_url + '/ajustes/actualizarPerfil', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status){
                    Swal.fire('¡Éxito!', data.msg, 'success').then(()=>{
                        location.reload();
                    });
                    // Actualizar la imagen de perfil en la vista
                    if(form.foto.files.length > 0){
                        const reader = new FileReader();
                        reader.onload = function(e){
                            document.getElementById('imgPreview').src = e.target.result;
                        }
                        reader.readAsDataURL(form.foto.files[0]);
                    }
                }else{
                    Swal.fire('Error', data.msg, 'error');
                }
            })
            .catch(()=>{
                Swal.fire('Error', 'No se pudo actualizar el perfil.', 'error');
            });
        };
        // Vista previa de la imagen
        document.getElementById('foto').addEventListener('change', function(e){
            if(this.files && this.files[0]){
                const reader = new FileReader();
                reader.onload = function(e){
                    document.getElementById('imgPreview').src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
}); 