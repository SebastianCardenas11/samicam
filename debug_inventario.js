// Script de diagnóstico para el módulo de inventario
console.log('=== DIAGNÓSTICO INVENTARIO ===');

// Verificar que jQuery esté cargado
if (typeof $ !== 'undefined') {
    console.log('✓ jQuery está cargado');
} else {
    console.error('✗ jQuery NO está cargado');
}

// Verificar que DataTables esté cargado
if (typeof $.fn.DataTable !== 'undefined') {
    console.log('✓ DataTables está cargado');
} else {
    console.error('✗ DataTables NO está cargado');
}

// Verificar que base_url esté definido
if (typeof base_url !== 'undefined') {
    console.log('✓ base_url está definido:', base_url);
} else {
    console.error('✗ base_url NO está definido');
}

// Verificar que las tablas existan en el DOM
const tablas = [
    'tablaImpresoras',
    'tablaEscaneres', 
    'tablaPapeleria',
    'tablaTintasToner',
    'tablaPcTorre',
    'tablaTodoEnUno',
    'tablaPortatiles',
    'tablaHerramientas'
];

tablas.forEach(tabla => {
    const elemento = document.getElementById(tabla);
    if (elemento) {
        console.log(`✓ Tabla ${tabla} existe en el DOM`);
    } else {
        console.error(`✗ Tabla ${tabla} NO existe en el DOM`);
    }
});

// Función para probar conexión AJAX
function probarConexion(endpoint) {
    console.log(`Probando conexión a: ${base_url}${endpoint}`);
    
    fetch(`${base_url}${endpoint}`)
        .then(response => {
            console.log(`Status: ${response.status}`);
            return response.text();
        })
        .then(data => {
            console.log(`Respuesta de ${endpoint}:`, data.substring(0, 200));
            try {
                const json = JSON.parse(data);
                console.log(`✓ JSON válido para ${endpoint}`);
            } catch (e) {
                console.error(`✗ JSON inválido para ${endpoint}:`, e);
            }
        })
        .catch(error => {
            console.error(`✗ Error en ${endpoint}:`, error);
        });
}

// Probar endpoints principales
if (typeof base_url !== 'undefined') {
    probarConexion('/Inventario/getImpresoras');
    probarConexion('/Inventario/getEscaneres');
    probarConexion('/Inventario/getPapeleria');
}

console.log('=== FIN DIAGNÓSTICO ===');