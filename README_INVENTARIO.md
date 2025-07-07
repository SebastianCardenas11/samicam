# Módulo de Inventario - Samicam

## Descripción

El módulo de inventario permite gestionar de manera integral los recursos tecnológicos y de papelería de la institución. Incluye la gestión de impresoras, escáneres y artículos de papelería con un sistema de control de estado, disponibilidad y asignación a funcionarios.

## Características Principales

### 🔧 Gestión de Impresoras
- Registro de impresoras con información técnica completa
- Control de estado (Activo, Inactivo, En Mantenimiento, Fuera de Servicio)
- Gestión de disponibilidad (Disponible, En Uso, Reservado, No Disponible)
- Asignación a dependencias, funcionarios y contactos técnicos
- Control de consumibles y números de serie

### 📄 Gestión de Escáneres
- Registro de escáneres con especificaciones técnicas
- Control de estado y disponibilidad
- Asignación a dependencias y funcionarios
- Seguimiento de números de serie

### 📎 Gestión de Papelería
- Control de inventario de artículos de papelería
- Gestión de cantidades y unidades de medida
- Estados de disponibilidad (Disponible, Agotado, En Reposición, Vencido)
- Asignación a dependencias y funcionarios

## Estructura del Módulo

### Archivos Principales

```
Controllers/
├── Inventario.php              # Controlador principal del módulo

Models/
├── InventarioModel.php         # Modelo con todas las consultas a BD

Views/
├── Inventario/
│   └── inventario.php         # Vista principal con pestañas
└── Template/Modals/
    └── modalInventario.php    # Modal para formularios

Assets/Js/
└── functions_inventario.js    # JavaScript para funcionalidades

Public/sql/
└── create_inventario_tables.sql # Scripts SQL para crear tablas
```

### Base de Datos

#### Tablas Principales

1. **tbl_impresoras**
   - Gestión completa de impresoras
   - Campos: id_impresora, numero_impresora, marca, modelo, serial, consumible, estado, disponibilidad, etc.

2. **tbl_escaneres**
   - Gestión de escáneres
   - Campos: id_escaner, numero_escaner, marca, modelo, serial, estado, disponibilidad, etc.

3. **tbl_papeleria**
   - Control de artículos de papelería
   - Campos: id_articulo, nombre_articulo, descripcion, cantidad, unidad, estado, etc.

4. **tbl_contactos**
   - Información de contactos técnicos
   - Campos: id_contacto, nombre_contacto, telefono, email, cargo, empresa, etc.

## Funcionalidades

### ✅ Operaciones CRUD Completas
- **Crear**: Nuevos registros de impresoras, escáneres y papelería
- **Leer**: Consulta y visualización de todos los elementos del inventario
- **Actualizar**: Modificación de información existente
- **Eliminar**: Eliminación lógica de registros

### 🔍 Características Avanzadas
- **Pestañas organizadas**: Interfaz con pestañas para cada tipo de inventario
- **DataTables**: Tablas dinámicas con paginación, búsqueda y ordenamiento
- **Validación de formularios**: Validación en frontend y backend
- **Permisos de usuario**: Control de acceso basado en roles
- **Auditoría**: Registro automático de accesos al módulo

### 📊 Información Relacionada
- **Dependencias**: Asignación a áreas organizacionales
- **Funcionarios**: Responsables de cada elemento
- **Cargos**: Información de cargos de los funcionarios
- **Contactos**: Información de técnicos y proveedores

## Instalación

### 1. Ejecutar Scripts SQL
```sql
-- Ejecutar el archivo create_inventario_tables.sql
-- Este creará todas las tablas necesarias y datos de ejemplo
```

### 2. Verificar Permisos
- Asegurar que el módulo MINVENTARIO (ID: 15) esté configurado en el sistema de permisos
- Asignar permisos de lectura (r), escritura (w), actualización (u) y eliminación (d) según corresponda

