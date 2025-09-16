# 📋 MÓDULO DE PETICIONES/PQRs - SAMICAM

## 🎯 Descripción General

El módulo de Peticiones, Quejas, Reclamos y Sugerencias (PQRs) es un sistema completo para la gestión y seguimiento de peticiones ciudadanas, diseñado para cumplir con los plazos legales establecidos por la normatividad colombiana.

## ✨ Características Principales

### 🔄 Flujo Completo de Gestión
- **Radicación**: Registro de peticiones con número de radicado único
- **Seguimiento**: Control automático de plazos y estados
- **Respuesta**: Gestión de respuestas con archivos adjuntos
- **Trazabilidad**: Historial completo de cambios y acciones

### ⏰ Cálculo Automático de Días Hábiles
- Exclusión automática de fines de semana
- Manejo de días festivos nacionales y locales
- Actualización en tiempo real de días restantes
- Semáforo visual de alertas

### 📊 Plazos Legales Configurados
- **Derecho de petición**: 15 días hábiles
- **Tutelas**: 1 día hábil (configurable según juez)
- **Documentos e información**: 10 días hábiles
- **Consultas**: 30 días hábiles
- **Entre entidades**: 10 días hábiles
- **Entes de control**: 5 días hábiles

### 🚦 Sistema de Semáforo
- **🟢 Verde**: Más de 10 días hábiles disponibles
- **🟡 Amarillo**: Entre 6 y 10 días hábiles disponibles
- **🔴 Rojo**: 5 días hábiles o menos disponibles

## 🗂️ Estructura de Archivos

```
samicam/
├── Controllers/
│   └── Peticiones.php              # Controlador principal
├── Models/
│   └── PeticionesModel.php         # Modelo de datos
├── Views/
│   └── Peticiones/
│       └── peticiones.php          # Vista principal
├── Assets/
│   └── Js/
│       └── functions_peticiones.js # Funciones JavaScript
├── Helpers/
│   └── DiasHabilesHelper.php       # Helper para días hábiles
├── Public/
│   └── sql/
│       └── peticiones_pqrs.sql     # Script de base de datos
└── uploads/
    └── peticiones/                 # Archivos de respuesta
```

## 🗄️ Estructura de Base de Datos

### Tablas Principales

#### `tbl_peticiones`
Tabla principal que almacena toda la información de las peticiones.

**Campos principales:**
- `id_peticion`: ID único de la petición
- `numero_radicado`: Número de radicado único
- `fecha_ingreso`: Fecha de ingreso de la petición
- `nombre_peticionario`: Nombre del peticionario
- `descripcion_solicitud`: Descripción detallada
- `id_tipo_peticion`: Tipo de petición (FK)
- `dependencia_responsable`: Dependencia asignada (FK)
- `fecha_vencimiento`: Fecha límite de respuesta
- `dias_habiles_restantes`: Días hábiles restantes
- `estado_semaforo`: Estado del semáforo (verde/amarillo/rojo)
- `estado`: Estado actual (radicada/en_proceso/respondida/desistida/remitida/vencida)

#### `tbl_tipos_peticion`
Catálogo de tipos de peticiones con sus plazos legales.

#### `tbl_dias_festivos`
Calendario de días festivos para cálculo de días hábiles.

#### `tbl_peticiones_historial`
Registro de todos los cambios de estado de las peticiones.

### Funciones de Base de Datos

#### `calcular_dias_habiles(fecha_inicio, fecha_fin)`
Función que calcula los días hábiles entre dos fechas, excluyendo fines de semana y festivos.

#### `calcular_fecha_vencimiento(fecha_inicio, dias_habiles)`
Función que calcula la fecha de vencimiento agregando días hábiles a una fecha inicial.

### Triggers Automáticos

#### `calcular_vencimiento_peticion`
Se ejecuta al insertar una nueva petición para calcular automáticamente la fecha de vencimiento.

#### `actualizar_estado_peticion`
Se ejecuta al actualizar una petición para recalcular días restantes y estado del semáforo.

#### `registrar_historial_peticion`
Se ejecuta al cambiar el estado de una petición para mantener el historial.

## 🔧 Funcionalidades del Sistema

### 📝 Gestión de Peticiones

#### Crear Nueva Petición
```php
// Campos obligatorios
- Número de radicado (único)
- Fecha de ingreso
- Nombre del peticionario
- Descripción de la solicitud
- Tipo de petición
- Dependencia responsable

// Campos opcionales
- Observaciones
```

#### Estados de Petición
- **Radicada**: Petición recién ingresada
- **En Proceso**: Petición siendo atendida
- **Respondida**: Petición con respuesta oficial
- **Desistida**: Petición abandonada por el peticionario
- **Remitida**: Petición enviada a otra dependencia
- **Vencida**: Petición que superó el plazo legal

### 📊 Dashboard y Estadísticas

#### Indicadores Principales
- Total de peticiones
- Peticiones en proceso
- Peticiones próximas a vencer
- Peticiones vencidas

#### Semáforo de Alertas
- Visualización en tiempo real del estado de las peticiones
- Contadores por color de semáforo
- Alertas automáticas

