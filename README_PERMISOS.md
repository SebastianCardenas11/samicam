# Guía de Permisos en SAMICAM

## Permisos disponibles

El sistema SAMICAM maneja los siguientes tipos de permisos para cada módulo:

- **Ver (r)**: Permite visualizar la información del módulo.
- **Crear (w)**: Permite crear nuevos registros en el módulo.
- **Actualizar (u)**: Permite modificar registros existentes en el módulo.
- **Eliminar (d)**: Permite eliminar registros del módulo.
- **Visible en Menú (v)**: Controla si el módulo aparece en la barra de navegación.

## Configuración de permisos

Para configurar los permisos de un rol:

1. Acceda al módulo de **Roles** en el sistema.
2. Haga clic en el botón de **Permisos** (ícono de interruptores) para el rol que desea configurar.
3. En la ventana modal que aparece, marque o desmarque las casillas según los permisos que desee otorgar.
4. Para ocultar un módulo del menú de navegación, desmarque la casilla "Visible en Menú".
5. Haga clic en **Guardar** para aplicar los cambios.

## Consideraciones importantes

- Un usuario solo puede acceder a los módulos para los que tiene permiso de visualización (r).
- Si un módulo tiene el permiso "Visible en Menú" desactivado, no aparecerá en la barra de navegación, aunque el usuario tenga permiso para verlo.
- Para acceder a un módulo oculto, el usuario deberá conocer la URL directa.
- Los permisos se aplican a nivel de rol, por lo que todos los usuarios con el mismo rol tendrán los mismos permisos.

## Actualización de la base de datos

Si está actualizando desde una versión anterior del sistema, es posible que necesite ejecutar el siguiente script SQL para añadir la columna de visibilidad a la tabla de permisos:

```sql
ALTER TABLE permisos ADD COLUMN v TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Permiso de visibilidad';
```

Este script añade la columna 'v' con un valor predeterminado de 1 (visible) a todos los registros existentes.