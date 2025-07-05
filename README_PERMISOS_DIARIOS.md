# Sistema de Permisos Diarios - SAMICAM

## Descripción General

Se ha implementado un sistema de control de permisos diarios que limita a 5 permisos por día, con las siguientes características:

### Características Principales

1. **Límite de 5 permisos diarios**: Cada día se pueden registrar máximo 5 permisos
2. **Contador visual**: Panel superior que muestra permisos disponibles, usados y tiempo restante
3. **Barra de progreso**: Indica visualmente el progreso de permisos utilizados
4. **Reloj de reseteo**: Muestra el tiempo restante hasta las 12:00 AM (medianoche) hora de Colombia
5. **Almacenamiento local**: Los permisos se guardan en localStorage del navegador
6. **Modal de límite**: Se muestra cuando se alcanzan los 5 permisos diarios
7. **Reseteo automático**: Los permisos se resetean automáticamente a las 12:00 AM

### Funcionalidades Implementadas

#### Panel de Control
- **Permisos Disponibles**: Muestra cuántos permisos quedan para el día
- **Permisos Usados**: Muestra cuántos permisos se han utilizado hoy
- **Tiempo para Reset**: Reloj en tiempo real que muestra cuándo se resetean los permisos
- **Barra de Progreso**: Cambia de color según el progreso (verde → amarillo → rojo)

#### Sistema de Almacenamiento
- **localStorage**: Almacena el contador de permisos diarios
- **Verificación de día**: Detecta automáticamente cuando es un nuevo día
- **Persistencia**: Los datos se mantienen entre sesiones del navegador

#### Validaciones
- **Límite diario**: Impide registrar más de 5 permisos por día
- **Permisos especiales**: No cuentan para el límite diario
- **Verificación previa**: Se valida antes de abrir el modal de registro

#### Interfaz de Usuario
- **Modal de límite**: Se muestra cuando se alcanzan los 5 permisos
- **Reloj en tiempo real**: Actualiza cada segundo
- **Animaciones**: Efectos visuales para mejor experiencia de usuario
- **Responsive**: Se adapta a diferentes tamaños de pantalla

### Archivos Modificados/Creados

#### Archivos de Vista
- `Views/FuncionariosPermisos/Funcionariospermisos.php`: Panel de control agregado
- `Views/Template/Modals/modalFuncionariosPermisos.php`: Modal de límite agregado

#### Archivos JavaScript
- `Assets/Js/functions_funcionariosPermisos.js`: Lógica completa del sistema

#### Archivos CSS
- `Assets/css/permisos-diarios.css`: Estilos personalizados
- `Views/Template/header_admin.php`: Inclusión del CSS

### Cómo Funciona

#### Inicialización
1. Al cargar la página, se verifica si es un nuevo día
2. Se cargan los permisos del localStorage
3. Se actualiza la interfaz con los contadores
4. Se inicia el reloj de reseteo

#### Registro de Permisos
1. Al hacer clic en "Registrar Permiso", se verifica el límite diario
2. Si no se ha alcanzado el límite, se abre el modal de registro
3. Al guardar un permiso normal, se incrementa el contador
4. Los permisos especiales no afectan el contador diario

#### Reseteo Automático
1. El sistema verifica cada minuto si es un nuevo día
2. A las 12:00 AM (medianoche) hora de Colombia, se resetean los permisos
3. El localStorage se limpia y los contadores vuelven a 0

#### Validaciones
- **Límite diario**: Máximo 5 permisos por día
- **Permisos especiales**: No cuentan para el límite
- **Nuevo día**: Reseteo automático a medianoche
- **Persistencia**: Los datos se mantienen entre sesiones

### Configuración

#### Cambiar el Límite de Permisos
Para cambiar el límite de 5 permisos diarios, modificar en `functions_funcionariosPermisos.js`:

```javascript
let maxPermisosDiarios = 5; // Cambiar este valor
```

#### Cambiar la Zona Horaria
El sistema está configurado para Colombia. Para cambiar la zona horaria, modificar en la función `iniciarReloj()`:

```javascript
const colombiaTime = new Date(ahora.toLocaleString("en-US", {timeZone: "America/Bogota"}));
```

### Notas Importantes

1. **Permisos Especiales**: No afectan el contador diario y se pueden registrar sin límite
2. **localStorage**: Los datos se almacenan en el navegador del usuario
3. **Zona Horaria**: El reseteo se basa en la hora de Colombia (America/Bogota)
4. **Responsive**: La interfaz se adapta a dispositivos móviles
5. **Animaciones**: Efectos visuales para mejor experiencia de usuario

### Solución de Problemas

#### Si los permisos no se resetean
1. Verificar que la zona horaria esté configurada correctamente
2. Limpiar el localStorage del navegador
3. Recargar la página

#### Si el reloj no funciona
1. Verificar la conexión a internet (para obtener la hora actual)
2. Verificar que JavaScript esté habilitado
3. Revisar la consola del navegador para errores

#### Si el contador no se actualiza
1. Verificar que el localStorage esté habilitado
2. Recargar la página
3. Verificar que no haya errores en la consola

### Compatibilidad

- **Navegadores**: Chrome, Firefox, Safari, Edge (versiones modernas)
- **Dispositivos**: Desktop, tablet, móvil
- **JavaScript**: Requerido y habilitado
- **localStorage**: Requerido y habilitado

### Mantenimiento

Para mantener el sistema funcionando correctamente:

1. **Monitorear logs**: Revisar la consola del navegador para errores
2. **Actualizar zona horaria**: Si es necesario cambiar la zona horaria
3. **Limpiar localStorage**: Ocasionalmente para evitar acumulación de datos
4. **Verificar funcionalidad**: Probar el sistema regularmente

### Contacto

Para soporte técnico o preguntas sobre el sistema de permisos diarios, contactar al equipo de desarrollo. 