### 3. Configuración de Rutas
- El módulo es accesible a través de: `/inventario`
- Todas las rutas AJAX están configuradas en el controlador

## Uso del Sistema

### Navegación
1. Acceder al módulo desde el menú principal
2. Seleccionar la pestaña correspondiente (Impresoras, Escáneres, Papelería)
3. Usar los botones de acción para gestionar el inventario

### Agregar Nuevo Elemento
1. Hacer clic en el botón "Nuevo" de la pestaña correspondiente
2. Completar el formulario con la información requerida
3. Guardar los datos

### Editar Elemento
1. Hacer clic en el botón de editar (ícono de lápiz) en la fila correspondiente
2. Modificar la información en el formulario
3. Guardar los cambios

### Eliminar Elemento
1. Hacer clic en el botón de eliminar (ícono de papelera)
2. Confirmar la eliminación en el diálogo de confirmación

## API Endpoints

### Impresoras
- `GET /Inventario/getImpresoras` - Obtener todas las impresoras
- `GET /Inventario/getImpresora/{id}` - Obtener impresora específica
- `POST /Inventario/setImpresora` - Crear/actualizar impresora
- `POST /Inventario/delImpresora` - Eliminar impresora

### Escáneres
- `GET /Inventario/getEscaneres` - Obtener todos los escáneres
- `GET /Inventario/getEscaner/{id}` - Obtener escáner específico
- `POST /Inventario/setEscaner` - Crear/actualizar escáner
- `POST /Inventario/delEscaner` - Eliminar escáner

### Papelería
- `GET /Inventario/getPapeleria` - Obtener toda la papelería
- `GET /Inventario/getArticuloPapeleria/{id}` - Obtener artículo específico
- `POST /Inventario/setArticuloPapeleria` - Crear/actualizar artículo
- `POST /Inventario/delArticuloPapeleria` - Eliminar artículo

### Datos de Referencia
- `GET /Inventario/getDependencias` - Obtener dependencias
- `GET /Inventario/getFuncionarios` - Obtener funcionarios
- `GET /Inventario/getCargos` - Obtener cargos
- `GET /Inventario/getContactos` - Obtener contactos

## Configuración de Permisos

El módulo utiliza el sistema de permisos existente con el ID de módulo `MINVENTARIO = 15`.

### Permisos Requeridos
- **r (Read)**: Permite ver y consultar el inventario
- **w (Write)**: Permite crear nuevos elementos
- **u (Update)**: Permite editar elementos existentes
- **d (Delete)**: Permite eliminar elementos

## Personalización

### Agregar Nuevos Tipos de Inventario
1. Crear nueva tabla en la base de datos
2. Agregar métodos en el controlador
3. Agregar métodos en el modelo
4. Crear pestaña en la vista
5. Agregar formulario en el modal
6. Implementar funciones JavaScript

### Modificar Estados
Los estados están definidos como ENUM en la base de datos:
- **Impresoras/Escáneres**: Activo, Inactivo, En Mantenimiento, Fuera de Servicio
- **Papelería**: Disponible, Agotado, En Reposición, Vencido

## Mantenimiento

### Limpieza de Datos
- Los registros eliminados se marcan con `status = 0` (eliminación lógica)
- Se pueden recuperar modificando directamente la base de datos

### Respaldos
- Realizar respaldos regulares de las tablas del inventario
- Especial atención a las tablas: `tbl_impresoras`, `tbl_escaneres`, `tbl_papeleria`

## Soporte Técnico

Para soporte técnico o reportar problemas:
- Revisar los logs del sistema
- Verificar la conectividad a la base de datos
- Comprobar los permisos de usuario
- Validar la configuración del módulo en el sistema de permisos

## Versión
- **Versión actual**: 1.0.0
- **Fecha de creación**: 2024
- **Compatibilidad**: PHP 7.4+, MySQL 5.7+ 