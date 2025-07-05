<?php include 'layout/headerManual.php'; ?>
<div class="flex flex-col md:flex-row container mx-auto px-4 py-6">
    <?php include 'layout/navbarMManual.php'; ?>
    <main class="flex-1 bg-white rounded-lg shadow-md p-6">
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