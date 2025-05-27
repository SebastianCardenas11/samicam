# Migración de Funcionarios a Dos Tablas Separadas

## Descripción del Cambio

Este proyecto implementa una separación de la tabla de funcionarios en dos tablas diferentes:
- `tbl_funcionarios_planta`: Para funcionarios de planta (Carrera, Libre Nombramiento)
- `tbl_funcionarios_ops`: Para funcionarios OPS y otros tipos de contrato

La principal diferencia es que los funcionarios OPS no tienen permisos, vacaciones, fecha de vacaciones ni periodos de vacaciones.

## Archivos Modificados

1. **Modelos**:
   - `FuncionariosPlantaModel.php`: Actualizado para trabajar con la tabla `tbl_funcionarios_planta`
   - `FuncionariosOpsModel.php`: Actualizado para trabajar con la tabla `tbl_funcionarios_ops`
   - `VacacionesModel.php`: Actualizado para trabajar solo con funcionarios de planta
   - `FuncionariosPermisosModel.php`: Actualizado para trabajar solo con funcionarios de planta

2. **Nuevos Archivos**:
   - `FuncionariosOpsPermisosModel.php`: Modelo para gestionar funcionarios OPS (sin funcionalidad de permisos)
   - `FuncionariosOpsPermisos.php`: Controlador para la vista de funcionarios OPS

3. **Script SQL**:
   - `db_update.sql`: Script para actualizar la estructura de la base de datos

## Instrucciones de Implementación

### 1. Respaldo de la Base de Datos
Antes de realizar cualquier cambio, haga un respaldo completo de su base de datos:
```
mysqldump -u root -p samicam > samicam_backup.sql
```

### 2. Ejecutar el Script de Actualización
```
mysql -u root -p samicam < db_update.sql
```

### 3. Verificar la Estructura
Después de ejecutar el script, verifique que:
- La tabla `tbl_funcionarios_planta` contiene solo funcionarios de planta
- La tabla `tbl_funcionarios_ops` contiene solo funcionarios OPS
- Las tablas relacionadas tienen el nuevo campo `tipo_funcionario`

### 4. Actualizar los Archivos del Sistema
Reemplace los archivos modificados en su sistema con los nuevos archivos proporcionados.

### 5. Probar el Sistema
Acceda al sistema y verifique que:
- El módulo de Funcionarios Planta muestra solo funcionarios de planta
- El módulo de Funcionarios OPS muestra solo funcionarios OPS
- Las funcionalidades de vacaciones y permisos funcionan correctamente

## Notas Importantes
- Esta migración es irreversible una vez completada
- Los funcionarios OPS no tienen acceso a vacaciones ni permisos
- Si encuentra algún error, restaure el respaldo de la base de datos

## Soporte
Para cualquier consulta o problema, contacte al equipo de soporte técnico.