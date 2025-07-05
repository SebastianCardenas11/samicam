<?php include 'layout/headerManual.php'; ?>
<div class="flex flex-col md:flex-row container mx-auto px-4 py-6">
    <?php include 'layout/navbarMManual.php'; ?>
    <main class="flex-1 bg-white rounded-lg shadow-md p-6">
        <!-- Sistema de notificaciones -->
        <?php if (isset($_GET['error']) && $_GET['error'] == 'archivo_no_encontrado'): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">
                            <strong>Error:</strong> El archivo PDF del manual no está disponible en este momento. Por favor, contacte al administrador del sistema.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success']) && $_GET['success'] == 'descarga_exitosa'): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">
                            <strong>Éxito:</strong> El manual PDF se ha descargado correctamente. Revise su carpeta de descargas.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Panel dinámico para mostrar la explicación del módulo seleccionado -->
        <div id="detalleModulo" class="mb-8">
            <h2 class="text-2xl font-bold mb-4 text-blue-800">Bienvenido al Manual de Usuario</h2>
            <p class="text-gray-700">Selecciona un módulo en el menú lateral para ver su explicación detallada aquí.</p>
        </div>
        <!-- El resto del manual queda oculto por defecto -->
        <div id="manualCompleto" style="display:none;">
            <!-- Botón para volver al panel dinámico -->
            <button id="btnVolverDetalle" class="mb-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                <i class="fas fa-arrow-left mr-2"></i>Volver al panel de módulos
            </button>
            <!-- Introducción -->
            <section id="introduccion" class="mb-12">
                <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">1. Introducción al Sistema SAMICAM</h2>
                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <p class="text-blue-800"><strong>Objetivo:</strong> El Sistema de Administración Municipal Integrado (SAMICAM) es una plataforma web diseñada para optimizar y centralizar los procesos administrativos del municipio, facilitando la gestión de recursos humanos, materiales y documentación.</p>
                </div>
                
                <h3 class="text-xl font-semibold mb-3 text-gray-700">1.1 Características Principales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-users-cog text-blue-600 mr-2"></i>
                            <h4 class="font-medium">Gestión de Personal</h4>
                        </div>
                        <p class="text-sm text-gray-600">Administración completa de funcionarios, permisos, vacaciones y viáticos.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-boxes text-blue-600 mr-2"></i>
                            <h4 class="font-medium">Control de Inventario</h4>
                        </div>
                        <p class="text-sm text-gray-600">Registro y seguimiento de equipos tecnológicos y suministros.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-tasks text-blue-600 mr-2"></i>
                            <h4 class="font-medium">Gestión de Tareas</h4>
                        </div>
                        <p class="text-sm text-gray-600">Asignación y seguimiento de actividades y proyectos.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                            <h4 class="font-medium">Documentación</h4>
                        </div>
                        <p class="text-sm text-gray-600">Almacenamiento y organización de archivos municipales.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                            <h4 class="font-medium">Reportes y Estadísticas</h4>
                        </div>
                        <p class="text-sm text-gray-600">Generación de informes y análisis de datos.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-bell text-blue-600 mr-2"></i>
                            <h4 class="font-medium">Notificaciones</h4>
                        </div>
                        <p class="text-sm text-gray-600">Sistema de alertas y comunicaciones internas.</p>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mb-3 text-gray-700">1.2 Requisitos del Sistema</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b">Componente</th>
                                <th class="py-2 px-4 border-b">Requisito Mínimo</th>
                                <th class="py-2 px-4 border-b">Recomendado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b">Navegador Web</td>
                                <td class="py-2 px-4 border-b">Chrome 80+, Firefox 74+, Edge 80+</td>
                                <td class="py-2 px-4 border-b">Última versión estable</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="py-2 px-4 border-b">Sistema Operativo</td>
                                <td class="py-2 px-4 border-b">Windows 8.1, macOS 10.13, Linux</td>
                                <td class="py-2 px-4 border-b">Windows 10/11, macOS 12+, Ubuntu 20.04+</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b">Resolución Pantalla</td>
                                <td class="py-2 px-4 border-b">1366x768</td>
                                <td class="py-2 px-4 border-b">1920x1080 o superior</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="py-2 px-4 border-b">Conexión Internet</td>
                                <td class="py-2 px-4 border-b">5 Mbps</td>
                                <td class="py-2 px-4 border-b">10 Mbps o superior</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Acceso al Sistema -->
            <section id="acceso" class="mb-12">
                <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">2. Acceso al Sistema</h2>
                
                <div class="mb-6">
                    <p class="text-gray-700 mb-4">
                        El acceso al sistema SAMICAM se realiza a través de un proceso de autenticación seguro que garantiza 
                        que solo usuarios autorizados puedan acceder a la información y funcionalidades correspondientes a su rol.
                    </p>
                </div>

                <h3 class="text-xl font-semibold mb-3 text-gray-700">2.1 Pantalla de Inicio de Sesión</h3>
                <div class="flex flex-col md:flex-row gap-6 mb-6">
                    <div class="md:w-1/2">
                        <img src="https://via.placeholder.com/600x400?text=Captura+Login+SAMICAM" alt="Pantalla de Login" class="w-full rounded-lg screenshot mb-4">
                        <div class="text-sm text-gray-500 text-center">Figura 1: Pantalla de inicio de sesión de SAMICAM</div>
                    </div>
                    <div class="md:w-1/2">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-medium mb-2 text-gray-700">Elementos de la pantalla:</h4>
                            <ol class="list-decimal pl-5 space-y-2">
                                <li><strong>Logo Institucional:</strong> Identificación visual de la Alcaldía</li>
                                <li><strong>Campo Correo:</strong> Ingrese su correo electrónico institucional</li>
                                <li><strong>Campo Contraseña:</strong> Ingrese su contraseña (sensible a mayúsculas)</li>
                                <li><strong>Botón "Iniciar Sesión":</strong> Valida las credenciales e ingresa al sistema</li>
                                <li><strong>Enlace "¿Olvidó su contraseña?":</strong> Inicia proceso de recuperación</li>
                                <li><strong>Información de Contacto:</strong> Datos de soporte técnico</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mb-3 text-gray-700">2.2 Proceso de Autenticación</h3>
                <div class="mb-6">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-yellow-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Nota:</strong> Después de 3 intentos fallidos, su cuenta será bloqueada temporalmente por 30 minutos.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">1</span>
                                Ingreso de Credenciales
                            </h4>
                            <p class="text-sm text-gray-600">Introduzca su correo electrónico institucional y contraseña en los campos correspondientes. Asegúrese de que el teclado no tenga activado el bloqueo de mayúsculas.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">2</span>
                                Validación de Datos
                            </h4>
                            <p class="text-sm text-gray-600">El sistema valida que los campos no estén vacíos y que el formato del correo sea correcto antes de procesar la autenticación.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">3</span>
                                Autenticación
                            </h4>
                            <p class="text-sm text-gray-600">Al hacer clic en "Iniciar Sesión", el sistema valida sus credenciales contra la base de datos. Si son correctas, será redirigido al Dashboard principal.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">4</span>
                                Registro de Auditoría
                            </h4>
                            <p class="text-sm text-gray-600">El sistema registra automáticamente el inicio de sesión en los logs de auditoría con información de IP, navegador y timestamp.</p>
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mb-3 text-gray-700">2.3 Tipos de Usuarios y Accesos</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b text-left">Rol de Usuario</th>
                                <th class="py-2 px-4 border-b text-left">Acceso a Módulos</th>
                                <th class="py-2 px-4 border-b text-left">Permisos Especiales</th>
                                <th class="py-2 px-4 border-b text-left">Restricciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b font-medium">Superadministrador</td>
                                <td class="py-2 px-4 border-b text-sm">Todos los módulos</td>
                                <td class="py-2 px-4 border-b text-sm">Auditoría, Configuración del sistema</td>
                                <td class="py-2 px-4 border-b text-sm">Ninguna</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="py-2 px-4 border-b font-medium">Administrador</td>
                                <td class="py-2 px-4 border-b text-sm">Gestión de usuarios, reportes</td>
                                <td class="py-2 px-4 border-b text-sm">Crear/editar usuarios, asignar roles</td>
                                <td class="py-2 px-4 border-b text-sm">No puede acceder a auditoría</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b font-medium">Coordinador</td>
                                <td class="py-2 px-4 border-b text-sm">Módulos específicos asignados</td>
                                <td class="py-2 px-4 border-b text-sm">Aprobar solicitudes, generar reportes</td>
                                <td class="py-2 px-4 border-b text-sm">Solo módulos autorizados</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="py-2 px-4 border-b font-medium">Usuario Regular</td>
                                <td class="py-2 px-4 border-b text-sm">Módulos básicos</td>
                                <td class="py-2 px-4 border-b text-sm">Consultar información</td>
                                <td class="py-2 px-4 border-b text-sm">Solo lectura en la mayoría</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="text-xl font-semibold mb-3 text-gray-700">2.4 Seguridad y Validaciones</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                        <h4 class="font-medium mb-2 text-red-700">Medidas de Seguridad</h4>
                        <ul class="text-sm text-red-600 space-y-1">
                            <li>• Contraseñas encriptadas con SHA-256</li>
                            <li>• Bloqueo temporal tras intentos fallidos</li>
                            <li>• Registro de IP y navegador</li>
                            <li>• Sesiones con timeout automático</li>
                            <li>• Protección contra inyección SQL</li>
                        </ul>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                        <h4 class="font-medium mb-2 text-green-700">Validaciones del Sistema</h4>
                        <ul class="text-sm text-green-600 space-y-1">
                            <li>• Formato de correo electrónico</li>
                            <li>• Campos obligatorios</li>
                            <li>• Longitud mínima de contraseña</li>
                            <li>• Estado activo del usuario</li>
                            <li>• Permisos de acceso por rol</li>
                        </ul>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mb-3 text-gray-700">2.5 Recuperación de Acceso</h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h4 class="font-medium mb-2 text-blue-700">Proceso de Recuperación de Contraseña</h4>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm mt-0.5">1</span>
                            <div>
                                <p class="text-sm text-blue-700 font-medium">Haga clic en "¿Olvidó su contraseña?"</p>
                                <p class="text-xs text-blue-600">Se abrirá un formulario de recuperación</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm mt-0.5">2</span>
                            <div>
                                <p class="text-sm text-blue-700 font-medium">Ingrese su correo electrónico</p>
                                <p class="text-xs text-blue-600">Debe ser el correo registrado en el sistema</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm mt-0.5">3</span>
                            <div>
                                <p class="text-sm text-blue-700 font-medium">Reciba instrucciones por correo</p>
                                <p class="text-xs text-blue-600">Se enviará un enlace temporal para restablecer la contraseña</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm mt-0.5">4</span>
                            <div>
                                <p class="text-sm text-blue-700 font-medium">Establezca nueva contraseña</p>
                                <p class="text-xs text-blue-600">El enlace expira en 24 horas por seguridad</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-lightbulb text-yellow-500 mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                <strong>Consejo:</strong> Para mayor seguridad, utilice contraseñas complejas que incluyan mayúsculas, 
                                minúsculas, números y caracteres especiales. Cambie su contraseña regularmente y no la comparta con otros usuarios.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Interfaz de Usuario -->
            <section id="interfaz" class="mb-12">
                <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">3. Interfaz de Usuario</h2>
                
                <h3 class="text-xl font-semibold mb-3 text-gray-700">3.1 Estructura General</h3>
                <div class="flex flex-col md:flex-row gap-6 mb-6">
                    <div class="md:w-2/3">
                        <img src="https://via.placeholder.com/800x500?text=Interfaz+Principal+SAMICAM" alt="Interfaz Principal" class="w-full rounded-lg screenshot mb-4">
                        <div class="text-sm text-gray-500 text-center">Figura 2: Estructura general de la interfaz SAMICAM</div>
                    </div>
                    <div class="md:w-1/3">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-medium mb-2 text-gray-700">Componentes principales:</h4>
                            <ol class="list-decimal pl-5 space-y-2">
                                <li><strong>Barra Superior:</strong> Menú rápido, notificaciones y perfil</li>
                                <li><strong>Menú Lateral:</strong> Navegación entre módulos</li>
                                <li><strong>Área de Trabajo:</strong> Contenido principal del módulo</li>
                                <li><strong>Ruta de Navegación (Breadcrumbs):</strong> Ubicación actual</li>
                                <li><strong>Barra de Estado:</strong> Información del sistema</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mb-3 text-gray-700">3.2 Elementos Comunes y Botones</h3>
                
                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Botones de Acción Principales</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-blue-600 text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-plus mr-2"></i> Nuevo
                            </button>
                            <p class="text-xs text-center text-gray-600">Abre formulario para crear nuevo registro</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-edit mr-2"></i> Editar
                            </button>
                            <p class="text-xs text-center text-gray-600">Modifica el registro seleccionado</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-red-500 text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-trash mr-2"></i> Eliminar
                            </button>
                            <p class="text-xs text-center text-gray-600">Elimina el registro (con confirmación)</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-green-500 text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-save mr-2"></i> Guardar
                            </button>
                            <p class="text-xs text-center text-gray-600">Guarda los cambios del formulario</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Botones de Acción Específicos</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-info text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-eye mr-2"></i> Ver
                            </button>
                            <p class="text-xs text-center text-gray-600">Visualiza detalles del registro</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-primary text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-clock mr-2"></i> Prórroga
                            </button>
                            <p class="text-xs text-center text-gray-600">Extiende plazo de contratos</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-success text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-plus-circle mr-2"></i> Adición
                            </button>
                            <p class="text-xs text-center text-gray-600">Agrega valor a contratos</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-warning text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i> Especial
                            </button>
                            <p class="text-xs text-center text-gray-600">Permisos especiales</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Botones de Navegación y Utilidades</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-secondary text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-download mr-2"></i> Exportar
                            </button>
                            <p class="text-xs text-center text-gray-600">Descarga datos en Excel/PDF</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-info text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-search mr-2"></i> Buscar
                            </button>
                            <p class="text-xs text-center text-gray-600">Filtra registros</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-dark text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-print mr-2"></i> Imprimir
                            </button>
                            <p class="text-xs text-center text-gray-600">Genera reportes</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-danger text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-times mr-2"></i> Cancelar
                            </button>
                            <p class="text-xs text-center text-gray-600">Cierra formularios</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Validaciones y Mensajes</h4>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Campos Obligatorios:</strong> Los campos marcados con <span class="text-red-500">*</span> son obligatorios y deben completarse antes de guardar.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-2"></i> Mensajes de Éxito
                            </h5>
                            <p class="text-sm text-gray-600">Aparecen en verde cuando una operación se completa correctamente.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Mensajes de Error
                            </h5>
                            <p class="text-sm text-gray-600">Aparecen en rojo cuando hay problemas o validaciones fallidas.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Seguimiento de Contratos -->
            <section id="contratos" class="mb-8">
                <h3 class="text-xl font-semibold mb-3 text-gray-700">4.5 Seguimiento de Contratos</h3>
                <div class="bg-blue-50 p-4 rounded-lg mb-4">
                    <p class="text-blue-800"><strong>Propósito:</strong> Este módulo permite gestionar todos los contratos municipales, incluyendo su creación, modificación, prórrogas, adiciones y cambio de estados con validaciones automáticas y controles de límites.</p>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Características del Sistema</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-file-contract text-blue-600 mr-2"></i>
                                <h5 class="font-medium">Gestión Completa</h5>
                            </div>
                            <p class="text-sm text-gray-600">Creación, edición y seguimiento de contratos</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-clock text-orange-600 mr-2"></i>
                                <h5 class="font-medium">Prórrogas</h5>
                            </div>
                            <p class="text-sm text-gray-600">Extensión de plazos con validaciones</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-plus-circle text-green-600 mr-2"></i>
                                <h5 class="font-medium">Adiciones</h5>
                            </div>
                            <p class="text-sm text-gray-600">Incrementos de valor (máximo 50%)</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-chart-line text-purple-600 mr-2"></i>
                                <h5 class="font-medium">Estados</h5>
                            </div>
                            <p class="text-sm text-gray-600">Control de ciclo de vida del contrato</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Tabla de Contratos</h4>
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b">N° Contrato</th>
                                    <th class="py-2 px-4 border-b">Dependencia</th>
                                    <th class="py-2 px-4 border-b">Objeto</th>
                                    <th class="py-2 px-4 border-b">Valor</th>
                                    <th class="py-2 px-4 border-b">Estado</th>
                                    <th class="py-2 px-4 border-b">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b">CT-2023-001</td>
                                    <td class="py-2 px-4 border-b">Obras Públicas</td>
                                    <td class="py-2 px-4 border-b">Construcción vial</td>
                                    <td class="py-2 px-4 border-b">$15,000,000</td>
                                    <td class="py-2 px-4 border-b"><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">En ejecución</span></td>
                                    <td class="py-2 px-4 border-b">
                                        <button class="text-blue-600 hover:text-blue-800 mr-2" title="Ver Contrato"><i class="fas fa-eye"></i></button>
                                        <button class="text-yellow-600 hover:text-yellow-800 mr-2" title="Editar"><i class="fas fa-edit"></i></button>
                                        <button class="text-primary hover:text-primary-dark mr-2" title="Prórroga"><i class="fas fa-clock"></i></button>
                                        <button class="text-success hover:text-success-dark mr-2" title="Adición"><i class="fas fa-plus-circle"></i></button>
                                        <button class="text-info hover:text-info-dark" title="Más Opciones"><i class="fas fa-ellipsis-v"></i></button>
                                    </td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b">CT-2023-002</td>
                                    <td class="py-2 px-4 border-b">Educación</td>
                                    <td class="py-2 px-4 border-b">Mantenimiento equipos</td>
                                    <td class="py-2 px-4 border-b">$8,500,000</td>
                                    <td class="py-2 px-4 border-b"><span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Finalizado</span></td>
                                    <td class="py-2 px-4 border-b">
                                        <button class="text-blue-600 hover:text-blue-800 mr-2" title="Ver Contrato"><i class="fas fa-eye"></i></button>
                                        <button class="text-info hover:text-info-dark" title="Más Opciones"><i class="fas fa-ellipsis-v"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Botones de Acción Específicos</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium text-blue-700 mb-2 flex items-center">
                                <i class="fas fa-eye text-blue-600 mr-2"></i> Ver Contrato
                            </h5>
                            <p class="text-sm text-gray-600 mb-2">Visualiza todos los detalles del contrato.</p>
                            <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                <li>Información completa del contrato</li>
                                <li>Historial de modificaciones</li>
                                <li>Documentos adjuntos</li>
                                <li>Estado actual y fechas importantes</li>
                            </ul>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium text-yellow-700 mb-2 flex items-center">
                                <i class="fas fa-edit text-yellow-600 mr-2"></i> Editar Contrato
                            </h5>
                            <p class="text-sm text-gray-600 mb-2">Modifica la información del contrato.</p>
                            <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                <li>Solo disponible si no está liquidado</li>
                                <li>Permite cambiar datos básicos</li>
                                <li>Mantiene historial de cambios</li>
                                <li>Requiere confirmación</li>
                            </ul>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium text-primary-700 mb-2 flex items-center">
                                <i class="fas fa-clock text-primary-600 mr-2"></i> Prórroga
                            </h5>
                            <p class="text-sm text-gray-600 mb-2">Extiende el plazo de terminación del contrato.</p>
                            <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                <li>Nueva fecha debe ser posterior a la actual</li>
                                <li>Calcula automáticamente días de diferencia</li>
                                <li>Requiere motivo de la prórroga</li>
                                <li>Mantiene historial de prórrogas</li>
                            </ul>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium text-success-700 mb-2 flex items-center">
                                <i class="fas fa-plus-circle text-success-600 mr-2"></i> Adición
                            </h5>
                            <p class="text-sm text-gray-600 mb-2">Incrementa el valor del contrato.</p>
                            <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                <li>Máximo 50% del valor original</li>
                                <li>Valida límites automáticamente</li>
                                <li>Muestra gráfico de disponibilidad</li>
                                <li>Requiere justificación</li>
                            </ul>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium text-info-700 mb-2 flex items-center">
                                <i class="fas fa-ellipsis-v text-info-600 mr-2"></i> Más Opciones
                            </h5>
                            <p class="text-sm text-gray-600 mb-2">Acceso a funcionalidades adicionales.</p>
                            <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                <li>Historial de prórrogas</li>
                                <li>Historial de adiciones</li>
                                <li>Cambiar estado</li>
                                <li>Exportar información</li>
                            </ul>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium text-danger-700 mb-2 flex items-center">
                                <i class="fas fa-trash text-danger-600 mr-2"></i> Eliminar
                            </h5>
                            <p class="text-sm text-gray-600 mb-2">Elimina el contrato del sistema.</p>
                            <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                <li>Solo disponible si no está liquidado</li>
                                <li>Requiere confirmación doble</li>
                                <li>Elimina registros relacionados</li>
                                <li>Acción irreversible</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Estados del Contrato</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-2">
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs mr-2">En ejecución</span>
                                <h5 class="font-medium">En Ejecución</h5>
                            </div>
                            <p class="text-sm text-gray-600">Contrato activo y en desarrollo. Permite todas las operaciones.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-2">
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs mr-2">Finalizado</span>
                                <h5 class="font-medium">Finalizado</h5>
                            </div>
                            <p class="text-sm text-gray-600">Contrato completado. Solo permite visualización.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-2">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mr-2">Liquidado</span>
                                <h5 class="font-medium">Liquidado</h5>
                            </div>
                            <p class="text-sm text-gray-600">Contrato liquidado. No permite modificaciones.</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Validaciones y Límites</h4>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Límite de Adiciones:</strong> El valor total de las adiciones no puede exceder el 50% del valor original del contrato. El sistema valida automáticamente este límite.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium mb-2 text-gray-700">Validaciones de Prórroga</h5>
                            <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                                <li>Nueva fecha debe ser posterior a la actual</li>
                                <li>Calcula automáticamente días de diferencia</li>
                                <li>Requiere motivo obligatorio</li>
                                <li>Mantiene historial completo</li>
                            </ul>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium mb-2 text-gray-700">Validaciones de Adición</h5>
                            <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                                <li>Máximo 50% del valor original</li>
                                <li>Valida suma de adiciones anteriores</li>
                                <li>Muestra disponibilidad restante</li>
                                <li>Requiere justificación detallada</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Gráficos y Estadísticas</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium text-blue-700 mb-2">Contratos por Mes</h5>
                            <p class="text-sm text-gray-600 mb-2">Gráfico combinado que muestra contratos y valores por mes.</p>
                            <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                <li>Barras: Cantidad de contratos</li>
                                <li>Línea: Valor total</li>
                                <li>Permite exportar imagen</li>
                                <li>Filtros por período</li>
                            </ul>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h5 class="font-medium text-green-700 mb-2">Valores por Estado</h5>
                            <p class="text-sm text-gray-600 mb-2">Gráfico de barras apiladas por estado del contrato.</p>
                            <ul class="list-disc pl-5 text-xs text-gray-600 space-y-1">
                                <li>Distribución por estado</li>
                                <li>Valores totales</li>
                                <li>Comparación visual</li>
                                <li>Exportación disponible</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Solución de Problemas -->
            <section id="problemas" class="mb-12">
                <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">5. Solución de Problemas</h2>
                
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-3 text-gray-700">5.1 Problemas Comunes y Soluciones</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Problema</th>
                                    <th class="py-2 px-4 border-b text-left">Causa Posible</th>
                                    <th class="py-2 px-4 border-b text-left">Solución</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b">No puedo iniciar sesión</td>
                                    <td class="py-2 px-4 border-b">Credenciales incorrectas, cuenta bloqueada</td>
                                    <td class="py-2 px-4 border-b">
                                        <ol class="list-decimal pl-5 text-sm">
                                            <li>Verifique que el bloqueo de mayúsculas no esté activado</li>
                                            <li>Use el enlace "¿Olvidó su contraseña?"</li>
                                            <li>Contacte al administrador si persiste</li>
                                        </ol>
                                    </td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b">No tengo acceso a un módulo</td>
                                    <td class="py-2 px-4 border-b">Falta de permisos asignados</td>
                                    <td class="py-2 px-4 border-b">
                                        <ol class="list-decimal pl-5 text-sm">
                                            <li>Verifique con su supervisor que su rol tenga los permisos necesarios</li>
                                            <li>Solicite al administrador la habilitación del módulo</li>
                                        </ol>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b">El sistema funciona lento</td>
                                    <td class="py-2 px-4 border-b">Conexión a internet lenta, muchos usuarios conectados</td>
                                    <td class="py-2 px-4 border-b">
                                        <ol class="list-decimal pl-5 text-sm">
                                            <li>Verifique su conexión a internet</li>
                                            <li>Intente recargar la página (F5)</li>
                                            <li>Evite usar en horas peak si no es urgente</li>
                                        </ol>
                                    </td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b">No puedo guardar un formulario</td>
                                    <td class="py-2 px-4 border-b">Campos obligatorios incompletos, formato incorrecto</td>
                                    <td class="py-2 px-4 border-b">
                                        <ol class="list-decimal pl-5 text-sm">
                                            <li>Verifique que todos los campos marcados con * estén completos</li>
                                            <li>Revise que los datos ingresados tengan el formato correcto</li>
                                            <li>Intente nuevamente después de corregir los errores</li>
                                        </ol>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-3 text-gray-700">5.2 Contacto de Soporte</h3>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-blue-700 mb-2 flex items-center">
                                    <i class="fas fa-phone-alt mr-2"></i> Teléfono
                                </h4>
                                <p class="text-sm">+56 2 2345 6789</p>
                                <p class="text-xs text-gray-500">Lunes a Viernes, 9:00 - 18:00 hrs</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-blue-700 mb-2 flex items-center">
                                    <i class="fas fa-envelope mr-2"></i> Correo
                                </h4>
                                <p class="text-sm">soporte.samicam@municipalidad.cl</p>
                                <p class="text-xs text-gray-500">Respuesta en 24 horas hábiles</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium text-blue-700 mb-2 flex items-center">
                                    <i class="fas fa-ticket-alt mr-2"></i> Ticket en Línea
                                </h4>
                                <p class="text-sm">Sistema de tickets en <a href="#" class="text-blue-600 hover:underline">Ayuda SAMICAM</a></p>
                                <p class="text-xs text-gray-500">Seguimiento de solicitudes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Glosario -->
            <section id="glosario" class="mb-12">
                <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">6. Glosario de Términos</h2>
                
                <div class="mb-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Término</th>
                                    <th class="py-2 px-4 border-b text-left">Definición</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">OPS</td>
                                    <td class="py-2 px-4 border-b">Obras de Provisión de Servicios. Funcionarios contratados por honorarios o a plazo fijo.</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Planta</td>
                                    <td class="py-2 px-4 border-b">Funcionarios con nombramiento permanente en la municipalidad.</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Viáticos</td>
                                    <td class="py-2 px-4 border-b">Gastos de movilización y alimentación asociados a comisiones de servicio.</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Dependencia</td>
                                    <td class="py-2 px-4 border-b">Unidad o departamento municipal al que pertenece un funcionario.</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Rol</td>
                                    <td class="py-2 px-4 border-b">Conjunto de permisos que determinan qué acciones puede realizar un usuario en el sistema.</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Breadcrumbs</td>
                                    <td class="py-2 px-4 border-b">Ruta de navegación que muestra la ubicación actual dentro del sistema.</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Dashboard</td>
                                    <td class="py-2 px-4 border-b">Panel principal que muestra información resumida y estadísticas relevantes.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </main>
