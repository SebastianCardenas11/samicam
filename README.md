# 📊 SAMICAM
**Sistema Administrativo de Módulos de Información del CAM**

SAMICAM es una aplicación web desarrollada para facilitar la gestión y administración de los diferentes módulos de información del CAM (Centro Administrativo Municipal). Este sistema permite manejar usuarios, roles, permisos y módulos de forma centralizada, ordenada y segura.

---

## 🚀 Funcionalidades Principales

- 🔐 Gestión de usuarios y autenticación segura
- 👤 Control de roles y permisos personalizados
- 📁 Administración de módulos de información
- 📊 Visualización y organización del contenido del CAM
- 🧩 Interfaz sencilla, clara y adaptable
- 📂 Gestión de archivos y categorías
- 🗃️ Inventario de equipos y materiales
- 📅 Control de permisos, viáticos y vacaciones
- 📈 Panel de control con gráficas y estadísticas
- 🔔 Sistema de notificaciones internas
- 🕵️ Auditoría de acciones y cambios
- 💬 Integración con WhatsApp para notificaciones
- 📝 Plantillas PDF para reportes y permisos

---

## 🛠️ Tecnologías Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap
- **Backend:** PHP (con estructura MVC)
- **Base de Datos:** MySQL
- **Servidor local:** XAMPP

---

## 🗂️ Estructura del Proyecto

La estructura de carpetas del sistema es la siguiente:

```
samicam/
├── Assets/                # Recursos estáticos (CSS, JS, imágenes, fuentes, plantillas PDF)
│   ├── css/               # Hojas de estilo personalizadas y de terceros
│   ├── fonts/             # Fuentes utilizadas en la interfaz
│   ├── images/            # Imágenes, iconos y recursos gráficos
│   ├── Js/                # Scripts JavaScript y plugins
│   ├── plantillas/        # Plantillas PDF para reportes y permisos
│   └── scss/              # Archivos fuente SCSS para estilos
├── Config/                # Archivos de configuración del sistema
├── Controllers/           # Controladores principales del sistema (MVC)
│   └── Inventario/        # Controladores específicos del módulo de inventario
├── Helpers/               # Funciones auxiliares y utilidades
├── Libraries/             # Librerías internas y núcleo del sistema
│   └── Core/              # Componentes base del framework
├── Models/                # Modelos de datos y acceso a la base de datos
│   └── Inventario/        # Modelos específicos del módulo de inventario
├── Public/                # Archivos públicos, instaladores y scripts SQL
│   ├── composer/          # Instalador de Composer y configuración PHP
│   ├── sql/               # Scripts para la creación e importación de la base de datos
│   └── templates/         # Documentación y plantillas públicas
├── Views/                 # Vistas y plantillas HTML/PHP para la interfaz de usuario
│   ├── Inventario/        # Vistas del módulo de inventario
│   ├── Template/          # Componentes comunes (header, footer, modals)
│   └── ...                # Vistas de otros módulos (Dashboard, Login, etc.)
├── uploads/               # Archivos subidos por los usuarios (perfiles, documentos, etc.)
│   ├── archivos/
│   ├── auditoria/
│   ├── perfiles/
│   └── ...
├── vendor/                # Dependencias externas (instaladas por Composer)
├── index.php              # Punto de entrada principal de la aplicación
├── composer.json          # Dependencias PHP del proyecto
├── LICENSE                # Licencia del proyecto
├── README.md              # Documentación principal
└── es.json                # Archivo de traducción al español
```

### Descripción de carpetas principales

- **Assets/**: Contiene todos los recursos estáticos como hojas de estilo, scripts JS, imágenes, fuentes y plantillas PDF.
- **Config/**: Archivos de configuración global del sistema, como la conexión a la base de datos.
- **Controllers/**: Lógica de control de cada módulo, siguiendo el patrón MVC.
- **Helpers/**: Funciones auxiliares reutilizables en todo el sistema.
- **Libraries/Core/**: Componentes base del framework propio, como el autoload, conexión, y gestión de vistas/controladores.
- **Models/**: Acceso y manipulación de datos en la base de datos.
- **Public/**: Archivos públicos, instaladores, scripts SQL y documentación.
- **Views/**: Plantillas y vistas para la interfaz de usuario, organizadas por módulo.
- **uploads/**: Carpeta para archivos subidos por los usuarios, como documentos, imágenes de perfil, etc.
- **vendor/**: Dependencias externas instaladas mediante Composer.
- **index.php**: Archivo principal que inicia la aplicación.
- **es.json**: Archivo de traducción para internacionalización.

---

## ⚙️ Requisitos para ejecutar

1. Tener instalado [XAMPP](https://www.apachefriends.org/) o un entorno compatible con PHP y MySQL
2. Clonar o descargar este repositorio
3. Crear una base de datos en MySQL y configurar la conexión en `Config/Config.php`
4. Importar el archivo `.sql` correspondiente desde `Public/sql/`
5. Iniciar Apache y MySQL desde XAMPP
6. Asegurarse de que la carpeta `uploads/` tenga permisos de escritura
7. Acceder desde `http://localhost/samicam/` en tu navegador

---

## 🧑‍💻 Autor

**SAMI-CAM** es un proyecto desarrollado como solución para la administración interna del CAM.  
Diseñado para ser intuitivo, modular y extensible para futuras integraciones.

---

## 📌 Notas

- Este sistema puede adaptarse fácilmente a otros entornos municipales o administrativos.
- Las rutas, controladores y vistas están organizados siguiendo una estructura MVC para facilitar su mantenimiento y escalabilidad.
- Para soporte o contribuciones, contacta al desarrollador principal o abre un issue en el repositorio.

---

