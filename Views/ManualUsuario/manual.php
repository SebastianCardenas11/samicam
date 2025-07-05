<?php include 'layout/headerManual.php'; ?>
<?php include 'layout/navbarMManual.php'; ?>
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
                                <li><strong>Campo Usuario:</strong> Ingrese su nombre de usuario asignado (ej: jperez)</li>
                                <li><strong>Campo Contraseña:</strong> Ingrese su contraseña (sensible a mayúsculas)</li>
                                <li><strong>Botón "Ingresar":</strong> Inicia el proceso de autenticación</li>
                                <li><strong>Enlace "¿Olvidó su contraseña?":</strong> Inicia proceso de recuperación</li>
                                <li><strong>Selector de Idioma:</strong> Cambia el idioma de la interfaz</li>
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">1</span>
                                Ingreso de Credenciales
                            </h4>
                            <p class="text-sm text-gray-600">Introduzca su nombre de usuario y contraseña en los campos correspondientes. Asegúrese de que el teclado no tenga activado el bloqueo de mayúsculas.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">2</span>
                                Autenticación
                            </h4>
                            <p class="text-sm text-gray-600">Al hacer clic en "Ingresar", el sistema validará sus credenciales. Si son correctas, será redirigido al Dashboard principal.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">3</span>
                                Primer Acceso
                            </h4>
                            <p class="text-sm text-gray-600">En su primer ingreso, el sistema le solicitará cambiar su contraseña temporal por una permanente.</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <h4 class="font-medium mb-2 text-gray-700 flex items-center">
                                <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">4</span>
                                Recuperación de Acceso
                            </h4>
                            <p class="text-sm text-gray-600">Si olvida su contraseña, haga clic en el enlace correspondiente y siga las instrucciones para restablecerla.</p>
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

                <h3 class="text-xl font-semibold mb-3 text-gray-700">3.2 Elementos Comunes</h3>
                
                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Botones de Acción</h4>
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
                            <p class="text-xs text-center text-gray-600">Modifica registro seleccionado</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-red-600 text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-trash mr-2"></i> Eliminar
                            </button>
                            <p class="text-xs text-center text-gray-600">Borra registro (con confirmación)</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg border border-gray-200 shadow-sm flex flex-col items-center">
                            <button class="bg-green-600 text-white px-4 py-2 rounded mb-2 flex items-center">
                                <i class="fas fa-save mr-2"></i> Guardar
                            </button>
                            <p class="text-xs text-center text-gray-600">Guarda cambios en formulario</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Tipos de Campos de Formulario</h4>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Campo de Texto <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: Nombre completo">
                                <p class="mt-1 text-xs text-gray-500">Ingrese información alfanumérica. Campos obligatorios marcados con <span class="text-red-500">*</span>.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Campo Numérico</label>
                                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Ej: 12345">
                                <p class="mt-1 text-xs text-gray-500">Solo acepta valores numéricos. Puede incluir decimales.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Selector (Dropdown)</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Seleccione una opción</option>
                                    <option value="1">Opción 1</option>
                                    <option value="2">Opción 2</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Lista desplegable de opciones predefinidas.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Campo de Fecha</label>
                                <div class="relative">
                                    <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Seleccione fecha usando el calendario integrado.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-medium mb-2 text-gray-700">Tablas de Datos</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">ID</th>
                                    <th class="py-2 px-4 border-b text-left">Nombre</th>
                                    <th class="py-2 px-4 border-b text-left">Cargo</th>
                                    <th class="py-2 px-4 border-b text-left">Estado</th>
                                    <th class="py-2 px-4 border-b text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b">001</td>
                                    <td class="py-2 px-4 border-b">Juan Pérez</td>
                                    <td class="py-2 px-4 border-b">Administrador</td>
                                    <td class="py-2 px-4 border-b"><span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Activo</span></td>
                                    <td class="py-2 px-4 border-b">
                                        <button class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-yellow-600 hover:text-yellow-800 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="bg-gray-50">
                                    <td class="py-2 px-4 border-b">002</td>
                                    <td class="py-2 px-4 border-b">María Gómez</td>
                                    <td class="py-2 px-4 border-b">Supervisor</td>
                                    <td class="py-2 px-4 border-b"><span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Pendiente</span></td>
                                    <td class="py-2 px-4 border-b">
                                        <button class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-eye"></i></button>
                                        <button class="text-yellow-600 hover:text-yellow-800 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <h5 class="font-medium text-sm mb-1">Funcionalidades de tablas:</h5>
                        <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                            <li><strong>Ordenamiento:</strong> Haga clic en los encabezados para ordenar ascendente/descendente</li>
                            <li><strong>Paginación:</strong> Navegue entre páginas de resultados</li>
                            <li><strong>Búsqueda:</strong> Use el campo de búsqueda para filtrar registros</li>
                            <li><strong>Exportar:</strong> Botones para exportar a Excel, PDF o CSV</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Módulos Principales -->
            <section id="modulos" class="mb-12">
                <h2 class="text-2xl font-bold mb-4 text-blue-800 border-b pb-2">4. Módulos Principales</h2>
                
                <!-- Dashboard -->
                <section id="dashboard" class="mb-8">
                    <h3 class="text-xl font-semibold mb-3 text-gray-700">4.1 Dashboard Administrativo</h3>
                    <div class="bg-blue-50 p-4 rounded-lg mb-4">
                        <p class="text-blue-800"><strong>Propósito:</strong> El Dashboard proporciona una visión general de las estadísticas y métricas clave del sistema, permitiendo un rápido acceso a la información más relevante.</p>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 mb-6">
                        <div class="md:w-2/3">
                            <img src="https://via.placeholder.com/800x500?text=Dashboard+SAMICAM" alt="Dashboard" class="w-full rounded-lg screenshot mb-4">
                            <div class="text-sm text-gray-500 text-center">Figura 3: Vista del Dashboard Administrativo</div>
                        </div>
                        <div class="md:w-1/3">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="font-medium mb-2 text-gray-700">Componentes principales:</h4>
                                <ol class="list-decimal pl-5 space-y-2">
                                    <li><strong>Tarjetas Resumen:</strong> Muestran conteos rápidos (usuarios, tareas, etc.)</li>
                                    <li><strong>Gráfico de Barras:</strong> Actividad reciente por área/departamento</li>
                                    <li><strong>Gráfico Circular:</strong> Distribución de funcionarios por tipo</li>
                                    <li><strong>Últimas Notificaciones:</strong> Alertas y mensajes recientes</li>
                                    <li><strong>Tareas Pendientes:</strong> Listado de actividades próximas</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-medium mb-2 text-gray-700">Personalización del Dashboard</h4>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <p class="text-sm text-gray-600 mb-3">Puede personalizar los widgets que aparecen en su dashboard según sus necesidades:</p>
                            <ol class="list-decimal pl-5 space-y-2 text-sm">
                                <li>Haga clic en el botón <button class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs inline-flex items-center"><i class="fas fa-cog mr-1"></i> Configurar</button> en la esquina superior derecha</li>
                                <li>Seleccione los widgets que desea mostrar/ocultar marcando las casillas correspondientes</li>
                                <li>Arrastre y suelte los widgets para reorganizar su disposición</li>
                                <li>Haga clic en <button class="bg-blue-600 text-white px-2 py-1 rounded text-xs">Guardar Configuración</button> para aplicar los cambios</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Gestión de Usuarios -->
                <section id="usuarios" class="mb-8">
                    <h3 class="text-xl font-semibold mb-3 text-gray-700">4.2 Gestión de Usuarios</h3>
                    <div class="bg-blue-50 p-4 rounded-lg mb-4">
                        <p class="text-blue-800"><strong>Propósito:</strong> Este módulo permite administrar todas las cuentas de usuario del sistema, asignar roles y permisos, y gestionar el acceso a las diferentes funcionalidades.</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-medium mb-2 text-gray-700">Listado de Usuarios</h4>
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">ID</th>
                                        <th class="py-2 px-4 border-b text-left">Usuario</th>
                                        <th class="py-2 px-4 border-b text-left">Nombre Completo</th>
                                        <th class="py-2 px-4 border-b text-left">Correo</th>
                                        <th class="py-2 px-4 border-b text-left">Rol</th>
                                        <th class="py-2 px-4 border-b text-left">Estado</th>
                                        <th class="py-2 px-4 border-b text-left">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-2 px-4 border-b">001</td>
                                        <td class="py-2 px-4 border-b">jperez</td>
                                        <td class="py-2 px-4 border-b">Juan Pérez</td>
                                        <td class="py-2 px-4 border-b">jperez@municipalidad.cl</td>
                                        <td class="py-2 px-4 border-b">Administrador</td>
                                        <td class="py-2 px-4 border-b"><span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Activo</span></td>
                                        <td class="py-2 px-4 border-b">
                                            <button class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-eye"></i></button>
                                            <button class="text-yellow-600 hover:text-yellow-800 mr-2"><i class="fas fa-edit"></i></button>
                                            <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <div class="text-sm text-gray-500">Mostrando 1-10 de 25 usuarios</div>
                            <div class="flex space-x-1">
                                <button class="px-3 py-1 border rounded text-sm bg-gray-100"><i class="fas fa-angle-left"></i></button>
                                <button class="px-3 py-1 border rounded text-sm bg-blue-600 text-white">1</button>
                                <button class="px-3 py-1 border rounded text-sm">2</button>
                                <button class="px-3 py-1 border rounded text-sm">3</button>
                                <button class="px-3 py-1 border rounded text-sm"><i class="fas fa-angle-right"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-medium mb-2 text-gray-700">Creación de Nuevo Usuario</h4>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <p class="text-sm text-gray-600 mb-3">Para agregar un nuevo usuario al sistema:</p>
                            <ol class="list-decimal pl-5 space-y-3 text-sm">
                                <li>Haga clic en el botón <button class="bg-blue-600 text-white px-2 py-1 rounded text-xs inline-flex items-center"><i class="fas fa-plus mr-1"></i> Nuevo Usuario</button> en la esquina superior derecha</li>
                                <li>Complete el formulario con los datos del usuario:
                                    <ul class="list-disc pl-5 mt-1 space-y-1">
                                        <li><strong>Nombre de usuario:</strong> Identificador único (ej: jperez)</li>
                                        <li><strong>Contraseña temporal:</strong> El usuario deberá cambiarla en su primer acceso</li>
                                        <li><strong>Datos personales:</strong> Nombre completo, correo, teléfono</li>
                                        <li><strong>Rol:</strong> Seleccione el rol del usuario (determina permisos)</li>
                                        <li><strong>Dependencia:</strong> Asigne la unidad/departamento correspondiente</li>
                                    </ul>
                                </li>
                                <li>Haga clic en <button class="bg-green-600 text-white px-2 py-1 rounded text-xs">Guardar Usuario</button> para crear el registro</li>
                                <li>El sistema enviará un correo al nuevo usuario con instrucciones para su primer acceso</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Funcionarios -->
                <section id="funcionarios" class="mb-8">
                    <h3 class="text-xl font-semibold mb-3 text-gray-700">4.3 Gestión de Funcionarios</h3>
                    <div class="bg-blue-50 p-4 rounded-lg mb-4">
                        <p class="text-blue-800"><strong>Propósito:</strong> Este módulo permite administrar toda la información relacionada con los funcionarios municipales, tanto de planta como OPS, incluyendo datos personales, laborales y contractuales.</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-medium mb-2 text-gray-700">Tipos de Funcionarios</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h5 class="font-medium text-blue-700 mb-2 flex items-center">
                                    <i class="fas fa-user-tie mr-2"></i> Funcionarios de Planta
                                </h5>
                                <p class="text-sm text-gray-600">Personal con nombramiento permanente en la municipalidad. Incluye:</p>
                                <ul class="list-disc pl-5 mt-1 text-sm text-gray-600 space-y-1">
                                    <li>Datos contractuales completos</li>
                                    <li>Historial de ascensos y cambios de cargo</li>
                                    <li>Beneficios y asignaciones especiales</li>
                                </ul>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <h5 class="font-medium text-blue-700 mb-2 flex items-center">
                                    <i class="fas fa-user-clock mr-2"></i> Funcionarios OPS
                                </h5>
                                <p class="text-sm text-gray-600">Personal contratado por honorarios o a plazo fijo. Incluye:</p>
                                <ul class="list-disc pl-5 mt-1 text-sm text-gray-600 space-y-1">
                                    <li>Control de contratos y renovaciones</li>
                                    <li>Seguimiento de horas trabajadas</li>
                                    <li>Documentación contractual</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-medium mb-2 text-gray-700">Proceso de Registro de Funcionario</h4>
                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                            <ol class="list-decimal pl-5 space-y-3 text-sm">
                                <li>Seleccione el tipo de funcionario (Planta u OPS) en el menú superior</li>
                                <li>Haga clic en <button class="bg-blue-600 text-white px-2 py-1 rounded text-xs inline-flex items-center"><i class="fas fa-plus mr-1"></i> Nuevo Funcionario</button></li>
                                <li>Complete el formulario con:
                                    <ul class="list-disc pl-5 mt-1 space-y-1">
                                        <li><strong>Datos personales:</strong> Nombre, RUN, dirección, contacto</li>
                                        <li><strong>Datos laborales:</strong> Cargo, dependencia, fecha ingreso</li>
                                        <li><strong>Información contractual:</strong> Sueldo, tipo de contrato, horario</li>
                                        <li><strong>Documentos:</strong> Suba copia de contrato, documentos legales</li>
                                    </ul>
                                </li>
                                <li>Revise la información y haga clic en <button class="bg-green-600 text-white px-2 py-1 rounded text-xs">Guardar</button></li>
                                <li>El sistema generará automáticamente un correo de bienvenida con las credenciales de acceso</li>
                            </ol>
                        </div>
                    </div>
                </section>

                <!-- Seguimiento de Contratos -->
                <section id="contratos" class="mb-8">
                    <h3 class="text-xl font-semibold mb-3 text-gray-700">4.13 Seguimiento de Contratos</h3>
                    <div class="bg-blue-50 p-4 rounded-lg mb-4">
                        <p class="text-blue-800"><strong>Propósito:</strong> Este módulo permite gestionar todos los contratos municipales, incluyendo su creación, modificación, prórrogas, adiciones y cambio de estados.</p>
                    </div>

                    <h4 class="font-medium mb-2 text-gray-700">Tabla de Contratos</h4>
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b">N° Contrato</th>
                                    <th class="py-2 px-4 border-b">Contratista</th>
                                    <th class="py-2 px-4 border-b">Valor</th>
                                    <th class="py-2 px-4 border-b">Estado</th>
                                    <th class="py-2 px-4 border-b">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b">CT-2023-001</td>
                                    <td class="py-2 px-4 border-b">Constructora XYZ</td>
                                    <td class="py-2 px-4 border-b">$15,000,000</td>
                                    <td class="py-2 px-4 border-b"><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">En ejecución</span></td>
                                    <td class="py-2 px-4 border-b">
                                        <button class="bg-blue-600 text-white p-1 rounded mr-1 tooltip">
                                            <i class="fas fa-eye"></i>
                                            <span class="tooltiptext">Ver Contrato</span>
                                        </button>
                                        <button class="bg-yellow-500 text-white p-1 rounded mr-1 tooltip">
                                            <i class="fas fa-edit"></i>
                                            <span class="tooltiptext">Editar Contrato</span>
                                        </button>
                                        <button class="bg-blue-500 text-white p-1 rounded mr-1 tooltip">
                                            <i class="fas fa-clock"></i>
                                            <span class="tooltiptext">Prórroga</span>
                                        </button>
                                        <button class="bg-green-600 text-white p-1 rounded mr-1 tooltip">
                                            <i class="fas fa-plus-circle"></i>
                                            <span class="tooltiptext">Crear Adición</span>
                                        </button>
                                        <div class="inline-block relative">
                                            <button class="bg-gray-400 text-white p-1 rounded tooltip">
                                                <i class="fas fa-ellipsis-v"></i>
                                                <span class="tooltiptext">Más Opciones</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h4 class="font-medium mb-2 text-gray-700">Pestañas de Navegación</h4>
                    <div class="flex flex-wrap border-b border-gray-200 mb-6">
                        <button class="px-4 py-2 font-medium text-blue-600 border-b-2 border-blue-600">📋 Contratos</button>
                        <button class="px-4 py-2 font-medium text-gray-600 hover:text-blue-600">📊 Gráficos</button>
                        <button class="px-4 py-2 font-medium text-gray-600 hover:text-blue-600">📅 Vencimientos</button>
                        <button class="px-4 py-2 font-medium text-gray-600 hover:text-blue-600">💰 Análisis de Valor</button>
                        <button class="px-4 py-2 font-medium text-gray-600 hover:text-blue-600">📄 Liquidaciones</button>
                    </div>

                    <h4 class="font-medium mb-2 text-gray-700">Formulario de Contrato</h4>
                    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Contrato *</label>
                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="CT-2023-001">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha Aprobación *</label>
                                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Valor Total *</label>
                                <input type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="15000000.50">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Día de Corte Informe</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Seleccione día</option>
                                    <option value="1">1</option>
                                    <option value="15">15</option>
                                    <option value="30">30</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <h4 class="font-medium mb-2 text-gray-700">Estados de Contrato</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs mb-2 inline-block">En ejecución</span>
                            <p class="text-sm">Contrato activo y en proceso. Todas las funciones disponibles.</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs mb-2 inline-block">Finalizado</span>
                            <p class="text-sm">Contrato completado pero no liquidado. Solo ver, editar y cambiar estado.</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mb-2 inline-block">Liquidado</span>
                            <p class="text-sm">Contrato completamente finalizado. Solo consulta disponible.</p>
                        </div>
                    </div>
                </section>
                
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
    </script>

<?php include 'layout/footerManual.php'; ?>