</div>

<!-- Floating Help Button -->
<div class="fixed bottom-6 right-6">
    <button id="helpButton" class="bg-blue-600 text-white rounded-full p-4 shadow-lg hover:bg-blue-700 transition duration-200 flex items-center justify-center">
        <i class="fas fa-question text-xl"></i>
    </button>
    <div id="helpMenu" class="hidden absolute bottom-full right-0 mb-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
        <div class="p-4">
            <h4 class="font-medium text-gray-800 mb-2">¿Necesita ayuda?</h4>
            <ul class="space-y-2">
                <li><a href="#" class="block px-2 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">Documentación Completa</a></li>
                <li><a href="#" class="block px-2 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">Video Tutoriales</a></li>
                <li><a href="#" class="block px-2 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">Contactar Soporte</a></li>
                <li><a href="#" class="block px-2 py-1 text-sm text-blue-600 hover:bg-blue-50 rounded">Preguntas Frecuentes</a></li>
            </ul>
        </div>
    </div>
</div>

<script>
    // Toggle help menu
    document.getElementById('helpButton').addEventListener('click', function() {
        const menu = document.getElementById('helpMenu');
        menu.classList.toggle('hidden');
    });

    // Close help menu when clicking outside
    document.addEventListener('click', function(event) {
        const helpButton = document.getElementById('helpButton');
        const helpMenu = document.getElementById('helpMenu');
        
        if (!helpButton.contains(event.target) && !helpMenu.contains(event.target)) {
            helpMenu.classList.add('hidden');
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
                
                // Add highlight class to section
                document.querySelectorAll('.highlight').forEach(el => {
                    el.classList.remove('highlight');
                });
                targetElement.classList.add('highlight');
                
                // Remove highlight after 3 seconds
                setTimeout(() => {
                    targetElement.classList.remove('highlight');
                }, 3000);
            }
        });
    });

    // Tooltip functionality
    document.querySelectorAll('.tooltip').forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = this.querySelector('.tooltiptext');
            tooltip.style.visibility = 'visible';
            tooltip.style.opacity = '1';
        });
        element.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('.tooltiptext');
            tooltip.style.visibility = 'hidden';
            tooltip.style.opacity = '0';
        });
    });

    // Explicaciones de cada módulo
    const modulos = {
        interfaz: {
            titulo: 'Interfaz de Usuario',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Interfaz de Usuario</h2>
            <p class='mb-4'>La interfaz de usuario de SAMICAM está diseñada para ser intuitiva y eficiente. Aquí se explican los elementos y botones más comunes que encontrarás en los módulos CRUD (Crear, Leer, Actualizar, Eliminar) y en los formularios modales.</p>
            <div class='mb-6'>
                <h3 class='font-semibold mb-2 text-gray-700'>Botones CRUD principales</h3>
                <div class='grid grid-cols-2 md:grid-cols-4 gap-4 mb-4'>
                    <div class='bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center'>
                        <button class='bg-blue-600 text-white px-4 py-2 rounded mb-2 flex items-center'><i class='fas fa-plus mr-2'></i> Nuevo</button>
                        <p class='text-xs text-center text-gray-600'>Abre un formulario modal para crear un nuevo registro.</p>
                    </div>
                    <div class='bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center'>
                        <button class='bg-yellow-500 text-white px-4 py-2 rounded mb-2 flex items-center'><i class='fas fa-edit mr-2'></i> Editar</button>
                        <p class='text-xs text-center text-gray-600'>Permite modificar el registro seleccionado.</p>
                    </div>
                    <div class='bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center'>
                        <button class='bg-red-500 text-white px-4 py-2 rounded mb-2 flex items-center'><i class='fas fa-trash mr-2'></i> Eliminar</button>
                        <p class='text-xs text-center text-gray-600'>Elimina el registro (requiere confirmación).</p>
                    </div>
                    <div class='bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center'>
                        <button class='bg-green-500 text-white px-4 py-2 rounded mb-2 flex items-center'><i class='fas fa-save mr-2'></i> Guardar</button>
                        <p class='text-xs text-center text-gray-600'>Guarda los cambios realizados en el formulario.</p>
                    </div>
                </div>
            </div>
            <div class='mb-6'>
                <h3 class='font-semibold mb-2 text-gray-700'>Botones y elementos de los modales</h3>
                <ul class='list-disc pl-5 text-gray-700 mb-2'>
                    <li><b>Botón Cerrar:</b> Cierra el modal sin guardar cambios.</li>
                    <li><b>Botón Guardar:</b> Envía el formulario del modal y guarda la información.</li>
                    <li><b>Validaciones:</b> Los campos obligatorios están marcados con <span class='text-red-500'>*</span> y muestran mensajes de error si faltan datos.</li>
                    <li><b>Mensajes de éxito/error:</b> Aparecen en la parte superior del modal o como notificaciones flotantes.</li>
                </ul>
            </div>
            <div class='mb-6'>
                <h3 class='font-semibold mb-2 text-gray-700'>Otros elementos comunes</h3>
                <ul class='list-disc pl-5 text-gray-700'>
                    <li><b>Tablas de datos:</b> Permiten ordenar, buscar y exportar información.</li>
                    <li><b>Campos de formulario:</b> Texto, numérico, fecha, selectores y áreas de texto.</li>
                    <li><b>Iconos de acción:</b> <i class='fas fa-eye text-blue-600'></i> Ver, <i class='fas fa-edit text-yellow-500'></i> Editar, <i class='fas fa-trash text-red-500'></i> Eliminar.</li>
                </ul>
            </div>
            <div class='mt-6'><button id='btnVerManualCompleto' class='px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition'><i class='fas fa-book mr-2'></i>Ver manual completo</button></div>`
        },
        dashboard: {
            titulo: 'Dashboard',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Dashboard - Panel Principal</h2>
            <p class='mb-4'>El Dashboard es el panel principal del sistema SAMICAM que proporciona una vista general de las estadísticas más importantes y gráficas en tiempo real.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tarjetas de Estadísticas</h3>
                <div class='grid grid-cols-2 md:grid-cols-4 gap-4 mb-4'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-2'>
                            <i class='fas fa-users text-blue-600 text-xl mr-3'></i>
                            <div>
                                <h4 class='font-semibold text-gray-800'>Usuarios</h4>
                                <p class='text-2xl font-bold text-blue-600'>150</p>
                            </div>
                        </div>
                        <p class='text-xs text-gray-600'>Total de usuarios activos en el sistema</p>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-2'>
                            <i class='fas fa-user-cog text-green-600 text-xl mr-3'></i>
                            <div>
                                <h4 class='font-semibold text-gray-800'>Funcionarios OPS</h4>
                                <p class='text-2xl font-bold text-green-600'>45</p>
                            </div>
                        </div>
                        <p class='text-xs text-gray-600'>Funcionarios de planta temporal</p>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-2'>
                            <i class='fas fa-user-tie text-purple-600 text-xl mr-3'></i>
                            <div>
                                <h4 class='font-semibold text-gray-800'>Funcionarios Planta</h4>
                                <p class='text-2xl font-bold text-purple-600'>78</p>
                            </div>
                        </div>
                        <p class='text-xs text-gray-600'>Funcionarios de planta permanente</p>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-2'>
                            <i class='fas fa-calendar-week text-orange-600 text-xl mr-3'></i>
                            <div>
                                <h4 class='font-semibold text-gray-800'>Vacaciones Activas</h4>
                                <p class='text-2xl font-bold text-orange-600'>12</p>
                            </div>
                        </div>
                        <p class='text-xs text-gray-600'>Funcionarios en período vacacional</p>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Gráficas Interactivas</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-3 text-gray-700 flex items-center'>
                            <i class='fas fa-chart-bar text-blue-600 mr-2'></i>
                            Gráfica de Barras: Funcionarios por Cargo
                        </h4>
                        <div class='bg-gray-100 p-4 rounded text-center'>
                            <div class='w-full h-32 bg-gradient-to-r from-blue-400 to-blue-600 rounded flex items-center justify-center'>
                                <span class='text-white font-semibold'>Gráfica Interactiva</span>
                            </div>
                        </div>
                        <ul class='mt-3 text-sm text-gray-600 space-y-1'>
                            <li>• Muestra la distribución de funcionarios según su cargo</li>
                            <li>• Barras con colores diferenciados por cargo</li>
                            <li>• Datos actualizados en tiempo real</li>
                            <li>• Hover para ver detalles específicos</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-3 text-gray-700 flex items-center'>
                            <i class='fas fa-chart-line text-green-600 mr-2'></i>
                            Gráfica de Línea: Permisos por Mes
                        </h4>
                        <div class='bg-gray-100 p-4 rounded text-center'>
                            <div class='w-full h-32 bg-gradient-to-r from-green-400 to-green-600 rounded flex items-center justify-center'>
                                <span class='text-white font-semibold'>Gráfica Interactiva</span>
                            </div>
                        </div>
                        <ul class='mt-3 text-sm text-gray-600 space-y-1'>
                            <li>• Registro de permisos durante el año</li>
                            <li>• Línea temporal con tendencias</li>
                            <li>• Picos y valles de solicitudes</li>
                            <li>• Comparación mes a mes</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Características del Dashboard</h3>
                <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                    <ul class='space-y-2 text-sm text-gray-700'>
                        <li><b>Actualización en tiempo real:</b> Los datos se actualizan automáticamente</li>
                        <li><b>Permisos dinámicos:</b> Solo muestra información según los permisos del usuario</li>
                        <li><b>Navegación directa:</b> Hacer clic en las tarjetas lleva al módulo correspondiente</li>
                        <li><b>Gráficas responsivas:</b> Se adaptan al tamaño de la pantalla</li>
                        <li><b>Exportación:</b> Las gráficas se pueden exportar en diferentes formatos</li>
                    </ul>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades Adicionales</h3>
                <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                    <div class='bg-white p-3 rounded-lg border border-gray-200 shadow-sm text-center'>
                        <i class='fas fa-sync-alt text-blue-600 text-2xl mb-2'></i>
                        <h5 class='font-semibold text-gray-800'>Actualización Automática</h5>
                        <p class='text-xs text-gray-600'>Los datos se refrescan cada 5 minutos</p>
                    </div>
                    <div class='bg-white p-3 rounded-lg border border-gray-200 shadow-sm text-center'>
                        <i class='fas fa-download text-green-600 text-2xl mb-2'></i>
                        <h5 class='font-semibold text-gray-800'>Exportar Datos</h5>
                        <p class='text-xs text-gray-600'>Descargar reportes en PDF o Excel</p>
                    </div>
                    <div class='bg-white p-3 rounded-lg border border-gray-200 shadow-sm text-center'>
                        <i class='fas fa-filter text-purple-600 text-2xl mb-2'></i>
                        <h5 class='font-semibold text-gray-800'>Filtros Avanzados</h5>
                        <p class='text-xs text-gray-600'>Personalizar la vista según necesidades</p>
                    </div>
                </div>
            </div>

            <div class='mt-6'>
                <button id='btnVerManualCompleto' class='px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition'>
                    <i class='fas fa-book mr-2'></i>Ver manual completo
                </button>
            </div>`
        },
        usuarios: {
            titulo: 'Gestión de Usuarios',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Gestión de Usuarios y Roles</h2>
            <p class='mb-4'>El módulo de Gestión de Usuarios permite administrar todos los usuarios del sistema SAMICAM, asignar roles, gestionar permisos y controlar el acceso a los diferentes módulos.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tabla de Usuarios</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm overflow-x-auto'>
                    <table class='w-full text-sm'>
                        <thead class='bg-gray-50'>
                            <tr>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700 border-b'>Columna</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700 border-b'>Descripción</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700 border-b'>Funcionalidad</th>
                            </tr>
                        </thead>
                        <tbody class='divide-y divide-gray-200'>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Correo</td>
                                <td class='px-3 py-2 text-gray-600'>Email del usuario</td>
                                <td class='px-3 py-2 text-gray-600'>Identificador único, usado para login</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Nombres</td>
                                <td class='px-3 py-2 text-gray-600'>Nombre completo del usuario</td>
                                <td class='px-3 py-2 text-gray-600'>Nombre y apellidos</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Rol Principal</td>
                                <td class='px-3 py-2 text-gray-600'>Rol asignado al usuario</td>
                                <td class='px-3 py-2 text-gray-600'>Define permisos básicos del usuario</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Roles Adicionales</td>
                                <td class='px-3 py-2 text-gray-600'>Roles secundarios asignados</td>
                                <td class='px-3 py-2 text-gray-600'>Permisos adicionales combinados</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Estado</td>
                                <td class='px-3 py-2 text-gray-600'>Estado del usuario</td>
                                <td class='px-3 py-2 text-gray-600'>Activo/Inactivo</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Acciones</td>
                                <td class='px-3 py-2 text-gray-600'>Botones de acción</td>
                                <td class='px-3 py-2 text-gray-600'>Ver, Editar, Eliminar</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Botones de Acción</h3>
                <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-blue-600 text-white px-3 py-2 rounded mr-3'><i class='fas fa-eye'></i></button>
                            <h4 class='font-semibold text-gray-800'>Ver Usuario</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Muestra información detallada del usuario</li>
                            <li>• Lista todos los roles asignados</li>
                            <li>• Permisos específicos del usuario</li>
                            <li>• Historial de actividad</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-yellow-500 text-white px-3 py-2 rounded mr-3'><i class='fas fa-edit'></i></button>
                            <h4 class='font-semibold text-gray-800'>Editar Usuario</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Modificar datos del usuario</li>
                            <li>• Cambiar rol principal</li>
                            <li>• Asignar/remover roles adicionales</li>
                            <li>• Cambiar estado activo/inactivo</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-red-500 text-white px-3 py-2 rounded mr-3'><i class='fas fa-trash'></i></button>
                            <h4 class='font-semibold text-gray-800'>Eliminar Usuario</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Desactiva el usuario (no elimina)</li>
                            <li>• Requiere confirmación</li>
                            <li>• No se puede eliminar a sí mismo</li>
                            <li>• Protección para superadministrador</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Sistema de Roles</h3>
                <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                    <h4 class='font-semibold mb-2 text-blue-800'>Tipos de Roles</h4>
                    <div class='grid grid-cols-1 md:grid-cols-2 gap-4'>
                        <div>
                            <h5 class='font-semibold text-gray-700 mb-2'>Rol Principal</h5>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Definido en la tabla usuarios</li>
                                <li>• Permisos base del usuario</li>
                                <li>• Se puede cambiar desde editar</li>
                                <li>• Afecta la navegación del menú</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class='font-semibold text-gray-700 mb-2'>Roles Adicionales</h5>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Múltiples roles por usuario</li>
                                <li>• Permisos combinados</li>
                                <li>• Se suman al rol principal</li>
                                <li>• Mayor flexibilidad de acceso</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Modal de Crear/Editar Usuario</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                    <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                        <div>
                            <h4 class='font-semibold mb-3 text-gray-700'>Campos del Formulario</h4>
                            <ul class='space-y-2 text-sm text-gray-600'>
                                <li><b>Correo Electrónico:</b> Email único del usuario</li>
                                <li><b>Nombres:</b> Nombre completo obligatorio</li>
                                <li><b>Contraseña:</b> Solo para usuarios nuevos</li>
                                <li><b>Rol Principal:</b> Selector de rol base</li>
                                <li><b>Roles Adicionales:</b> Checkbox múltiple</li>
                                <li><b>Estado:</b> Activo/Inactivo</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class='font-semibold mb-3 text-gray-700'>Validaciones</h4>
                            <ul class='space-y-2 text-sm text-gray-600'>
                                <li>• Email debe ser único en el sistema</li>
                                <li>• Contraseña obligatoria para nuevos usuarios</li>
                                <li>• Nombres no pueden estar vacíos</li>
                                <li>• Al menos un rol debe estar seleccionado</li>
                                <li>• Validación de formato de email</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Permisos del Sistema</h3>
                <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                    <h4 class='font-semibold mb-2 text-green-800'>Tipos de Permisos</h4>
                    <div class='grid grid-cols-2 md:grid-cols-5 gap-3 text-center'>
                        <div class='bg-white p-3 rounded border'>
                            <div class='text-lg font-bold text-blue-600'>R</div>
                            <div class='text-xs text-gray-600'>Leer</div>
                        </div>
                        <div class='bg-white p-3 rounded border'>
                            <div class='text-lg font-bold text-green-600'>W</div>
                            <div class='text-xs text-gray-600'>Escribir</div>
                        </div>
                        <div class='bg-white p-3 rounded border'>
                            <div class='text-lg font-bold text-yellow-600'>U</div>
                            <div class='text-xs text-gray-600'>Actualizar</div>
                        </div>
                        <div class='bg-white p-3 rounded border'>
                            <div class='text-lg font-bold text-red-600'>D</div>
                            <div class='text-xs text-gray-600'>Eliminar</div>
                        </div>
                        <div class='bg-white p-3 rounded border'>
                            <div class='text-lg font-bold text-purple-600'>V</div>
                            <div class='text-xs text-gray-600'>Ver</div>
                        </div>
                    </div>
                    <p class='text-sm text-gray-600 mt-3'>Los permisos se combinan de todos los roles asignados al usuario, dando acceso a diferentes funcionalidades del sistema.</p>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Características Especiales</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-4'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-2 text-gray-700 flex items-center'>
                            <i class='fas fa-shield-alt text-blue-600 mr-2'></i>
                            Protección de Superadministrador
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• No se puede eliminar el rol ID 1</li>
                            <li>• No se pueden modificar sus permisos</li>
                            <li>• Acceso total a todos los módulos</li>
                            <li>• Protección contra auto-eliminación</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-2 text-gray-700 flex items-center'>
                            <i class='fas fa-users-cog text-green-600 mr-2'></i>
                            Gestión de Múltiples Roles
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Un usuario puede tener varios roles</li>
                            <li>• Los permisos se combinan automáticamente</li>
                            <li>• Mayor flexibilidad de acceso</li>
                            <li>• Roles específicos por función</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mt-6'>
                <button id='btnVerManualCompleto' class='px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition'>
                    <i class='fas fa-book mr-2'></i>Ver manual completo
                </button>
            </div>`
        },
        funcionarios: {
            titulo: 'Funcionarios',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Gestión de Funcionarios</h2>
            <p class='mb-4'>El sistema SAMICAM maneja dos tipos de funcionarios: <strong>Funcionarios de Planta</strong> (permanentes) y <strong>Funcionarios OPS</strong> (temporales). Cada tipo tiene características y funcionalidades específicas.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tipos de Funcionarios</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-3 text-gray-700 flex items-center'>
                            <i class='fas fa-user-tie text-blue-600 mr-2'></i>
                            Funcionarios de Planta
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-2'>
                            <li>• <b>Contratos permanentes</b> con la administración</li>
                            <li>• <b>Derecho a vacaciones</b> según años de servicio</li>
                            <li>• <b>Permisos diarios</b> con límites mensuales</li>
                            <li>• <b>Viáticos</b> para gastos de representación</li>
                            <li>• <b>Beneficios completos</b> del sistema</li>
                        </ul>
                        <div class='mt-3'>
                            <a href='#funcionariosplanta' class='text-blue-600 hover:text-blue-800 font-medium'>Ver detalles de Funcionarios Planta →</a>
                        </div>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-3 text-gray-700 flex items-center'>
                            <i class='fas fa-user-cog text-green-600 mr-2'></i>
                            Funcionarios OPS
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-2'>
                            <li>• <b>Contratos temporales</b> por prestación de servicios</li>
                            <li>• <b>Sin derecho a vacaciones</b> reglamentarias</li>
                            <li>• <b>Permisos limitados</b> según contrato</li>
                            <li>• <b>Sin viáticos</b> automáticos</li>
                            <li>• <b>Acceso restringido</b> a ciertos módulos</li>
                        </ul>
                        <div class='mt-3'>
                            <a href='#funcionariosops' class='text-green-600 hover:text-green-800 font-medium'>Ver detalles de Funcionarios OPS →</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades Comunes</h3>
                <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                    <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                        <div class='text-center'>
                            <i class='fas fa-file-excel text-green-600 text-2xl mb-2'></i>
                            <h5 class='font-semibold text-gray-800'>Exportar Excel</h5>
                            <p class='text-xs text-gray-600'>Descargar listados en formato Excel</p>
                        </div>
                        <div class='text-center'>
                            <i class='fas fa-file-pdf text-red-600 text-2xl mb-2'></i>
                            <h5 class='font-semibold text-gray-800'>Generar PDF</h5>
                            <p class='text-xs text-gray-600'>Reportes en formato PDF</p>
                        </div>
                        <div class='text-center'>
                            <i class='fas fa-search text-blue-600 text-2xl mb-2'></i>
                            <h5 class='font-semibold text-gray-800'>Búsqueda Avanzada</h5>
                            <p class='text-xs text-gray-600'>Filtrar por múltiples criterios</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mt-6'>
                <button id='btnVerManualCompleto' class='px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition'>
                    <i class='fas fa-book mr-2'></i>Ver manual completo
                </button>
            </div>`
        },
        funcionariosplanta: {
            titulo: 'Funcionarios de Planta',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Funcionarios de Planta - Gestión Completa</h2>
            <p class='mb-4'>Los funcionarios de planta son empleados permanentes con contratos a término indefinido. Tienen acceso completo a todas las funcionalidades del sistema incluyendo vacaciones, permisos, viáticos y beneficios.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tabla de Funcionarios Planta</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm overflow-x-auto'>
                    <table class='w-full text-sm'>
                        <thead class='bg-gray-50'>
                            <tr>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700 border-b'>Columna</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700 border-b'>Descripción</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700 border-b'>Funcionalidad</th>
                            </tr>
                        </thead>
                        <tbody class='divide-y divide-gray-200'>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>ID</td>
                                <td class='px-3 py-2 text-gray-600'>Identificador único</td>
                                <td class='px-3 py-2 text-gray-600'>Número de registro interno</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Nombre Completo</td>
                                <td class='px-3 py-2 text-gray-600'>Nombre y apellidos</td>
                                <td class='px-3 py-2 text-gray-600'>Datos personales del funcionario</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Identificación</td>
                                <td class='px-3 py-2 text-gray-600'>Cédula de ciudadanía</td>
                                <td class='px-3 py-2 text-gray-600'>Documento de identidad único</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Cargo</td>
                                <td class='px-3 py-2 text-gray-600'>Posición laboral</td>
                                <td class='px-3 py-2 text-gray-600'>Función específica en la entidad</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Dependencia</td>
                                <td class='px-3 py-2 text-gray-600'>Área de trabajo</td>
                                <td class='px-3 py-2 text-gray-600'>Departamento o sección asignada</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Contrato</td>
                                <td class='px-3 py-2 text-gray-600'>Tipo de vinculación</td>
                                <td class='px-3 py-2 text-gray-600'>Carrera administrativa, libre nombramiento</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Correo</td>
                                <td class='px-3 py-2 text-gray-600'>Email institucional</td>
                                <td class='px-3 py-2 text-gray-600'>Comunicación oficial</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Estado</td>
                                <td class='px-3 py-2 text-gray-600'>Estado del funcionario</td>
                                <td class='px-3 py-2 text-gray-600'>Activo/Inactivo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Botones de Acción</h3>
                <div class='grid grid-cols-1 md:grid-cols-4 gap-4'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-blue-600 text-white px-3 py-2 rounded mr-3'><i class='fas fa-eye'></i></button>
                            <h4 class='font-semibold text-gray-800'>Ver</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Información detallada</li>
                            <li>• Datos personales</li>
                            <li>• Historial laboral</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-yellow-500 text-white px-3 py-2 rounded mr-3'><i class='fas fa-edit'></i></button>
                            <h4 class='font-semibold text-gray-800'>Editar</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Modificar datos</li>
                            <li>• Actualizar información</li>
                            <li>• Cambiar estado</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-red-500 text-white px-3 py-2 rounded mr-3'><i class='fas fa-trash'></i></button>
                            <h4 class='font-semibold text-gray-800'>Eliminar</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Desactivar funcionario</li>
                            <li>• Requiere confirmación</li>
                            <li>• No elimina registros</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-green-500 text-white px-3 py-2 rounded mr-3'><i class='fas fa-plus'></i></button>
                            <h4 class='font-semibold text-gray-800'>Nuevo</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Crear funcionario</li>
                            <li>• Formulario completo</li>
                            <li>• Validaciones automáticas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades Específicas</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-3 text-gray-700 flex items-center'>
                            <i class='fas fa-file-excel text-green-600 mr-2'></i>
                            Exportar Excel
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-2'>
                            <li>• <b>Botón Excel:</b> Exporta tabla completa</li>
                            <li>• <b>Columnas incluidas:</b> ID, Nombre, Identificación, Cargo, Dependencia</li>
                            <li>• <b>Formato:</b> .xlsx compatible con Excel</li>
                            <li>• <b>Filtros:</b> Respeta filtros aplicados en la tabla</li>
                            <li>• <b>Descarga automática:</b> Se descarga inmediatamente</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-3 text-gray-700 flex items-center'>
                            <i class='fas fa-file-pdf text-red-600 mr-2'></i>
                            Generar PDF
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-2'>
                            <li>• <b>Botón PDF:</b> Genera reporte en PDF</li>
                            <li>• <b>Mismo contenido:</b> Que la exportación Excel</li>
                            <li>• <b>Formato profesional:</b> Con encabezados y estilos</li>
                            <li>• <b>Descarga directa:</b> Se abre en nueva pestaña</li>
                            <li>• <b>Compatible:</b> Con todos los navegadores</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Módulos Relacionados</h3>
                <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                    <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                        <h4 class='font-semibold mb-2 text-blue-800 flex items-center'>
                            <i class='fas fa-calendar-check text-blue-600 mr-2'></i>
                            Vacaciones
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• 3 períodos anuales</li>
                            <li>• Cálculo automático por años de servicio</li>
                            <li>• Estados: Pendiente, Aprobado, Cumplidas</li>
                            <li>• Generación de PDF de historial</li>
                        </ul>
                    </div>
                    <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                        <h4 class='font-semibold mb-2 text-green-800 flex items-center'>
                            <i class='fas fa-door-open text-green-600 mr-2'></i>
                            Permisos Diarios
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• 2 permisos por mes</li>
                            <li>• Permisos especiales con justificación</li>
                            <li>• Control de límites automático</li>
                            <li>• Historial completo de permisos</li>
                        </ul>
                    </div>
                    <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                        <h4 class='font-semibold mb-2 text-purple-800 flex items-center'>
                            <i class='fas fa-money-bill-wave text-purple-600 mr-2'></i>
                            Viáticos
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Gastos de representación</li>
                            <li>• Control de presupuesto anual</li>
                            <li>• Aprobación por montos</li>
                            <li>• Reportes de liquidación</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Importar desde Excel</h3>
                <div class='bg-yellow-50 p-4 rounded-lg border border-yellow-200'>
                    <h4 class='font-semibold mb-2 text-yellow-800 flex items-center'>
                        <i class='fas fa-upload text-yellow-600 mr-2'></i>
                        Funcionalidad de Importación
                    </h4>
                    <ul class='text-sm text-gray-600 space-y-2'>
                        <li>• <b>Botón "Importar Excel":</b> Permite cargar funcionarios masivamente</li>
                        <li>• <b>Plantilla descargable:</b> Formato estándar con columnas requeridas</li>
                        <li>• <b>Validaciones:</b> Verifica datos obligatorios y formatos</li>
                        <li>• <b>Reporte de errores:</b> Muestra filas con problemas</li>
                        <li>• <b>Confirmación:</b> Muestra resumen antes de importar</li>
                    </ul>
                </div>
            </div>

            <div class='mt-6'>
                <button id='btnVerManualCompleto' class='px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition'>
                    <i class='fas fa-book mr-2'></i>Ver manual completo
                </button>
            </div>`
        },
        funcionariosops: {
            titulo: 'Funcionarios OPS',
            html: `<h2 class='text-xl font-bold mb-4 text-green-700'>Funcionarios OPS - Gestión Temporal</h2>
            <p class='mb-4'>Los funcionarios OPS (Orden de Prestación de Servicios) son contratistas temporales que prestan servicios específicos a la administración. Tienen funcionalidades limitadas comparadas con los funcionarios de planta.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tabla de Funcionarios OPS</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm overflow-x-auto'>
                    <table class='w-full text-sm'>
                        <thead class='bg-gray-50'>
                            <tr>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700 border-b'>Columna</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700 border-b'>Descripción</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700 border-b'>Funcionalidad</th>
                            </tr>
                        </thead>
                        <tbody class='divide-y divide-gray-200'>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>ID</td>
                                <td class='px-3 py-2 text-gray-600'>Identificador único</td>
                                <td class='px-3 py-2 text-gray-600'>Número de registro interno</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Nombre Completo</td>
                                <td class='px-3 py-2 text-gray-600'>Nombre y apellidos</td>
                                <td class='px-3 py-2 text-gray-600'>Datos personales del contratista</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Identificación</td>
                                <td class='px-3 py-2 text-gray-600'>Cédula de ciudadanía</td>
                                <td class='px-3 py-2 text-gray-600'>Documento de identidad único</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Cargo</td>
                                <td class='px-3 py-2 text-gray-600'>Servicio prestado</td>
                                <td class='px-3 py-2 text-gray-600'>Descripción del servicio contratado</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Dependencia</td>
                                <td class='px-3 py-2 text-gray-600'>Área de trabajo</td>
                                <td class='px-3 py-2 text-gray-600'>Departamento donde presta servicios</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Estado Contrato</td>
                                <td class='px-3 py-2 text-gray-600'>Estado del contrato</td>
                                <td class='px-3 py-2 text-gray-600'>Activo, Terminado, Suspendido</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Fecha Inicio</td>
                                <td class='px-3 py-2 text-gray-600'>Inicio del contrato</td>
                                <td class='px-3 py-2 text-gray-600'>Fecha de inicio de servicios</td>
                            </tr>
                            <tr>
                                <td class='px-3 py-2 font-medium text-gray-800'>Fecha Fin</td>
                                <td class='px-3 py-2 text-gray-600'>Fin del contrato</td>
                                <td class='px-3 py-2 text-gray-600'>Fecha de terminación de servicios</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Botones de Acción</h3>
                <div class='grid grid-cols-1 md:grid-cols-4 gap-4'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-blue-600 text-white px-3 py-2 rounded mr-3'><i class='fas fa-eye'></i></button>
                            <h4 class='font-semibold text-gray-800'>Ver</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Información del contrato</li>
                            <li>• Datos personales</li>
                            <li>• Estado del servicio</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-yellow-500 text-white px-3 py-2 rounded mr-3'><i class='fas fa-edit'></i></button>
                            <h4 class='font-semibold text-gray-800'>Editar</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Modificar datos del contrato</li>
                            <li>• Actualizar fechas</li>
                            <li>• Cambiar estado</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-red-500 text-white px-3 py-2 rounded mr-3'><i class='fas fa-trash'></i></button>
                            <h4 class='font-semibold text-gray-800'>Eliminar</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Terminar contrato</li>
                            <li>• Cambiar estado a "Terminado"</li>
                            <li>• Mantener historial</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <div class='flex items-center mb-3'>
                            <button class='bg-green-500 text-white px-3 py-2 rounded mr-3'><i class='fas fa-plus'></i></button>
                            <h4 class='font-semibold text-gray-800'>Nuevo</h4>
                        </div>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Crear nuevo contrato</li>
                            <li>• Definir servicios</li>
                            <li>• Establecer fechas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades de Exportación</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-3 text-gray-700 flex items-center'>
                            <i class='fas fa-file-excel text-green-600 mr-2'></i>
                            Exportar Excel
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-2'>
                            <li>• <b>Botón Excel:</b> Exporta tabla completa</li>
                            <li>• <b>Columnas incluidas:</b> ID, Nombre, Identificación, Cargo, Dependencia, Estado</li>
                            <li>• <b>Formato:</b> .xlsx compatible con Excel</li>
                            <li>• <b>Filtros:</b> Respeta filtros aplicados en la tabla</li>
                            <li>• <b>Descarga automática:</b> Se descarga inmediatamente</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold mb-3 text-gray-700 flex items-center'>
                            <i class='fas fa-file-pdf text-red-600 mr-2'></i>
                            Generar PDF
                        </h4>
                        <ul class='text-sm text-gray-600 space-y-2'>
                            <li>• <b>Botón PDF:</b> Genera reporte en PDF</li>
                            <li>• <b>Mismo contenido:</b> Que la exportación Excel</li>
                            <li>• <b>Formato profesional:</b> Con encabezados y estilos</li>
                            <li>• <b>Descarga directa:</b> Se abre en nueva pestaña</li>
                            <li>• <b>Compatible:</b> Con todos los navegadores</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Limitaciones y Características</h3>
                <div class='bg-orange-50 p-4 rounded-lg border border-orange-200'>
                    <h4 class='font-semibold mb-2 text-orange-800'>Diferencias con Funcionarios Planta</h4>
                    <div class='grid grid-cols-1 md:grid-cols-2 gap-4'>
                        <div>
                            <h5 class='font-semibold text-gray-700 mb-2'>Sin Acceso a:</h5>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Módulo de Vacaciones</li>
                                <li>• Permisos diarios automáticos</li>
                                <li>• Viáticos reglamentarios</li>
                                <li>• Beneficios de planta</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class='font-semibold text-gray-700 mb-2'>Acceso Limitado a:</h5>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Permisos especiales (con justificación)</li>
                                <li>• Reportes básicos</li>
                                <li>• Información de contrato</li>
                                <li>• Historial de servicios</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Gestión de Contratos</h3>
                <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                    <h4 class='font-semibold mb-2 text-green-800'>Estados del Contrato</h4>
                    <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                        <div class='text-center'>
                            <div class='bg-green-100 p-3 rounded-lg'>
                                <i class='fas fa-check-circle text-green-600 text-2xl mb-2'></i>
                                <h5 class='font-semibold text-green-800'>Activo</h5>
                                <p class='text-xs text-green-600'>Contrato vigente</p>
                            </div>
                        </div>
                        <div class='text-center'>
                            <div class='bg-red-100 p-3 rounded-lg'>
                                <i class='fas fa-times-circle text-red-600 text-2xl mb-2'></i>
                                <h5 class='font-semibold text-red-800'>Terminado</h5>
                                <p class='text-xs text-red-600'>Contrato finalizado</p>
                            </div>
                        </div>
                        <div class='text-center'>
                            <div class='bg-yellow-100 p-3 rounded-lg'>
                                <i class='fas fa-pause-circle text-yellow-600 text-2xl mb-2'></i>
                                <h5 class='font-semibold text-yellow-800'>Suspendido</h5>
                                <p class='text-xs text-yellow-600'>Contrato pausado</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mt-6'>
                <button id='btnVerManualCompleto' class='px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition'>
                    <i class='fas fa-book mr-2'></i>Ver manual completo
                </button>
            </div>`
        },
        permisos: {
            titulo: 'Permisos Diarios',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Sistema de Permisos Diarios</h2>
            <p class='mb-4'>El módulo de Permisos Diarios permite gestionar las solicitudes de permisos de los funcionarios, con control de límites mensuales y diferentes tipos de permisos según el tipo de funcionario.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tipos de Permisos</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold text-blue-600 mb-2'>Funcionarios Planta</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>2 permisos por mes</strong> (límite estándar)</li>
                            <li>• <strong>Permisos especiales</strong> (médicos, calamidad doméstica)</li>
                            <li>• <strong>Acumulación anual</strong> de permisos no utilizados</li>
                            <li>• <strong>Control de vacaciones</strong> integrado</li>
                        </ul>
                    </div>
                    <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm'>
                        <h4 class='font-semibold text-green-600 mb-2'>Funcionarios OPS</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>1 permiso por mes</strong> (límite reducido)</li>
                            <li>• <strong>Sin acumulación</strong> de permisos</li>
                            <li>• <strong>Permisos por contrato</strong> limitados</li>
                            <li>• <strong>Control estricto</strong> de fechas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tabla de Permisos</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm overflow-x-auto'>
                    <table class='w-full text-sm'>
                        <thead class='bg-gray-50'>
                            <tr>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Funcionario</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Fecha</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Motivo</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Estado</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Permisos Usados</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class='divide-y divide-gray-200'>
                            <tr class='hover:bg-gray-50'>
                                <td class='px-3 py-2'>Juan Pérez</td>
                                <td class='px-3 py-2'>15/03/2024</td>
                                <td class='px-3 py-2'>Cita médica</td>
                                <td class='px-3 py-2'><span class='px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs'>Aprobado</span></td>
                                <td class='px-3 py-2'>1/2 (Marzo)</td>
                                <td class='px-3 py-2'>
                                    <div class='flex space-x-1'>
                                        <button class='p-1 text-blue-600 hover:bg-blue-100 rounded' title='Ver Detalles'><i class='fas fa-eye'></i></button>
                                        <button class='p-1 text-yellow-600 hover:bg-yellow-100 rounded' title='Editar'><i class='fas fa-edit'></i></button>
                                        <button class='p-1 text-red-600 hover:bg-red-100 rounded' title='Eliminar'><i class='fas fa-trash'></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades Principales</h3>
                <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                    <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                        <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-plus-circle mr-2'></i>Solicitar Permiso</h4>
                        <p class='text-sm text-gray-600'>Crear nueva solicitud de permiso con validación automática de límites mensuales y disponibilidad.</p>
                    </div>
                    <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                        <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-check-circle mr-2'></i>Aprobar/Rechazar</h4>
                        <p class='text-sm text-gray-600'>Gestionar solicitudes pendientes con comentarios y notificaciones automáticas.</p>
                    </div>
                    <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                        <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-chart-bar mr-2'></i>Reportes</h4>
                        <p class='text-sm text-gray-600'>Generar reportes de permisos por funcionario, dependencia y período específico.</p>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Validaciones del Sistema</h3>
                <ul class='space-y-2 text-sm text-gray-600'>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Límite mensual:</strong> Control automático según tipo de funcionario (Planta: 2, OPS: 1)</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Fechas válidas:</strong> No permite permisos en días festivos o fines de semana</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Motivos especiales:</strong> Permisos médicos y calamidad doméstica sin límite</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Acumulación:</strong> Solo funcionarios planta pueden acumular permisos no utilizados</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Notificaciones:</strong> Alertas automáticas cuando se alcanza el límite mensual</span></li>
                </ul>
            </div>`
        },
        contratos: {
            titulo: 'Seguimiento de Contratos',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Seguimiento de Contratos</h2>
            <p class='mb-4'>El módulo de Seguimiento de Contratos permite gestionar y dar seguimiento a todos los contratos municipales, incluyendo prórrogas, adiciones, liquidaciones y reportes de ejecución.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tabla de Contratos</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm overflow-x-auto'>
                    <table class='w-full text-sm'>
                        <thead class='bg-gray-50'>
                            <tr>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>N° Contrato</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Objeto</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Dependencia</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Valor</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Plazo</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Estado</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class='divide-y divide-gray-200'>
                            <tr class='hover:bg-gray-50'>
                                <td class='px-3 py-2 font-medium'>CON-2024-001</td>
                                <td class='px-3 py-2'>Mantenimiento de equipos</td>
                                <td class='px-3 py-2'>Tecnología</td>
                                <td class='px-3 py-2'>$50,000,000</td>
                                <td class='px-3 py-2'>12 meses</td>
                                <td class='px-3 py-2'><span class='px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs'>En Ejecución</span></td>
                                <td class='px-3 py-2'>
                                    <div class='flex space-x-1'>
                                        <button class='p-1 text-blue-600 hover:bg-blue-100 rounded' title='Ver Contrato'><i class='fas fa-eye'></i></button>
                                        <button class='p-1 text-yellow-600 hover:bg-yellow-100 rounded' title='Editar'><i class='fas fa-edit'></i></button>
                                        <button class='p-1 text-blue-500 hover:bg-blue-100 rounded' title='Prórroga'><i class='fas fa-clock'></i></button>
                                        <button class='p-1 text-green-600 hover:bg-green-100 rounded' title='Adición'><i class='fas fa-plus-circle'></i></button>
                                        <button class='p-1 text-purple-600 hover:bg-purple-100 rounded' title='Historial'><i class='fas fa-history'></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades Específicas</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='space-y-4'>
                        <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                            <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-clock mr-2'></i>Gestión de Prórrogas</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Extender plazo de contratos</li>
                                <li>• Historial de prórrogas</li>
                                <li>• Cálculo automático de días</li>
                                <li>• Motivos de prórroga</li>
                            </ul>
                        </div>
                        <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                            <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-plus-circle mr-2'></i>Adiciones Contractuales</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Incrementar valor del contrato</li>
                                <li>• Límite máximo del 50%</li>
                                <li>• Control de adiciones acumuladas</li>
                                <li>• Justificación de adiciones</li>
                            </ul>
                        </div>
                    </div>
                    <div class='space-y-4'>
                        <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                            <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-file-invoice mr-2'></i>Liquidaciones</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Cálculo de liquidaciones</li>
                                <li>• Estados de liquidación</li>
                                <li>• Reportes de ejecución</li>
                                <li>• Control de pagos</li>
                            </ul>
                        </div>
                        <div class='bg-orange-50 p-4 rounded-lg border border-orange-200'>
                            <h4 class='font-semibold text-orange-700 mb-2'><i class='fas fa-chart-line mr-2'></i>Reportes y Estadísticas</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Contratos por vencer</li>
                                <li>• Estadísticas por dependencia</li>
                                <li>• Gráficas de ejecución</li>
                                <li>• Exportación a Excel/PDF</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Estados de Contratos</h3>
                <div class='grid grid-cols-1 md:grid-cols-4 gap-4'>
                    <div class='text-center p-3 bg-yellow-50 rounded-lg border border-yellow-200'>
                        <div class='text-2xl text-yellow-600 mb-1'><i class='fas fa-play-circle'></i></div>
                        <div class='font-semibold text-yellow-700'>En Ejecución</div>
                        <div class='text-sm text-gray-600'>Contrato activo</div>
                    </div>
                    <div class='text-center p-3 bg-red-50 rounded-lg border border-red-200'>
                        <div class='text-2xl text-red-600 mb-1'><i class='fas fa-stop-circle'></i></div>
                        <div class='font-semibold text-red-700'>Finalizado</div>
                        <div class='text-sm text-gray-600'>Plazo vencido</div>
                    </div>
                    <div class='text-center p-3 bg-blue-50 rounded-lg border border-blue-200'>
                        <div class='text-2xl text-blue-600 mb-1'><i class='fas fa-check-circle'></i></div>
                        <div class='font-semibold text-blue-700'>Liquidado</div>
                        <div class='text-sm text-gray-600'>Pago completado</div>
                    </div>
                    <div class='text-center p-3 bg-gray-50 rounded-lg border border-gray-200'>
                        <div class='text-2xl text-gray-600 mb-1'><i class='fas fa-pause-circle'></i></div>
                        <div class='font-semibold text-gray-700'>Suspendido</div>
                        <div class='text-sm text-gray-600'>Temporalmente</div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Características del Sistema</h3>
                <ul class='space-y-2 text-sm text-gray-600'>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>SECOP 2:</strong> Integración con el sistema de contratación pública</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Alertas automáticas:</strong> Notificaciones de contratos por vencer</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Control de informes:</strong> Acta parcial y mes vencido</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Día de corte:</strong> Configuración personalizada por contrato</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Observaciones:</strong> Seguimiento detallado de ejecución</span></li>
                </ul>
            </div>`
        },
        inventario: {
            titulo: 'Sistema de Inventario',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Sistema de Inventario Municipal</h2>
            <p class='mb-4'>El módulo de Inventario permite gestionar todos los bienes y equipos de la administración municipal, incluyendo equipos de cómputo, impresoras, escáneres, papelería y herramientas.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Categorías de Inventario</h3>
                <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                    <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                        <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-print mr-2'></i>Impresoras y Escáneres</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Registro de impresoras</li>
                            <li>• Control de escáneres</li>
                            <li>• Gestión de consumibles</li>
                            <li>• Asignación a funcionarios</li>
                        </ul>
                    </div>
                    <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                        <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-laptop mr-2'></i>Equipos de Cómputo</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• PC de escritorio</li>
                            <li>• Portátiles</li>
                            <li>• Todo en uno</li>
                            <li>• Control de licencias</li>
                        </ul>
                    </div>
                    <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                        <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-tools mr-2'></i>Herramientas y Papelería</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• Herramientas de trabajo</li>
                            <li>• Suministros de oficina</li>
                            <li>• Control de stock</li>
                            <li>• Alertas de inventario</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tabla de Impresoras</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm overflow-x-auto'>
                    <table class='w-full text-sm'>
                        <thead class='bg-gray-50'>
                            <tr>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>N° Impresora</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Marca</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Modelo</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Serial</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Estado</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Asignado</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class='divide-y divide-gray-200'>
                            <tr class='hover:bg-gray-50'>
                                <td class='px-3 py-2 font-medium'>IMP-001</td>
                                <td class='px-3 py-2'>HP</td>
                                <td class='px-3 py-2'>LaserJet Pro</td>
                                <td class='px-3 py-2'>ABC123456</td>
                                <td class='px-3 py-2'><span class='px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs'>Bueno</span></td>
                                <td class='px-3 py-2'>Juan Pérez</td>
                                <td class='px-3 py-2'>
                                    <div class='flex space-x-1'>
                                        <button class='p-1 text-blue-600 hover:bg-blue-100 rounded' title='Ver Detalles'><i class='fas fa-eye'></i></button>
                                        <button class='p-1 text-yellow-600 hover:bg-yellow-100 rounded' title='Editar'><i class='fas fa-edit'></i></button>
                                        <button class='p-1 text-red-600 hover:bg-red-100 rounded' title='Eliminar'><i class='fas fa-trash'></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades Principales</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='space-y-4'>
                        <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                            <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-plus-circle mr-2'></i>Registro de Equipos</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Captura de información técnica</li>
                                <li>• Códigos de barras/QR</li>
                                <li>• Fotos de equipos</li>
                                <li>• Historial de mantenimiento</li>
                            </ul>
                        </div>
                        <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                            <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-user-check mr-2'></i>Asignación de Equipos</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Asignar a funcionarios</li>
                                <li>• Control de dependencias</li>
                                <li>• Fechas de asignación</li>
                                <li>• Responsabilidad legal</li>
                            </ul>
                        </div>
                    </div>
                    <div class='space-y-4'>
                        <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                            <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-chart-bar mr-2'></i>Reportes y Estadísticas</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Inventario por dependencia</li>
                                <li>• Estado de equipos</li>
                                <li>• Valor total del inventario</li>
                                <li>• Equipos por vencer garantía</li>
                            </ul>
                        </div>
                        <div class='bg-orange-50 p-4 rounded-lg border border-orange-200'>
                            <h4 class='font-semibold text-orange-700 mb-2'><i class='fas fa-download mr-2'></i>Exportación de Datos</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Exportar a Excel</li>
                                <li>• Generar PDF</li>
                                <li>• Reportes personalizados</li>
                                <li>• Backup de inventario</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Estados de Equipos</h3>
                <div class='grid grid-cols-1 md:grid-cols-4 gap-4'>
                    <div class='text-center p-3 bg-green-50 rounded-lg border border-green-200'>
                        <div class='text-2xl text-green-600 mb-1'><i class='fas fa-check-circle'></i></div>
                        <div class='font-semibold text-green-700'>Bueno</div>
                        <div class='text-sm text-gray-600'>Funcionando correctamente</div>
                    </div>
                    <div class='text-center p-3 bg-yellow-50 rounded-lg border border-yellow-200'>
                        <div class='text-2xl text-yellow-600 mb-1'><i class='fas fa-exclamation-triangle'></i></div>
                        <div class='font-semibold text-yellow-700'>Regular</div>
                        <div class='text-sm text-gray-600'>Requiere mantenimiento</div>
                    </div>
                    <div class='text-center p-3 bg-red-50 rounded-lg border border-red-200'>
                        <div class='text-2xl text-red-600 mb-1'><i class='fas fa-times-circle'></i></div>
                        <div class='font-semibold text-red-700'>Dañado</div>
                        <div class='text-sm text-gray-600'>Necesita reparación</div>
                    </div>
                    <div class='text-center p-3 bg-gray-50 rounded-lg border border-gray-200'>
                        <div class='text-2xl text-gray-600 mb-1'><i class='fas fa-archive'></i></div>
                        <div class='font-semibold text-gray-700'>Baja</div>
                        <div class='text-sm text-gray-600'>Retirado del servicio</div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Características del Sistema</h3>
                <ul class='space-y-2 text-sm text-gray-600'>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Códigos únicos:</strong> Identificación única para cada equipo</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Control de garantías:</strong> Seguimiento de fechas de vencimiento</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Mantenimiento preventivo:</strong> Alertas de servicios programados</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Inventario físico:</strong> Conciliación con conteo real</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Responsabilidad:</strong> Control de asignaciones y devoluciones</span></li>
                </ul>
            </div>`
        },
        tareas: {
            titulo: 'Tareas',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Tareas</h2><p class='mb-2'>Asignación y seguimiento de actividades y proyectos del personal.</p><ul class='list-disc pl-5 text-gray-700'><li>Creación y asignación de tareas.</li><li>Seguimiento de estados y responsables.</li></ul>`
        },
        publicaciones: {
            titulo: 'Publicaciones',
            html: `
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">Gestión de Publicaciones</h2>
                    
                    <div class="mb-6">
                        <p class="text-gray-700 mb-4">
                            El módulo de Publicaciones permite gestionar y dar seguimiento a todas las publicaciones oficiales 
                            de la alcaldía, incluyendo comunicados, resoluciones y documentos que requieren publicación pública.
                        </p>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Funcionalidades Principales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-newspaper text-blue-600 mr-2"></i>
                                Registro de Publicaciones
                            </h4>
                            <p class="text-sm text-gray-600">Crear y gestionar publicaciones oficiales con información completa.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-chart-line text-green-600 mr-2"></i>
                                Estadísticas y Reportes
                            </h4>
                            <p class="text-sm text-gray-600">Visualizar métricas y tendencias de publicaciones por período.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-search text-purple-600 mr-2"></i>
                                Seguimiento de Estado
                            </h4>
                            <p class="text-sm text-gray-600">Controlar el estado de respuesta y publicación de documentos.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-building text-orange-600 mr-2"></i>
                                Gestión por Dependencias
                            </h4>
                            <p class="text-sm text-gray-600">Organizar publicaciones según la dependencia responsable.</p>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Estructura de Datos</h3>
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Campo</th>
                                    <th class="py-2 px-4 border-b text-left">Tipo</th>
                                    <th class="py-2 px-4 border-b text-left">Descripción</th>
                                    <th class="py-2 px-4 border-b text-left">Obligatorio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Nombre Publicación</td>
                                    <td class="py-2 px-4 border-b text-sm">Texto</td>
                                    <td class="py-2 px-4 border-b text-sm">Título descriptivo de la publicación</td>
                                    <td class="py-2 px-4 border-b text-sm">Sí</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Fecha Recibido</td>
                                    <td class="py-2 px-4 border-b text-sm">Fecha</td>
                                    <td class="py-2 px-4 border-b text-sm">Fecha de recepción del documento</td>
                                    <td class="py-2 px-4 border-b text-sm">Sí</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Correo Recibido</td>
                                    <td class="py-2 px-4 border-b text-sm">Email</td>
                                    <td class="py-2 px-4 border-b text-sm">Correo del remitente</td>
                                    <td class="py-2 px-4 border-b text-sm">Sí</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Asunto</td>
                                    <td class="py-2 px-4 border-b text-sm">Texto</td>
                                    <td class="py-2 px-4 border-b text-sm">Descripción del contenido</td>
                                    <td class="py-2 px-4 border-b text-sm">Sí</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Dependencia</td>
                                    <td class="py-2 px-4 border-b text-sm">Select</td>
                                    <td class="py-2 px-4 border-b text-sm">Área responsable</td>
                                    <td class="py-2 px-4 border-b text-sm">Sí</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Fecha Publicación</td>
                                    <td class="py-2 px-4 border-b text-sm">Fecha</td>
                                    <td class="py-2 px-4 border-b text-sm">Fecha de publicación oficial</td>
                                    <td class="py-2 px-4 border-b text-sm">No</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Respuesta Envío</td>
                                    <td class="py-2 px-4 border-b text-sm">Select</td>
                                    <td class="py-2 px-4 border-b text-sm">Si/No - Confirmación de envío</td>
                                    <td class="py-2 px-4 border-b text-sm">Sí</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Enlace Publicación</td>
                                    <td class="py-2 px-4 border-b text-sm">URL</td>
                                    <td class="py-2 px-4 border-b text-sm">Enlace a la publicación oficial</td>
                                    <td class="py-2 px-4 border-b text-sm">No</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Interfaz del Módulo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <img src="https://via.placeholder.com/500x300?text=Interfaz+Publicaciones" alt="Interfaz de Publicaciones" class="w-full rounded-lg shadow-md mb-4">
                            <div class="text-sm text-gray-500 text-center">Figura: Vista principal del módulo de publicaciones</div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <h4 class="font-medium mb-2 text-blue-700">Pestañas de Navegación</h4>
                                <ul class="text-sm text-blue-600 space-y-1">
                                    <li>• <strong>Tabla:</strong> Vista de datos en formato tabular</li>
                                    <li>• <strong>Gráficos:</strong> Estadísticas y métricas visuales</li>
                                </ul>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <h4 class="font-medium mb-2 text-green-700">Dashboard de Estadísticas</h4>
                                <ul class="text-sm text-green-600 space-y-1">
                                    <li>• Total de publicaciones</li>
                                    <li>• Publicaciones recientes (7 días)</li>
                                    <li>• Publicaciones pendientes</li>
                                    <li>• Tasa de respuesta</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Estados y Flujos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <h4 class="font-medium mb-2 text-yellow-700 flex items-center">
                                <i class="fas fa-clock text-yellow-600 mr-2"></i>
                                Pendiente
                            </h4>
                            <p class="text-sm text-yellow-600">Publicación registrada pero sin respuesta de envío confirmada.</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-medium mb-2 text-green-700 flex items-center">
                                <i class="fas fa-check text-green-600 mr-2"></i>
                                Completada
                            </h4>
                            <p class="text-sm text-green-600">Publicación con respuesta de envío confirmada y enlace disponible.</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <h4 class="font-medium mb-2 text-red-700 flex items-center">
                                <i class="fas fa-times text-red-600 mr-2"></i>
                                Sin Respuesta
                            </h4>
                            <p class="text-sm text-red-600">Publicación donde se confirmó que no hubo respuesta de envío.</p>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Gráficos y Reportes</h3>
                    <div class="space-y-4 mb-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium mb-2 text-gray-700">Tipos de Gráficos Disponibles</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h5 class="font-medium text-sm text-gray-600">Tendencia de Publicaciones</h5>
                                    <p class="text-xs text-gray-500">Gráfico de líneas mostrando publicaciones por mes</p>
                                </div>
                                <div>
                                    <h5 class="font-medium text-sm text-gray-600">Estado de Publicaciones</h5>
                                    <p class="text-xs text-gray-500">Gráfico circular con distribución de estados</p>
                                </div>
                                <div>
                                    <h5 class="font-medium text-sm text-gray-600">Respuestas de Envío</h5>
                                    <p class="text-xs text-gray-500">Gráfico de barras con tasas de respuesta</p>
                                </div>
                                <div>
                                    <h5 class="font-medium text-sm text-gray-600">Por Dependencia</h5>
                                    <p class="text-xs text-gray-500">Gráfico horizontal con distribución por área</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Nota:</strong> Todas las acciones en el módulo de publicaciones son registradas 
                                    automáticamente en el sistema de auditoría para mantener trazabilidad completa.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            `
        },
        archivos: {
            titulo: 'Archivos',
            html: `
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">Gestión de Archivos</h2>
                    
                    <div class="mb-6">
                        <p class="text-gray-700 mb-4">
                            El módulo de Archivos proporciona un sistema completo de almacenamiento, organización y gestión 
                            de documentos municipales con categorización, búsqueda avanzada y control de acceso por permisos.
                        </p>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Funcionalidades Principales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-upload text-blue-600 mr-2"></i>
                                Subida de Archivos
                            </h4>
                            <p class="text-sm text-gray-600">Cargar documentos con validación de tipos y tamaños.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-folder text-green-600 mr-2"></i>
                                Categorización
                            </h4>
                            <p class="text-sm text-gray-600">Organizar archivos por categorías predefinidas.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-search text-purple-600 mr-2"></i>
                                Búsqueda Avanzada
                            </h4>
                            <p class="text-sm text-gray-600">Buscar archivos por nombre, descripción o categoría.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-download text-orange-600 mr-2"></i>
                                Descarga Segura
                            </h4>
                            <p class="text-sm text-gray-600">Descargar archivos con control de permisos.</p>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Tipos de Archivos Soportados</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-medium mb-2 text-green-700">Formatos Permitidos</h4>
                            <ul class="text-sm text-green-600 space-y-1">
                                <li>• <strong>Documentos:</strong> PDF, DOC, DOCX, TXT</li>
                                <li>• <strong>Hojas de Cálculo:</strong> XLS, XLSX</li>
                                <li>• <strong>Presentaciones:</strong> PPT, PPTX</li>
                                <li>• <strong>Imágenes:</strong> JPG, JPEG, PNG, GIF</li>
                            </ul>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <h4 class="font-medium mb-2 text-red-700">Formatos Prohibidos</h4>
                            <ul class="text-sm text-red-600 space-y-1">
                                <li>• <strong>Ejecutables:</strong> EXE, BAT, COM</li>
                                <li>• <strong>Scripts:</strong> PHP, JS, HTML, HTM</li>
                                <li>• <strong>Otros:</strong> Archivos potencialmente peligrosos</li>
                            </ul>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Categorías de Archivos</h3>
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Categoría</th>
                                    <th class="py-2 px-4 border-b text-left">Descripción</th>
                                    <th class="py-2 px-4 border-b text-left">Ejemplos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Documentos Administrativos</td>
                                    <td class="py-2 px-4 border-b text-sm">Procesos administrativos generales</td>
                                    <td class="py-2 px-4 border-b text-sm">Manuales, procedimientos, formularios</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Recursos Humanos</td>
                                    <td class="py-2 px-4 border-b text-sm">Documentos del área de RRHH</td>
                                    <td class="py-2 px-4 border-b text-sm">Contratos, nóminas, evaluaciones</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Contratos</td>
                                    <td class="py-2 px-4 border-b text-sm">Documentos contractuales</td>
                                    <td class="py-2 px-4 border-b text-sm">Acuerdos, convenios, licitaciones</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Informes</td>
                                    <td class="py-2 px-4 border-b text-sm">Reportes y análisis</td>
                                    <td class="py-2 px-4 border-b text-sm">Estadísticas, evaluaciones, balances</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Certificaciones</td>
                                    <td class="py-2 px-4 border-b text-sm">Documentos oficiales</td>
                                    <td class="py-2 px-4 border-b text-sm">Certificados, constancias, diplomas</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Memorandos</td>
                                    <td class="py-2 px-4 border-b text-sm">Comunicaciones internas</td>
                                    <td class="py-2 px-4 border-b text-sm">Memorandos, circulares, avisos</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Resoluciones</td>
                                    <td class="py-2 px-4 border-b text-sm">Documentos legales</td>
                                    <td class="py-2 px-4 border-b text-sm">Resoluciones, decretos, acuerdos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Interfaz del Módulo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <img src="https://via.placeholder.com/500x300?text=Interfaz+Archivos" alt="Interfaz de Archivos" class="w-full rounded-lg shadow-md mb-4">
                            <div class="text-sm text-gray-500 text-center">Figura: Vista principal del módulo de archivos</div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <h4 class="font-medium mb-2 text-blue-700">Barra de Herramientas</h4>
                                <ul class="text-sm text-blue-600 space-y-1">
                                    <li>• <strong>Buscar:</strong> Campo de búsqueda con filtros</li>
                                    <li>• <strong>Agregar Archivo:</strong> Botón para subir nuevos archivos</li>
                                    <li>• <strong>Gestionar Categorías:</strong> Enlace a gestión de categorías</li>
                                </ul>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <h4 class="font-medium mb-2 text-green-700">Explorador de Archivos</h4>
                                <ul class="text-sm text-green-600 space-y-1">
                                    <li>• Vista en pestañas por categorías</li>
                                    <li>• Vista de tarjetas para archivos</li>
                                    <li>• Acciones rápidas (ver, descargar, eliminar)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Proceso de Subida de Archivos</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h4 class="font-medium mb-2 text-blue-700">Pasos para Subir un Archivo</h4>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm mt-0.5">1</span>
                                <div>
                                    <p class="text-sm text-blue-700 font-medium">Hacer clic en "Agregar Archivo"</p>
                                    <p class="text-xs text-blue-600">Se abre el modal de subida de archivos</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm mt-0.5">2</span>
                                <div>
                                    <p class="text-sm text-blue-700 font-medium">Completar información del archivo</p>
                                    <p class="text-xs text-blue-600">Nombre, descripción y categoría (opcional)</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm mt-0.5">3</span>
                                <div>
                                    <p class="text-sm text-blue-700 font-medium">Seleccionar archivo del sistema</p>
                                    <p class="text-xs text-blue-600">Validación automática de tipo y tamaño</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm mt-0.5">4</span>
                                <div>
                                    <p class="text-sm text-blue-700 font-medium">Guardar archivo</p>
                                    <p class="text-xs text-blue-600">El archivo se almacena con nombre único</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Características de Seguridad</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <h4 class="font-medium mb-2 text-yellow-700">Validaciones</h4>
                            <ul class="text-sm text-yellow-600 space-y-1">
                                <li>• Verificación de tipos de archivo</li>
                                <li>• Validación de extensiones permitidas</li>
                                <li>• Control de tamaño máximo</li>
                                <li>• Generación de nombres únicos</li>
                            </ul>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <h4 class="font-medium mb-2 text-red-700">Protecciones</h4>
                            <ul class="text-sm text-red-600 space-y-1">
                                <li>• Bloqueo de archivos ejecutables</li>
                                <li>• Prevención de inyección de código</li>
                                <li>• Control de acceso por permisos</li>
                                <li>• Almacenamiento seguro en servidor</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Importante:</strong> Los archivos se almacenan con nombres únicos generados 
                                    automáticamente para evitar conflictos y mejorar la seguridad del sistema.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            `
        },
        auditoria: {
            titulo: 'Auditoría',
            html: `
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">Auditoría del Sistema</h2>
                    
                    <div class="mb-6">
                        <p class="text-gray-700 mb-4">
                            El módulo de Auditoría registra automáticamente todas las acciones realizadas por los usuarios en el sistema, 
                            proporcionando trazabilidad completa y seguridad para la administración municipal.
                        </p>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-shield-alt text-blue-500 mt-1"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Acceso Restringido:</strong> Solo los Superadministradores pueden acceder a este módulo.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Funcionalidades Principales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-search text-blue-600 mr-2"></i>
                                Búsqueda Avanzada
                            </h4>
                            <p class="text-sm text-gray-600">Busque registros por usuario, acción, fecha, IP o cualquier término específico.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-history text-green-600 mr-2"></i>
                                Historial Completo
                            </h4>
                            <p class="text-sm text-gray-600">Visualice todos los registros de auditoría en formato de terminal.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-download text-purple-600 mr-2"></i>
                                Descarga de Reportes
                            </h4>
                            <p class="text-sm text-gray-600">Exporte el historial completo en formato Excel para análisis externo.</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <i class="fas fa-eye text-orange-600 mr-2"></i>
                                Vista de Terminal
                            </h4>
                            <p class="text-sm text-gray-600">Interfaz tipo terminal con colores para mejor legibilidad de los logs.</p>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Tipos de Registros</h3>
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Tipo de Acción</th>
                                    <th class="py-2 px-4 border-b text-left">Descripción</th>
                                    <th class="py-2 px-4 border-b text-left">Información Registrada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Inicio de Sesión</td>
                                    <td class="py-2 px-4 border-b">Acceso al sistema</td>
                                    <td class="py-2 px-4 border-b text-sm">Usuario, correo, rol, IP, navegador, fecha/hora</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Cierre de Sesión</td>
                                    <td class="py-2 px-4 border-b">Salida del sistema</td>
                                    <td class="py-2 px-4 border-b text-sm">Usuario, rol, IP, fecha/hora</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">Acceso a Módulos</td>
                                    <td class="py-2 px-4 border-b">Navegación entre módulos</td>
                                    <td class="py-2 px-4 border-b text-sm">Usuario, rol, módulo accedido, fecha/hora</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">Operaciones CRUD</td>
                                    <td class="py-2 px-4 border-b">Crear, leer, actualizar, eliminar</td>
                                    <td class="py-2 px-4 border-b text-sm">Usuario, acción específica, datos afectados, fecha/hora</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Elementos de la Interfaz</h3>
                    <div class="space-y-4 mb-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium mb-2 text-gray-700">Panel de Búsqueda</h4>
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Campo de Búsqueda</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md" placeholder="Buscar por usuario, acción, fecha, IP...">
                                    </div>
                                </div>
                                <div class="md:w-auto">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Acción</label>
                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                        <i class="fas fa-search mr-2"></i>Buscar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium mb-2 text-gray-700">Visor de Terminal</h4>
                            <div class="bg-gray-900 text-green-400 p-4 rounded font-mono text-sm">
                                <div class="mb-2">
                                    <span class="text-gray-400">[2023-12-15 14:30:25]</span> 
                                    <span class="text-blue-400">ID: 123</span> | 
                                    <span class="text-green-400">Usuario: Juan Pérez</span> | 
                                    <span class="text-yellow-400">Rol: Administrador</span> | 
                                    <span class="text-purple-400">IP: 192.168.1.100</span> | 
                                    <span class="text-white">Acción: Acceso al módulo Usuarios</span>
                                </div>
                                <div>
                                    <span class="text-gray-400">[2023-12-15 14:29:15]</span> 
                                    <span class="text-blue-400">ID: 123</span> | 
                                    <span class="text-green-400">Usuario: Juan Pérez</span> | 
                                    <span class="text-yellow-400">Rol: Administrador</span> | 
                                    <span class="text-purple-400">IP: 192.168.1.100</span> | 
                                    <span class="text-white">Acción: Inicio de sesión</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Características Técnicas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700">Almacenamiento</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Archivo de texto: <code>uploads/auditoria/historicoAuditoria.txt</code></li>
                                <li>• Formato: Timestamp | ID | Usuario | Rol | IP | Acción</li>
                                <li>• Codificación: UTF-8</li>
                                <li>• Rotación automática de logs</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700">Seguridad</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Acceso restringido a Superadministradores</li>
                                <li>• Registro de IP y navegador</li>
                                <li>• Protección contra manipulación de logs</li>
                                <li>• Auditoría de la auditoría</li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    <strong>Importante:</strong> Los registros de auditoría son críticos para la seguridad del sistema. 
                                    No modifique manualmente el archivo de logs y mantenga copias de seguridad regulares.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            `
        },
        configuracion: {
            titulo: 'Configuración',
            html: `
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">Configuración y Ajustes</h2>
                    
                    <div class="mb-6">
                        <p class="text-gray-700 mb-4">
                            El módulo de Configuración permite a los usuarios personalizar su perfil y ajustar preferencias 
                            del sistema según sus necesidades de trabajo.
                        </p>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Ajustes de Perfil</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <img src="https://via.placeholder.com/400x300?text=Pantalla+de+Ajustes" alt="Pantalla de Ajustes" class="w-full rounded-lg shadow-md mb-4">
                            <div class="text-sm text-gray-500 text-center">Figura: Interfaz de ajustes de perfil</div>
                        </div>
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                    <i class="fas fa-user-circle text-blue-600 mr-2"></i>
                                    Información Personal
                                </h4>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• Actualización de nombre completo</li>
                                    <li>• Cambio de foto de perfil</li>
                                    <li>• Visualización de datos actuales</li>
                                </ul>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                    <i class="fas fa-camera text-green-600 mr-2"></i>
                                    Gestión de Imágenes
                                </h4>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• Subida de fotos de perfil</li>
                                    <li>• Formatos soportados: JPG, PNG, WEBP</li>
                                    <li>• Vista previa en tiempo real</li>
                                    <li>• Redimensionamiento automático</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Elementos de la Interfaz</h3>
                    <div class="space-y-4 mb-6">
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h4 class="font-medium mb-2 text-gray-700">Formulario de Ajustes</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto de Perfil</label>
                                    <div class="flex items-center space-x-4">
                                        <img src="https://via.placeholder.com/120x120?text=Perfil" class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                                        <input type="file" class="flex-1 px-3 py-2 border border-gray-300 rounded-md" accept="image/*">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre Completo</label>
                                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="Juan Pérez" required>
                                </div>
                                <div class="text-center">
                                    <button class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Configuraciones del Sistema</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700">Configuración General</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Zona horaria: America/Bogota</li>
                                <li>• Idioma: Español</li>
                                <li>• Formato de fecha: DD/MM/YYYY</li>
                                <li>• Moneda: Peso Colombiano (COP)</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium mb-2 text-gray-700">Configuración de Base de Datos</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Host: localhost:3307</li>
                                <li>• Base de datos: samicam</li>
                                <li>• Codificación: UTF-8</li>
                                <li>• Timeout: 30 segundos</li>
                            </ul>
                        </div>
                    </div>

                    <h3 class="text-xl font-semibold mb-3 text-gray-700">Parámetros del Sistema</h3>
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Parámetro</th>
                                    <th class="py-2 px-4 border-b text-left">Valor</th>
                                    <th class="py-2 px-4 border-b text-left">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">BASE_URL</td>
                                    <td class="py-2 px-4 border-b">http://localhost/samicam</td>
                                    <td class="py-2 px-4 border-b text-sm">URL base del sistema</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">EMAIL_INSTITUCIONAL</td>
                                    <td class="py-2 px-4 border-b">Alcaldia@lajaguadeibirico-cesar.gov.co</td>
                                    <td class="py-2 px-4 border-b text-sm">Correo oficial de la alcaldía</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-4 border-b font-medium">WHATSAPP</td>
                                    <td class="py-2 px-4 border-b">3148691240</td>
                                    <td class="py-2 px-4 border-b text-sm">Número de WhatsApp institucional</td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b font-medium">NOMBRE_EMPRESA</td>
                                    <td class="py-2 px-4 border-b">Alcaldía de la Jagua de Ibirico</td>
                                    <td class="py-2 px-4 border-b text-sm">Nombre oficial de la institución</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Nota:</strong> Los cambios en la configuración del sistema solo pueden ser realizados 
                                    por administradores del sistema. Los usuarios regulares solo pueden modificar su perfil personal.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            `
        },
        vacaciones: {
            titulo: 'Sistema de Vacaciones',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Sistema de Vacaciones</h2>
            <p class='mb-4'>El módulo de Vacaciones permite gestionar las solicitudes y el control de vacaciones de los funcionarios, con cálculo automático de días disponibles y control de períodos anuales.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tipos de Vacaciones</h3>
                <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                    <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                        <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-calendar-alt mr-2'></i>Vacaciones Ordinarias</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>15 días anuales</strong> por funcionario</li>
                            <li>• <strong>3 períodos</strong> de 5 días cada uno</li>
                            <li>• <strong>Acumulación</strong> hasta 2 años</li>
                            <li>• <strong>Liquidación</strong> al retirarse</li>
                        </ul>
                    </div>
                    <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                        <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-calendar-plus mr-2'></i>Vacaciones Compensatorias</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>Días adicionales</strong> por trabajo extra</li>
                            <li>• <strong>Compensación</strong> de horas extras</li>
                            <li>• <strong>Límite anual</strong> establecido</li>
                            <li>• <strong>No acumulables</strong> al siguiente año</li>
                        </ul>
                    </div>
                    <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                        <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-calendar-check mr-2'></i>Vacaciones Especiales</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>Maternidad/Paternidad</strong></li>
                            <li>• <strong>Luto</strong> por fallecimiento</li>
                            <li>• <strong>Casamiento</strong> del funcionario</li>
                            <li>• <strong>Otros casos</strong> especiales</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tabla de Vacaciones</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm overflow-x-auto'>
                    <table class='w-full text-sm'>
                        <thead class='bg-gray-50'>
                            <tr>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Funcionario</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Período</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Días Solicitados</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Fecha Inicio</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Fecha Fin</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Estado</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class='divide-y divide-gray-200'>
                            <tr class='hover:bg-gray-50'>
                                <td class='px-3 py-2'>María González</td>
                                <td class='px-3 py-2'>2024</td>
                                <td class='px-3 py-2'>5 días</td>
                                <td class='px-3 py-2'>15/07/2024</td>
                                <td class='px-3 py-2'>19/07/2024</td>
                                <td class='px-3 py-2'><span class='px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs'>Aprobada</span></td>
                                <td class='px-3 py-2'>
                                    <div class='flex space-x-1'>
                                        <button class='p-1 text-blue-600 hover:bg-blue-100 rounded' title='Ver Detalles'><i class='fas fa-eye'></i></button>
                                        <button class='p-1 text-yellow-600 hover:bg-yellow-100 rounded' title='Editar'><i class='fas fa-edit'></i></button>
                                        <button class='p-1 text-red-600 hover:bg-red-100 rounded' title='Eliminar'><i class='fas fa-trash'></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades Principales</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='space-y-4'>
                        <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                            <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-plus-circle mr-2'></i>Solicitud de Vacaciones</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Selección de funcionario</li>
                                <li>• Cálculo automático de días disponibles</li>
                                <li>• Validación de fechas</li>
                                <li>• Control de períodos anuales</li>
                            </ul>
                        </div>
                        <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                            <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-check-circle mr-2'></i>Aprobación y Control</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Flujo de aprobación</li>
                                <li>• Notificaciones automáticas</li>
                                <li>• Control de superposición</li>
                                <li>• Historial de solicitudes</li>
                            </ul>
                        </div>
                    </div>
                    <div class='space-y-4'>
                        <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                            <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-chart-bar mr-2'></i>Reportes y Estadísticas</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Vacaciones por funcionario</li>
                                <li>• Días acumulados</li>
                                <li>• Períodos pendientes</li>
                                <li>• Exportación a Excel/PDF</li>
                            </ul>
                        </div>
                        <div class='bg-orange-50 p-4 rounded-lg border border-orange-200'>
                            <h4 class='font-semibold text-orange-700 mb-2'><i class='fas fa-calculator mr-2'></i>Cálculos Automáticos</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Días disponibles</li>
                                <li>• Liquidación de vacaciones</li>
                                <li>• Acumulación anual</li>
                                <li>• Prescripción de derechos</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Estados de Vacaciones</h3>
                <div class='grid grid-cols-1 md:grid-cols-4 gap-4'>
                    <div class='text-center p-3 bg-yellow-50 rounded-lg border border-yellow-200'>
                        <div class='text-2xl text-yellow-600 mb-1'><i class='fas fa-clock'></i></div>
                        <div class='font-semibold text-yellow-700'>Pendiente</div>
                        <div class='text-sm text-gray-600'>Esperando aprobación</div>
                    </div>
                    <div class='text-center p-3 bg-green-50 rounded-lg border border-green-200'>
                        <div class='text-2xl text-green-600 mb-1'><i class='fas fa-check-circle'></i></div>
                        <div class='font-semibold text-green-700'>Aprobada</div>
                        <div class='text-sm text-gray-600'>Vacaciones autorizadas</div>
                    </div>
                    <div class='text-center p-3 bg-red-50 rounded-lg border border-red-200'>
                        <div class='text-2xl text-red-600 mb-1'><i class='fas fa-times-circle'></i></div>
                        <div class='font-semibold text-red-700'>Rechazada</div>
                        <div class='text-sm text-gray-600'>Solicitud denegada</div>
                    </div>
                    <div class='text-center p-3 bg-blue-50 rounded-lg border border-blue-200'>
                        <div class='text-2xl text-blue-600 mb-1'><i class='fas fa-calendar-check'></i></div>
                        <div class='font-semibold text-blue-700'>Cumplida</div>
                        <div class='text-sm text-gray-600'>Período completado</div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Características del Sistema</h3>
                <ul class='space-y-2 text-sm text-gray-600'>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Cálculo automático:</strong> Días disponibles según antigüedad y tipo de contrato</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Validación de fechas:</strong> No permite vacaciones en días festivos o fines de semana</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Control de períodos:</strong> Máximo 3 períodos por año con mínimo 5 días</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Acumulación:</strong> Hasta 2 años consecutivos de vacaciones</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Liquidación:</strong> Cálculo automático al retirarse del cargo</span></li>
                </ul>
            </div>`
        },
        viaticos: {
            titulo: 'Sistema de Viáticos',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Sistema de Viáticos</h2>
            <p class='mb-4'>El módulo de Viáticos permite gestionar los gastos de representación y desplazamientos oficiales de los funcionarios, con control de presupuesto anual y liquidaciones detalladas.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tipos de Viáticos</h3>
                <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                    <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                        <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-plane mr-2'></i>Desplazamientos</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>Transporte</strong> terrestre y aéreo</li>
                            <li>• <strong>Alojamiento</strong> en hoteles</li>
                            <li>• <strong>Alimentación</strong> diaria</li>
                            <li>• <strong>Gastos menores</strong> de representación</li>
                        </ul>
                    </div>
                    <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                        <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-handshake mr-2'></i>Gastos de Representación</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>Eventos oficiales</strong></li>
                            <li>• <strong>Reuniones institucionales</strong></li>
                            <li>• <strong>Actividades protocolarias</strong></li>
                            <li>• <strong>Gastos de protocolo</strong></li>
                        </ul>
                    </div>
                    <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                        <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-tools mr-2'></i>Comisiones de Servicio</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>Capacitación</strong> y formación</li>
                            <li>• <strong>Eventos técnicos</strong></li>
                            <li>• <strong>Representación oficial</strong></li>
                            <li>• <strong>Actividades especiales</strong></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tabla de Viáticos</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm overflow-x-auto'>
                    <table class='w-full text-sm'>
                        <thead class='bg-gray-50'>
                            <tr>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Funcionario</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Descripción</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Monto</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Fecha Salida</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Fecha Regreso</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Estado</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class='divide-y divide-gray-200'>
                            <tr class='hover:bg-gray-50'>
                                <td class='px-3 py-2'>Carlos Rodríguez</td>
                                <td class='px-3 py-2'>Capacitación en Bogotá</td>
                                <td class='px-3 py-2'>$2,500,000</td>
                                <td class='px-3 py-2'>20/03/2024</td>
                                <td class='px-3 py-2'>22/03/2024</td>
                                <td class='px-3 py-2'><span class='px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs'>Aprobado</span></td>
                                <td class='px-3 py-2'>
                                    <div class='flex space-x-1'>
                                        <button class='p-1 text-blue-600 hover:bg-blue-100 rounded' title='Ver Detalles'><i class='fas fa-eye'></i></button>
                                        <button class='p-1 text-yellow-600 hover:bg-yellow-100 rounded' title='Editar'><i class='fas fa-edit'></i></button>
                                        <button class='p-1 text-red-600 hover:bg-red-100 rounded' title='Eliminar'><i class='fas fa-trash'></i></button>
                                        <button class='p-1 text-purple-600 hover:bg-purple-100 rounded' title='Liquidar'><i class='fas fa-file-invoice'></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Control de Presupuesto</h3>
                <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                    <div class='bg-blue-50 p-4 rounded-lg border border-blue-200 text-center'>
                        <div class='text-2xl font-bold text-blue-700 mb-1'>$500,000,000</div>
                        <div class='text-sm text-gray-600'>Presupuesto Anual</div>
                    </div>
                    <div class='bg-green-50 p-4 rounded-lg border border-green-200 text-center'>
                        <div class='text-2xl font-bold text-green-700 mb-1'>$350,000,000</div>
                        <div class='text-sm text-gray-600'>Capital Disponible</div>
                    </div>
                    <div class='bg-red-50 p-4 rounded-lg border border-red-200 text-center'>
                        <div class='text-2xl font-bold text-red-700 mb-1'>$150,000,000</div>
                        <div class='text-sm text-gray-600'>Gastado</div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades Principales</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='space-y-4'>
                        <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                            <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-plus-circle mr-2'></i>Solicitud de Viáticos</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Selección de funcionario</li>
                                <li>• Descripción del gasto</li>
                                <li>• Fechas de salida y regreso</li>
                                <li>• Validación de presupuesto</li>
                            </ul>
                        </div>
                        <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                            <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-file-invoice mr-2'></i>Liquidación</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Generación de PDF</li>
                                <li>• Cálculo de días</li>
                                <li>• Desglose de gastos</li>
                                <li>• Firma digital</li>
                            </ul>
                        </div>
                    </div>
                    <div class='space-y-4'>
                        <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                            <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-chart-bar mr-2'></i>Reportes y Estadísticas</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Viáticos por funcionario</li>
                                <li>• Gastos por dependencia</li>
                                <li>• Control de presupuesto</li>
                                <li>• Historial anual</li>
                            </ul>
                        </div>
                        <div class='bg-orange-50 p-4 rounded-lg border border-orange-200'>
                            <h4 class='font-semibold text-orange-700 mb-2'><i class='fas fa-calculator mr-2'></i>Cálculos Automáticos</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Valor por día</li>
                                <li>• Total de gastos</li>
                                <li>• Disponibilidad presupuestal</li>
                                <li>• Alertas de límites</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Características del Sistema</h3>
                <ul class='space-y-2 text-sm text-gray-600'>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Control presupuestal:</strong> Validación automática contra presupuesto anual disponible</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Liquidación automática:</strong> Generación de PDF con formato oficial</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Cálculo de días:</strong> Automático entre fecha de salida y regreso</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Historial completo:</strong> Seguimiento de todos los viáticos otorgados</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Alertas automáticas:</strong> Notificaciones cuando se alcanza el límite presupuestal</span></li>
                </ul>
            </div>`
        },
        tareas: {
            titulo: 'Sistema de Tareas',
            html: `<h2 class='text-xl font-bold mb-4 text-blue-700'>Sistema de Gestión de Tareas</h2>
            <p class='mb-4'>El módulo de Tareas permite gestionar y dar seguimiento a las actividades técnicas y administrativas, con asignación de usuarios, control de estados y reportes de productividad.</p>
            
            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tipos de Tareas</h3>
                <div class='grid grid-cols-1 md:grid-cols-3 gap-4'>
                    <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                        <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-laptop mr-2'></i>Tareas Técnicas</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>Mantenimiento</strong> de equipos</li>
                            <li>• <strong>Instalación</strong> de software</li>
                            <li>• <strong>Reparación</strong> de hardware</li>
                            <li>• <strong>Soporte técnico</strong></li>
                        </ul>
                    </div>
                    <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                        <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-cogs mr-2'></i>Tareas Administrativas</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>Configuración</strong> de sistemas</li>
                            <li>• <strong>Actualizaciones</strong> de software</li>
                            <li>• <strong>Backup</strong> de datos</li>
                            <li>• <strong>Capacitación</strong> de usuarios</li>
                        </ul>
                    </div>
                    <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                        <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-tools mr-2'></i>Tareas Especiales</h4>
                        <ul class='text-sm text-gray-600 space-y-1'>
                            <li>• <strong>Proyectos</strong> especiales</li>
                            <li>• <strong>Emergencias</strong> técnicas</li>
                            <li>• <strong>Auditorías</strong> de sistemas</li>
                            <li>• <strong>Implementaciones</strong> nuevas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Tabla de Tareas</h3>
                <div class='bg-white p-4 rounded-lg border border-gray-200 shadow-sm overflow-x-auto'>
                    <table class='w-full text-sm'>
                        <thead class='bg-gray-50'>
                            <tr>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>ID</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Asignado</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Tipo</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Descripción</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Dependencia</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Estado</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Tiempo Restante</th>
                                <th class='px-3 py-2 text-left font-semibold text-gray-700'>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class='divide-y divide-gray-200'>
                            <tr class='hover:bg-gray-50'>
                                <td class='px-3 py-2 font-medium'>T-001</td>
                                <td class='px-3 py-2'>Juan Pérez</td>
                                <td class='px-3 py-2'>Mantenimiento</td>
                                <td class='px-3 py-2'>Reparación impresora sectorial</td>
                                <td class='px-3 py-2'>Tecnología</td>
                                <td class='px-3 py-2'><span class='px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs'>En Curso</span></td>
                                <td class='px-3 py-2'>2 días</td>
                                <td class='px-3 py-2'>
                                    <div class='flex space-x-1'>
                                        <button class='p-1 text-blue-600 hover:bg-blue-100 rounded' title='Ver Detalles'><i class='fas fa-eye'></i></button>
                                        <button class='p-1 text-yellow-600 hover:bg-yellow-100 rounded' title='Editar'><i class='fas fa-edit'></i></button>
                                        <button class='p-1 text-green-600 hover:bg-green-100 rounded' title='Completar'><i class='fas fa-check'></i></button>
                                        <button class='p-1 text-red-600 hover:bg-red-100 rounded' title='Eliminar'><i class='fas fa-trash'></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Estados de Tareas</h3>
                <div class='grid grid-cols-1 md:grid-cols-4 gap-4'>
                    <div class='text-center p-3 bg-gray-50 rounded-lg border border-gray-200'>
                        <div class='text-2xl text-gray-600 mb-1'><i class='fas fa-clock'></i></div>
                        <div class='font-semibold text-gray-700'>Sin Empezar</div>
                        <div class='text-sm text-gray-600'>Tarea pendiente</div>
                    </div>
                    <div class='text-center p-3 bg-blue-50 rounded-lg border border-blue-200'>
                        <div class='text-2xl text-blue-600 mb-1'><i class='fas fa-play-circle'></i></div>
                        <div class='font-semibold text-blue-700'>En Curso</div>
                        <div class='text-sm text-gray-600'>Trabajando en ella</div>
                    </div>
                    <div class='text-center p-3 bg-green-50 rounded-lg border border-green-200'>
                        <div class='text-2xl text-green-600 mb-1'><i class='fas fa-check-circle'></i></div>
                        <div class='font-semibold text-green-700'>Completada</div>
                        <div class='text-sm text-gray-600'>Tarea finalizada</div>
                    </div>
                    <div class='text-center p-3 bg-red-50 rounded-lg border border-red-200'>
                        <div class='text-2xl text-red-600 mb-1'><i class='fas fa-exclamation-triangle'></i></div>
                        <div class='font-semibold text-red-700'>Vencida</div>
                        <div class='text-sm text-gray-600'>Fuera de plazo</div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Funcionalidades Principales</h3>
                <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                    <div class='space-y-4'>
                        <div class='bg-blue-50 p-4 rounded-lg border border-blue-200'>
                            <h4 class='font-semibold text-blue-700 mb-2'><i class='fas fa-plus-circle mr-2'></i>Creación de Tareas</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Asignación múltiple de usuarios</li>
                                <li>• Definición de fechas límite</li>
                                <li>• Categorización por tipo</li>
                                <li>• Observaciones iniciales</li>
                            </ul>
                        </div>
                        <div class='bg-green-50 p-4 rounded-lg border border-green-200'>
                            <h4 class='font-semibold text-green-700 mb-2'><i class='fas fa-calendar mr-2'></i>Vista de Calendario</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Visualización mensual</li>
                                <li>• Filtros por estado</li>
                                <li>• Drag & drop para cambios</li>
                                <li>• Vista de equipo</li>
                            </ul>
                        </div>
                    </div>
                    <div class='space-y-4'>
                        <div class='bg-purple-50 p-4 rounded-lg border border-purple-200'>
                            <h4 class='font-semibold text-purple-700 mb-2'><i class='fas fa-chart-bar mr-2'></i>Reportes y Gráficos</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Estadísticas por estado</li>
                                <li>• Tareas por tipo</li>
                                <li>• Progreso mensual</li>
                                <li>• Productividad del equipo</li>
                            </ul>
                        </div>
                        <div class='bg-orange-50 p-4 rounded-lg border border-orange-200'>
                            <h4 class='font-semibold text-orange-700 mb-2'><i class='fas fa-comments mr-2'></i>Sistema de Observaciones</h4>
                            <ul class='text-sm text-gray-600 space-y-1'>
                                <li>• Comentarios en tiempo real</li>
                                <li>• Historial de cambios</li>
                                <li>• Notificaciones automáticas</li>
                                <li>• Seguimiento detallado</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class='mb-6'>
                <h3 class='font-semibold mb-3 text-gray-700'>Características del Sistema</h3>
                <ul class='space-y-2 text-sm text-gray-600'>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Asignación múltiple:</strong> Una tarea puede ser asignada a varios usuarios simultáneamente</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Control de tiempo:</strong> Cálculo automático de días restantes y alertas de vencimiento</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Observaciones:</strong> Sistema de comentarios para seguimiento detallado</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Vista de calendario:</strong> Visualización mensual con drag & drop</span></li>
                    <li class='flex items-start'><i class='fas fa-check text-green-500 mr-2 mt-1'></i><span><strong>Reportes avanzados:</strong> Gráficos y estadísticas de productividad</span></li>
                </ul>
            </div>`
        }
    };

    // Asignar eventos a los enlaces del navbar
    window.addEventListener('DOMContentLoaded', function() {
        const detalle = document.getElementById('detalleModulo');
        const manualCompleto = document.getElementById('manualCompleto');
        // Buscar todos los enlaces de módulos
        const modLinks = [
            'dashboard','usuarios','funcionarios','funcionariosplanta','funcionariosops','permisos','contratos','vacaciones','viaticos','inventario','tareas','publicaciones','archivos','auditoria','configuracion','interfaz'
        ];
        modLinks.forEach(mod => {
            // Solo asignar evento a los módulos, NO a introduccion ni acceso
            if(mod === 'introduccion' || mod === 'acceso') return;
            const link = document.querySelector(`a[href=\"#${mod}\"]`);
            if(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Mostrar solo el panel de detalle
                    detalle.innerHTML = modulos[mod].html;
                    manualCompleto.style.display = 'none';
                    // Asignar evento al botón para mostrar el manual completo
                    setTimeout(() => {
                        const btn = document.getElementById('btnVerManualCompleto');
                        if(btn) {
                            btn.onclick = function() {
                                detalle.innerHTML = '';
                                manualCompleto.style.display = '';
                            };
                        }
                    }, 100);
                });
            }
        });
        // Botón para volver al panel de módulos
        const btnVolver = document.getElementById('btnVolverDetalle');
        if(btnVolver) {
            btnVolver.onclick = function() {
                manualCompleto.style.display = 'none';
                detalle.innerHTML = `<h2 class='text-2xl font-bold mb-4 text-blue-800'>Bienvenido al Manual de Usuario</h2><p class='text-gray-700'>Selecciona un módulo en el menú lateral para ver su explicación detallada aquí.</p>`;
            };
        }
    });
</script>
<?php include 'layout/footerManual.php'; ?>