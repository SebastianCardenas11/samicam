$('.login-content [data-toggle="flip"]').click(function() {
	$('.login-box').toggleClass('flipped');
	return false;
});

var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
	if(document.querySelector("#formLogin")){
		let formLogin = document.querySelector("#formLogin");
		formLogin.onsubmit = function(e) {
			e.preventDefault();

			let strIdentificacion = document.querySelector('#txtIdentificacion').value;
			let strPassword = document.querySelector('#txtPassword').value;

			if(strIdentificacion == "" && strPassword == "")
			{
				Swal.fire.fire({   title: "Por favor",   text: "Digite su identificación y contraseña",  imageUrl: "Assets/images/iconos/login.png" });
				return false;
			}
			if(strIdentificacion == "")
				{
					Swal.fire({   title: "Por favor",   text: "Digite su identificación",  imageUrl: "Assets/images/iconos/usuario.png" });
					return false;
				}
			else if(strPassword == "")
				{
					Swal.fire({   title: "Por favor",   text: "Digite su contraseña",    imageUrl: "Assets/images/iconos/password.png" });
					return false;
				}
			else{
				var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				var ajaxUrl = base_url+'/Login/loginUser'; 
				var formData = new FormData(formLogin);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState != 4) return;
					if(request.status == 200){
						var objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							window.location = base_url+'/dashboard';
							// Swal.fire("Bien", objData.msg, "success");
							// window.location.reload(false);
						}else{
							Swal.fire("Atención", objData.msg, "error");
							// Swal.fire({   title: "Por favor",   text: "Digite tu identificación",  imageUrl: "Assets/images/iconos/usuario.png" });
							document.querySelector('#txtPassword').value = "";
						}
					}else{
						Swal.fire("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
					return false;
				}
			}
		}
	}


}, false);