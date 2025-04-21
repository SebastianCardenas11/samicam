document.addEventListener('DOMContentLoaded', function() {
    var divLoading = document.querySelector("#divLoading");

    if (document.querySelector("#loginForm")) {
        
        let loginForm = document.querySelector("#loginForm");

        loginForm.onsubmit = function(e) {
            e.preventDefault();

            let strIdentificacion = document.querySelector('#txtCorreo').value;
            let strPassword = document.querySelector('#txtPassword').value;
            console.log(strPassword);
            document.querySelector('#txtCorreo').classList.remove('is-invalid', 'animate-error');
            document.querySelector('#txtPassword').classList.remove('is-invalid', 'animate-error');

            let hasError = false;
            let errorMessage = "";

            if (strIdentificacion == "" && strPassword == "") {
                document.querySelector('#txtCorreo').classList.add('is-invalid', 'animate-error');
                document.querySelector('#txtPassword').classList.add('is-invalid', 'animate-error');
                errorMessage = "Escribe la identificación y la contraseña";
                hasError = true;
            } else if (strIdentificacion == "") {
                document.querySelector('#txtCorreo').classList.add('is-invalid', 'animate-error');
                errorMessage = "Escribe la identificación";
                hasError = true;
            } else if (strPassword == "") {
                document.querySelector('#txtPassword').classList.add('is-invalid', 'animate-error');
                errorMessage = "Escribe la contraseña";
                hasError = true;
            }

            if (hasError) {
               
                setTimeout(() => {
                    document.querySelector('#txtCorreo').classList.remove('animate-error');
                    document.querySelector('#txtPassword').classList.remove('animate-error');
                }, 400);

                return false;
            } else {
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url + '/Login/loginUser';
                var formData = new FormData(loginForm);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function() {
                    if (request.readyState != 4) return;
                    if (request.status == 200) {
                        console.log(this.responseText);
                        
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            window.location = base_url + '/dashboard';
                        } else {
                            document.querySelector('#txtPassword').classList.add('is-invalid', 'animate-error');
                            document.querySelector('#txtCorreo').classList.add('is-invalid', 'animate-error');
                            document.querySelector('#txtPassword').value = "";
                            setTimeout(() => {
                                document.querySelector('#txtCorreo').classList.remove('animate-error');
                                document.querySelector('#txtPassword').classList.remove('animate-error');
                            }, 400);
                        }
                    }
                    divLoading.style.display = "none";
                    return false;
                }
            }
        }
    }
}, false);
