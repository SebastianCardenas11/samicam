// API de Colombia - Departamentos y Ciudades
class ColombiaAPI {
    constructor() {
        this.baseURL = 'https://api-colombia.com/api/v1';
    }

    async getDepartamentos() {
        try {
            const response = await fetch(`${this.baseURL}/Department`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error al obtener departamentos:', error);
            return [];
        }
    }

    async getCiudadesByDepartamento(departamentoId) {
        try {
            const response = await fetch(`${this.baseURL}/Department/${departamentoId}/cities`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error al obtener ciudades:', error);
            return [];
        }
    }
}

// Inicializar API
const colombiaAPI = new ColombiaAPI();

// Función para cargar departamentos en un select
async function cargarDepartamentos(selectId) {
    const select = document.getElementById(selectId);
    if (!select) return;

    try {
        const departamentos = await colombiaAPI.getDepartamentos();
        select.innerHTML = '<option value="">Selecciona un departamento</option>';
        
        departamentos.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.id;
            option.textContent = dept.name;
            option.dataset.name = dept.name;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Error cargando departamentos:', error);
    }
}

// Función para cargar ciudades basado en departamento seleccionado
async function cargarCiudades(departamentoId, selectCiudadId) {
    const selectCiudad = document.getElementById(selectCiudadId);
    if (!selectCiudad || !departamentoId) return;

    try {
        const ciudades = await colombiaAPI.getCiudadesByDepartamento(departamentoId);
        selectCiudad.innerHTML = '<option value="">Selecciona una ciudad</option>';
        
        ciudades.forEach(ciudad => {
            const option = document.createElement('option');
            option.value = ciudad.id;
            option.textContent = ciudad.name;
            option.dataset.name = ciudad.name;
            selectCiudad.appendChild(option);
        });
        
        selectCiudad.disabled = false;
    } catch (error) {
        console.error('Error cargando ciudades:', error);
    }
}

// Función para obtener el texto completo (departamento, ciudad)
function obtenerUbicacionCompleta(selectDeptId, selectCiudadId) {
    const selectDept = document.getElementById(selectDeptId);
    const selectCiudad = document.getElementById(selectCiudadId);
    
    if (!selectDept.value || !selectCiudad.value) return '';
    
    const departamento = selectDept.options[selectDept.selectedIndex].dataset.name;
    const ciudad = selectCiudad.options[selectCiudad.selectedIndex].dataset.name;
    
    return `${departamento}, ${ciudad}`;
}