### 📈 Reportes Disponibles

#### Tipos de Reportes
1. **Peticiones Vencidas**: Listado de peticiones que superaron el plazo
2. **Próximas a Vencer**: Peticiones con 5 días hábiles o menos
3. **Respondidas**: Peticiones con respuesta en un período
4. **Por Dependencia**: Estadísticas agrupadas por dependencia

#### Exportación
- Formato Excel (.xlsx)
- Filtros por fecha y dependencia
- Datos completos de cada petición

### 🔔 Sistema de Notificaciones

#### Notificaciones Automáticas
- **Creación**: Al radicar una nueva petición
- **Vencimiento Próximo**: 2 días hábiles antes del vencimiento
- **Vencida**: Cuando se supera el plazo
- **Respondida**: Al registrar una respuesta
- **Remitida**: Al remitir a otra dependencia

#### Canales de Notificación
- **WhatsApp**: Mensajes automáticos al grupo configurado
- **Sistema Interno**: Notificaciones en la plataforma
- **Email**: Respaldo cuando WhatsApp no esté disponible

## 🚀 Instalación y Configuración

### 1. Ejecutar Script SQL
```sql
-- Ejecutar el archivo peticiones_pqrs.sql en la base de datos
mysql -u root -p samicam < Public/sql/peticiones_pqrs.sql
```

### 2. Configurar Permisos
```php
// Agregar permisos en la tabla permisos para los roles necesarios
INSERT INTO permisos (rolid, moduloid, r, w, u, d, v) VALUES
(1, 20, 1, 1, 1, 1, 1); -- Superadministrador
```

### 3. Configurar Días Festivos
```sql
-- Los días festivos de Colombia 2025 ya están incluidos
-- Para agregar más años, usar la función agregarFestivo()
```

### 4. Configurar Notificaciones
```php
// Configurar WhatsApp en Config/WhatsAppConfig.php
// Configurar email en Helpers/enviar_correo.php
```

## 📱 Uso del Sistema

### Para Usuarios Finales

#### Radicar Nueva Petición
1. Hacer clic en "Nueva Petición"
2. Llenar todos los campos obligatorios
3. Seleccionar tipo de petición (determina el plazo)
4. Asignar dependencia responsable
5. Guardar la petición

#### Gestionar Peticiones Existentes
1. **Ver**: Consultar información completa y historial
2. **Editar**: Modificar datos básicos (solo si no está respondida)
3. **Responder**: Registrar respuesta oficial con archivo adjunto
4. **Remitir**: Enviar a otra dependencia con justificación
5. **Desistir**: Marcar como abandonada por el peticionario

### Para Administradores

#### Monitoreo Diario
1. Revisar dashboard de estadísticas
2. Verificar semáforo de alertas
3. Atender peticiones en rojo (urgentes)
4. Actualizar estados manualmente si es necesario

#### Reportes Periódicos
1. Generar reportes mensuales por dependencia
2. Analizar tiempos de respuesta
3. Identificar cuellos de botella
4. Exportar datos para análisis externos

## 🔧 Mantenimiento

### Tareas Automáticas
- Actualización diaria de días hábiles restantes
- Cambio automático de estado a "vencida"
- Recálculo del semáforo de alertas
- Envío de notificaciones programadas

### Tareas Manuales
- Agregar nuevos días festivos cada año
- Configurar nuevos tipos de petición si es necesario
- Ajustar plazos legales según normatividad
- Mantener actualizada la lista de dependencias

### Respaldos Recomendados
- Respaldo diario de la base de datos
- Respaldo semanal de archivos de respuesta
- Monitoreo de logs de errores
- Verificación de integridad de datos

## 🆘 Solución de Problemas

### Problemas Comunes

#### Días Hábiles Incorrectos
```php
// Verificar días festivos en tbl_dias_festivos
// Ejecutar manualmente la actualización
$helper = new DiasHabilesHelper();
$helper->actualizarDiasHabilesRestantes();
```

#### Notificaciones No Enviadas
```php
// Verificar configuración de WhatsApp
// Revisar logs en uploads/whatsapp_log.txt
// Verificar conectividad de red
```

#### Archivos No Subidos
```bash
# Verificar permisos del directorio
chmod 755 uploads/peticiones/
# Verificar espacio en disco
df -h
```

### Logs y Monitoreo
- **Errores PHP**: Revisar logs del servidor web
- **WhatsApp**: uploads/whatsapp_log.txt
- **Base de datos**: Logs de MySQL/MariaDB
- **Aplicación**: Logs personalizados en error_log()

## 📞 Soporte Técnico

### Contacto
- **Desarrollador**: Equipo SAMICAM
- **Email**: soporte@samicam.com
- **Documentación**: /Public/templates/

### Recursos Adicionales
- Manual de usuario completo
- Videos tutoriales
- FAQ de preguntas frecuentes
- Guía de administración

---

**Versión**: 1.0  
**Fecha**: Agosto 2025  
**Compatibilidad**: SAMICAM v2.0+  
**Licencia**: Propietaria - Alcaldía de La Jagua de Ibirico