# Instrucciones para Implementar Campos Faltantes en Funcionarios Planta

## Campos Agregados

Se han agregado los siguientes campos faltantes al módulo de funcionarios planta:

### Información Adicional
- **Lugar de Expedición**: Lugar donde se expidió el documento de identidad
- **Libre Militar**: Si/No/No Aplica
- **Código**: Código del funcionario
- **Grado**: Grado del funcionario
- **Ciudad de Residencia**: Ciudad donde reside actualmente
- **Fecha de Nacimiento**: Fecha de nacimiento del funcionario
- **Lugar de Nacimiento**: Lugar donde nació el funcionario
- **RH**: Tipo de sangre (O+, O-, A+, A-, B+, B-, AB+, AB-)

### Información Laboral Adicional
- **Acto Administrativo**: Número del acto administrativo
- **Fecha Acto de Nombramiento**: Fecha del acto de nombramiento
- **No. Acta de Posesión**: Número del acta de posesión
- **Fecha de Acta de Posesión**: Fecha del acta de posesión
- **Tiempo Laborado**: Tiempo que lleva laborando
- **Título**: Título académico obtenido
- **Tarjeta Profesional**: Número de tarjeta profesional
- **Otros Estudios y/o Especializaciones**: Estudios adicionales

### Información Financiera y Seguridad Social
- **Cuenta No.**: Número de cuenta bancaria
- **Banco**: Entidad bancaria
- **E.P.S**: Entidad Promotora de Salud
- **A.F.P**: Administradora de Fondos de Pensiones
- **A.F.C**: Administradora de Fondos de Cesantías
- **A.R.L**: Administradora de Riesgos Laborales
- **Sindicalizado**: Si/No
- **Madre Cabeza de Hogar**: Si/No
- **Prepensionado**: Si/No

## Pasos para Implementar

### 1. Ejecutar Script SQL
Ejecutar el archivo `Public/sql/update_funcionarios_planta_campos.sql` en la base de datos para agregar las nuevas columnas.

```sql
-- Ejecutar en phpMyAdmin o cliente MySQL
source Public/sql/update_funcionarios_planta_campos.sql;
```

### 2. Archivos Modificados

Los siguientes archivos han sido actualizados:

#### Modelo (Models/FuncionariosPlantaModel.php)
- ✅ Agregadas propiedades privadas para los nuevos campos
- ✅ Actualizado método `insertFuncionario()` con parámetros opcionales
- ✅ Actualizado método `updateFuncionario()` con parámetros opcionales
- ✅ Actualizado método `selectFuncionario()` para incluir nuevos campos en SELECT

#### Controlador (Controllers/FuncionariosPlanta.php)
- ✅ Agregada captura de nuevos campos del POST
- ✅ Actualizada llamada a `insertFuncionario()` con nuevos parámetros
- ✅ Actualizada llamada a `updateFuncionario()` con nuevos parámetros

#### Vista Modal (Views/Template/Modals/modalFuncionariosPlanta.php)
- ✅ Agregados nuevos campos organizados en 3 tarjetas adicionales:
  - Información Adicional
  - Información Laboral Adicional
  - Información Financiera y Seguridad Social

#### JavaScript (Assets/Js/functions_funcionariosPlanta.js)
- ✅ Agregada captura de valores de nuevos campos
- ✅ Actualizada función de edición para cargar nuevos campos
- ✅ Validaciones opcionales para campos nuevos

### 3. Características Implementadas

- **Campos Opcionales**: Todos los nuevos campos son opcionales y no afectan la funcionalidad existente
- **Compatibilidad**: El código es compatible con registros existentes
- **Validación**: Los campos tienen validaciones apropiadas (fechas, selects, etc.)
- **Interfaz**: Los campos están organizados en tarjetas para mejor usabilidad
- **Responsive**: La interfaz mantiene el diseño responsive

### 4. Notas Importantes

1. **Backup**: Hacer backup de la base de datos antes de ejecutar el script SQL
2. **Pruebas**: Probar la funcionalidad en un entorno de desarrollo primero
3. **Campos Existentes**: Los campos existentes no se ven afectados
4. **Migración**: Los funcionarios existentes tendrán valores NULL en los nuevos campos

### 5. Verificación

Para verificar que todo funciona correctamente:

1. Ejecutar el script SQL
2. Acceder al módulo de Funcionarios Planta
3. Crear un nuevo funcionario y verificar que aparecen todos los campos
4. Editar un funcionario existente y verificar que se cargan correctamente
5. Guardar cambios y verificar que se almacenan en la base de datos

## Campos Mapeados según Lista Original

| Campo Original | Campo Implementado | Tipo |
|---|---|---|
| Lugar de Expedición | lugar_expedicion | VARCHAR(255) |
| Libre Militar | libre_militar | VARCHAR(20) |
| Acto Administrativo | acto_administrativo | VARCHAR(255) |
| Fecha Acto de Nombramiento | fecha_acto_nombramiento | DATE |
| No. Acta de Posesión | no_acta_posesion | VARCHAR(100) |
| Fecha de Acta de Posesión | fecha_acta_posesion | DATE |
| Tiempo Laborado | tiempo_laborado | VARCHAR(100) |
| Código | codigo | VARCHAR(50) |
| Grado | grado | VARCHAR(50) |
| Ciudad de Residencia | ciudad_residencia | VARCHAR(255) |
| Fecha de Nacimiento | fecha_nacimiento | DATE |
| Lugar de Nacimiento | lugar_nacimiento | VARCHAR(255) |
| RH | rh | VARCHAR(10) |
| Título | titulo | VARCHAR(255) |
| Tarjeta Profesional | tarjeta_profesional | VARCHAR(100) |
| Otros Estudios | otros_estudios | TEXT |
| Cuenta No. | cuenta_no | VARCHAR(50) |
| Banco | banco | VARCHAR(100) |
| E.P.S | eps | VARCHAR(100) |
| A.F.P | afp | VARCHAR(100) |
| A.F.C | afc | VARCHAR(100) |
| A.R.L | arl | VARCHAR(100) |
| Sindicalizado | sindicalizado | VARCHAR(10) |
| Madre Cabeza de Hogar | madre_cabeza_hogar | VARCHAR(10) |
| Prepensionado | prepensionado | VARCHAR(10) |

**Nota**: Los campos como "Nivel" y "Salario Básico" ya están disponibles a través de la relación con la tabla `tbl_cargos`.