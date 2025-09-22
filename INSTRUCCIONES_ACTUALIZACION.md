# Instrucciones para Actualización de Campos Teclado y Mouse

## Resumen de Cambios
Se han agregado los campos de **teclado**, **serial_teclado**, **mouse** y **serial_mouse** al módulo de inventario para los equipos "PC Todo en Uno".

## Archivos Modificados

### 1. Base de Datos
- **Archivo**: `ejecutar_actualizacion.sql`
- **Acción**: Ejecutar este script en phpMyAdmin o MySQL Workbench

### 2. Controlador
- **Archivo**: `Controllers/Inventario.php`
- **Cambios**: Ya incluye el manejo de los nuevos campos en el método `setTodoEnUno()`

### 3. Modelo
- **Archivo**: `Models/InventarioModel.php`
- **Cambios**: Los métodos `insertTodoEnUno()` y `updateTodoEnUno()` ya manejan los nuevos campos

### 4. Vista
- **Archivo**: `Views/Inventario/inventario.php`
- **Cambios**: Se agregaron las columnas "Teclado" y "Mouse" en la tabla de PC Todo en Uno

### 5. Modal
- **Archivo**: `Views/Template/Modals/modalInventario.php`
- **Cambios**: Ya incluye los campos de teclado y mouse en el formulario de PC Todo en Uno

### 6. JavaScript
- **Archivo**: `Assets/Js/functions_inventario.js`
- **Cambios**: 
  - Se agregaron las columnas en el DataTable
  - Se actualizó la función `editTodoEnUno()` para cargar los nuevos campos
  - Se actualizó la función `verTodoEnUno()` para mostrar los nuevos campos

## Pasos para Aplicar la Actualización

### Paso 1: Actualizar la Base de Datos
1. Abrir phpMyAdmin o MySQL Workbench
2. Seleccionar la base de datos de SAMICAM
3. Ejecutar el contenido del archivo `ejecutar_actualizacion.sql`

### Paso 2: Verificar los Cambios
1. Acceder al módulo de Inventario en SAMICAM
2. Ir a la pestaña "PC Todo en Uno"
3. Verificar que aparezcan las columnas "Teclado" y "Mouse" en la tabla
4. Crear o editar un equipo PC Todo en Uno para verificar que los campos funcionen correctamente

## Funcionalidades Agregadas

### En la Tabla
- **Columna Teclado**: Muestra la marca/modelo del teclado
- **Columna Mouse**: Muestra la marca/modelo del mouse

### En el Formulario (Modal)
- **Campo Teclado**: Para ingresar marca/modelo del teclado
- **Campo Serial Teclado**: Para ingresar el serial del teclado
- **Campo Mouse**: Para ingresar marca/modelo del mouse
- **Campo Serial Mouse**: Para ingresar el serial del mouse

### En la Vista de Detalles
- Se muestran todos los campos de teclado y mouse cuando se hace clic en "Ver" un equipo

## Notas Importantes
- Los nuevos campos son opcionales (pueden quedar vacíos)
- Los campos se guardan correctamente en la base de datos
- La funcionalidad es compatible con equipos existentes
- No afecta otros tipos de equipos (solo PC Todo en Uno)

## Solución de Problemas
Si hay algún error:
1. Verificar que el script SQL se ejecutó correctamente
2. Limpiar caché del navegador (Ctrl+F5)
3. Verificar que no hay errores en la consola del navegador
4. Revisar los logs de PHP para errores del servidor