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

---

## 🛠️ Tecnologías Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap
- **Backend:** PHP (con estructura MVC)
- **Base de Datos:** MySQL
- **Servidor local:** XAMPP

---

## 🗂️ Estructura del Proyecto

SAMICAM
├── Assets
│   ├── css
│   │   ├── selectpicker
│   │   │   ├── picker.css
│   │   │   └── picker.min.css
│   │   ├── main.css
│   │   ├── main.min.css
│   │   ├── samicam.css
│   │   ├── styles_login.css
│   │   └── styles.css
│   ├── images
│   └── js
│       ├── plugins
│       │   ├── chart.js
│       │   ├── jquery.dataTables.min.js
│       │   └── sweetalert.min.js
│       ├── selectpicker
│       │   ├── picker.js
│       │   └── picker.min.js
│       ├── animations_login.js
│       ├── bootstrap.min.js
│       ├── functions_dashboard.js
│       ├── functions_login.js
│       ├── functions_roles.js
│       ├── functions_usuarios.js
│       ├── hola-login.js
│       ├── jquery-3.7.0.min.js
│       ├── main.js
│       ├── overlay-quieto.js
│       ├── popper.min.js
│       └── ver-contrasena-login.js
├── Config
│   └── Config.php
├── Controllers
│   ├── Dashboard.php
│   ├── Error.php
│   ├── FuncionariosOps.php
│   ├── FuncionariosPermisos.php
│   ├── FuncionariosPlantas.php
│   ├── FuncionariosViaticos.php
│   ├── Login.php
│   ├── Logout.php
│   ├── Permisos.php
│   ├── Roles.php
│   └── Usuarios.php
├── Helpers
│   └── helpers.php
├── Libraries
├── Core
│   ├── Autoload.php
│   ├── Conexion.php
│   ├── Controllers.php
│   ├── Load.php
│   ├── Mysql.php
│   └── Views.php
├── Models
│   ├── DashboardModel.php
│   ├── LoginModel.php
│   ├── PermisosModel.php
│   ├── RolesModel.php
│   └── UsuariosModel.php
├── Views
│   ├── Dashboard
│   ├── Errors
│   ├── FuncionariosOps
│   ├── FuncionariosPermisos
│   ├── FuncionariosPlanta
│   ├── FuncionariosViaticos
│   ├── Login
│   ├── Roles
│   └── Template
│       ├── Modals
│       │   ├── footer_admin.php
│       │   └── header_admin.php
│       └── main_admin.php
├── Usuarios
├── index.php
├── .gitattributes
├── .htaccess
├── .editorconfig
├── index.php
├── LICENSE
└── README.md


---

## ⚙️ Requisitos para ejecutar

1. Tener instalado [XAMPP](https://www.apachefriends.org/)
2. Clonar o descargar este repositorio
3. Crear una base de datos en MySQL y configurar la conexión en `config/config.php`
4. Importar el archivo `.sql` correspondiente si está disponible
5. Iniciar Apache y MySQL desde XAMPP
6. Acceder desde `http://localhost/samicam/` en tu navegador

---

## 🧑‍💻 Autor

**SAMI-CAM** es un proyecto desarrollado como solución para la administración interna del CAM.  
Diseñado para ser intuitivo, modular y extensible para futuras integraciones.

---

## 📌 Notas

- Este sistema puede adaptarse fácilmente a otros entornos municipales o administrativos.
- Las rutas, controladores y vistas están organizados siguiendo una estructura MVC para facilitar su mantenimiento y escalabilidad.

---

