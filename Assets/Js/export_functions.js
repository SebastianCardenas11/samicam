// Funciones de exportación para inventario

function exportarPDF(tablaId) {
    // Obtener la tabla
    const tabla = document.getElementById(tablaId);
    if (!tabla) {
        Swal.fire('Error', 'No se encontró la tabla para exportar', 'error');
        return;
    }

    // Crear ventana de impresión
    const ventana = window.open('', '_blank');
    ventana.document.write(`
        <html>
        <head>
            <title>Reporte de Inventario</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 20px; }
                table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; font-weight: bold; }
                .badge { padding: 2px 6px; border-radius: 3px; color: white; }
                .bg-success { background-color: #28a745; }
                .bg-warning { background-color: #ffc107; color: black; }
                .bg-danger { background-color: #dc3545; }
                .bg-dark { background-color: #343a40; }
                .btn-group { display: none; }
            </style>
        </head>
        <body>
            <h2>Reporte de Inventario - ${new Date().toLocaleDateString()}</h2>
            ${tabla.outerHTML}
            <script>
                window.onload = function() {
                    window.print();
                    window.close();
                }
            </script>
        </body>
        </html>
    `);
    ventana.document.close();
}

function exportarExcel(tablaId) {
    // Obtener la tabla
    const tabla = document.getElementById(tablaId);
    if (!tabla) {
        Swal.fire('Error', 'No se encontró la tabla para exportar', 'error');
        return;
    }

    // Clonar la tabla para modificarla
    const tablaClonada = tabla.cloneNode(true);
    
    // Remover columnas de acciones
    const filas = tablaClonada.querySelectorAll('tr');
    filas.forEach(fila => {
        const celdas = fila.querySelectorAll('th, td');
        // Remover la última columna (Acciones)
        if (celdas.length > 0) {
            celdas[celdas.length - 1].remove();
        }
    });

    // Limpiar badges y botones
    const badges = tablaClonada.querySelectorAll('.badge');
    badges.forEach(badge => {
        badge.outerHTML = badge.textContent;
    });

    const botones = tablaClonada.querySelectorAll('.btn-group');
    botones.forEach(boton => {
        boton.remove();
    });

    // Crear archivo Excel
    const html = tablaClonada.outerHTML;
    const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    const url = window.URL.createObjectURL(blob);
    
    // Crear enlace de descarga
    const enlace = document.createElement('a');
    enlace.href = url;
    enlace.download = `inventario_${tablaId}_${new Date().toISOString().split('T')[0]}.xls`;
    enlace.click();
    
    // Limpiar URL
    window.URL.revokeObjectURL(url);
}