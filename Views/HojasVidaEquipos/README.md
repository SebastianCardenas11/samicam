# Módulo Hojas de Vida de Equipos

## Descripción
Este módulo permite gestionar y visualizar las hojas de vida completas de todos los equipos registrados en el sistema de inventario. Proporciona un historial detallado de todos los movimientos, mantenimientos y cambios realizados a cada equipo.

## Funcionalidades

### 1. Lista de Equipos
- Visualización de todos los equipos con movimientos registrados
- Información básica: tipo, número, marca, modelo, estado y disponibilidad
- Contador de movimientos totales por equipo
- Fecha del último movimiento registrado

### 2. Hoja de Vida Individual
- **Información General**: Datos técnicos completos del equipo
- **Estadísticas**: Resumen de movimientos (entradas/salidas de mantenimiento)
- **Historial Completo**: Cronología detallada de todos los movimientos

### 3. Generación de PDF
- Reporte individual por equipo en formato PDF
- Incluye toda la información de la hoja de vida
- Descarga automática con nombre descriptivo

## Tipos de Equipos Soportados
- Impresoras
- Escáneres
- PC Torre
- PC Todo en Uno
- Portátiles
- Herramientas

## Estructura de Archivos

```
HojasVidaEquipos/
├── Controllers/
│   └── HojasVidaEquipos.php
├── Models/
│   └── HojasVidaEquiposModel.php
├── Views/
│   └── HojasVidaEquipos/
│       ├── hojasVidaEquipos.php
│       └── README.md
├── Assets/
│   ├── Js/
│   │   └── functions_hojas_vida_equipos.js
│   └── css/
│       └── hojas-vida-equipos.css
└── Public/
    └── sql/
        └── hojas_vida_equipos.sql
```

## Base de Datos
El módulo utiliza la tabla `tbl_equipos_movimientos` que registra:
- ID del equipo y tipo de equipo
- Tipo de movimiento (entrada/salida)
- Observaciones del movimiento
- Fecha y hora del registro
- Usuario que realizó el registro

## Permisos
El módulo utiliza los mismos permisos del módulo de Inventario (MINVENTARIO):
- **Lectura (r)**: Ver hojas de vida y generar reportes
- **Escritura (w)**: No aplica (los movimientos se registran desde Inventario)
- **Actualización (u)**: No aplica
- **Eliminación (d)**: No aplica

## Uso
1. Acceder al módulo desde el menú "Gestión Operativa > Hojas de Vida"
2. Seleccionar un equipo de la lista
3. Hacer clic en "Ver Hoja de Vida" para visualizar el detalle
4. Usar "Generar PDF" para descargar el reporte completo

## Características Técnicas
- Interfaz responsive con Bootstrap
- DataTables para manejo de datos
- Generación de PDF con FPDI
- Diseño moderno con CSS personalizado
- Integración completa con el sistema SAMICAM