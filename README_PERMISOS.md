# Sistema de Permisos SAMICAM

## Descripción
Este documento explica cómo funciona el sistema de permisos en la aplicación SAMICAM, que permite controlar el acceso a diferentes módulos según el rol del usuario.

## Estructura de Permisos

### Módulos
Los módulos del sistema están definidos en el archivo `Config/Config.php` como constantes:

```php
//Módulos
const MDASHBOARD = 1;
const MUSUARIOS = 2;
const MROLES = 3;
const MFUNCIONARIOSOPS = 4;
const MFUNCIONARIOSPLANTA = 4;
const MPERMISOS = 5;
const MVACACIONES = 6;
const MVIATICOS = 7;
const MARCHIVOS = 8;
```

### Tabla de Permisos
La tabla `permisos` en la base de datos almacena los permisos para cada rol y módulo:

- `idpermiso`: Identificador único del permiso
- `rolid`: ID del rol al que se asigna el permiso
- `moduloid`: ID del módulo al que se refiere el permiso
- `r`: Permiso de lectura (read)
- `w`: Permiso de escritura (write)
- `u`: Permiso de actualización (update)
- `d`: Permiso de eliminación (delete)

## Cómo Funciona

1. **Inicialización de Permisos**: Cuando un usuario inicia sesión, se cargan sus permisos según su rol.

2. **Verificación de Permisos**: En cada controlador, se llama a la función `getPermisos()` con el ID del módulo correspondiente:
   ```php
   getPermisos(MDASHBOARD);
   ```

3. **Acceso a Módulos**: En la vista, se verifica si el usuario tiene permiso para ver cada módulo:
   ```php
   <?php if (!empty($_SESSION['permisos'][MDASHBOARD]['r'])) { ?>
     <!-- Contenido del módulo -->
   <?php } ?>
   ```

4. **Acciones Permitidas**: Para cada acción (crear, editar, eliminar), se verifica el permiso correspondiente:
   ```php
   <?php if ($_SESSION['permisosMod']['w']) { ?>
     <!-- Botón para crear -->
   <?php } ?>
   
   <?php if ($_SESSION['permisosMod']['u']) { ?>
     <!-- Botón para editar -->
   <?php } ?>
   
   <?php if ($_SESSION['permisosMod']['d']) { ?>
     <!-- Botón para eliminar -->
   <?php } ?>
   ```

## Cómo Agregar un Nuevo Módulo

1. **Definir la constante** en `Config/Config.php`:
   ```php
   const MNUEVOMODULO = 13;
   ```

2. **Agregar el módulo** a la tabla `modulo` en la base de datos:
   ```sql
   INSERT INTO modulo (idmodulo, titulo, descripcion, status) 
   VALUES (13, 'Nuevo Módulo', 'Descripción del nuevo módulo', 1);
   ```

3. **Asignar permisos** para los roles que necesiten acceso:
   ```sql
   INSERT INTO permisos (rolid, moduloid, r, w, u, d)
   VALUES (1, 13, 1, 1, 1, 1);
   ```

4. **En el controlador** del nuevo módulo, agregar:
   ```php
   getPermisos(MNUEVOMODULO);
   ```

5. **En la vista**, verificar los permisos:
   ```php
   <?php if (!empty($_SESSION['permisos'][MNUEVOMODULO]['r'])) { ?>
     <!-- Contenido del módulo -->
   <?php } ?>
   ```

## Roles Predefinidos

- **Superadministrador (ID: 1)**: Acceso completo a todos los módulos
- **Jefe Talento Humano (ID: 2)**: Acceso a módulos de personal y permisos
- **Secretaria TH (ID: 3)**: Acceso limitado a módulos de personal
- **Contratación (ID: 4)**: Acceso a módulos de contratación y viáticos
- **Tecnico Ntic (ID: 5)**: Acceso a módulos técnicos
- **Secretaria Ntic (ID: 7)**: Acceso limitado a módulos técnicos

## Archivo SQL para Actualizar Permisos

Se ha creado un archivo `sql_update_permisos.sql` que contiene las instrucciones para actualizar la base de datos con los permisos para los módulos que faltan. Este archivo se puede ejecutar en phpMyAdmin o cualquier cliente SQL para actualizar los permisos.