

// Función para registrar acceso al módulo en auditoría
function registrarAccesoModulo(modulo) {
  // Evita registrar si el módulo es nulo o vacío
  if (!modulo) {
    return;
  }
  let request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/auditoria/registrarAccesoJS";
  let formData = new FormData();
  formData.append("modulo", modulo);
  request.open("POST", ajaxUrl, true);
  request.send(formData);
}

// Mapeo de URLs a nombres de módulos para la auditoría
const moduleMap = {
  "/dashboard": "Dashboard",
  "/usuarios": "Usuarios",
  "/roles": "Roles",
  "/funcionariosops": "Funcionarios Ops",
  "/funcionariosplanta": "Funcionarios Planta",
  "/vacaciones": "Vacaciones",
  "/funcionariosviaticos": "Viáticos",
  "/archivos": "Archivos",
  "/categoriasarchivos": "Categorías de Archivos",
  "/practicantes": "Practicantes",
  "/tareas": "Tareas",
  "/publicaciones": "Publicaciones",
  "/dependencias": "Dependencias",
  "/seguimientoContrato": "Seguimiento de Contratos",
  "/inventario": "Inventario",
  "/whatsapp": "Registros WhatsApp",
  "/psi": "PSI",
  "/hojavidaequipos": "Hoja de Vida Equipos",
  "/cargos": "Cargos",
  "/ajustes": "Ajustes de Perfil",
  "/auditoria": "Auditoría",
  "/motivopermiso": "Motivos de Permiso",
  "/permisos": "Permisos",
  "/peticiones": "Peticiones"
};

// Función para obtener el nombre del módulo desde la URL
function getModuleFromUrl(url) {
  for (const path in moduleMap) {
    if (url.includes(path)) {
      return moduleMap[path];
    }
  }
  return null; // Retorna null si no hay coincidencia
}

// Detectar la página actual y registrar el acceso correspondiente
document.addEventListener("DOMContentLoaded", function () {
  // 1. Registrar acceso en la carga inicial de la página
  const currentUrl = window.location.href;
  const initialModule = getModuleFromUrl(currentUrl);
  if (initialModule) {
    registrarAccesoModulo(initialModule);
  }

  // 2. Registrar acceso cuando se hace clic en enlaces de navegación
  // Se asume que los enlaces de navegación del módulo están dentro del contenedor principal de navegación
  const navContainer = document.getElementById("sidenav-main");
  if (navContainer) {
    navContainer.addEventListener("click", function (e) {
      // Asegurarse de que el clic fue en un enlace (<a>)
      const link = e.target.closest("a");
      if (link && link.href) {
        const href = link.getAttribute("href");
        const clickedModule = getModuleFromUrl(href);
        if (clickedModule) {
          registrarAccesoModulo(clickedModule);
        }
      }
    });
  }
});
