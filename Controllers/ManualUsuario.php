<?php

class ManualUsuario extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        // El manual es público, no requiere autenticación
    }

    public function index()
    {
        // Método principal para acceso directo
        $this->manual();
    }

    public function manualusuario()
    {
        // Método para acceso directo desde la URL /manualusuario
        $this->manual();
    }

    public function manual()
    {
        $data['page_id'] = 999; // ID especial para el manual
        $data['page_tag'] = "Manual de Usuario";
        $data['page_title'] = "Manual de Usuario - SAMICAM";
        $data['page_name'] = "manual_usuario";
        $data['page_functions_js'] = "functions_manual_usuario.js";
        
        // Datos adicionales para el manual
        $data['version_sistema'] = "2.1";
        $data['fecha_actualizacion'] = "15/06/2023";
        $data['soporte_email'] = "soporte@samicam.gov.co";
        $data['soporte_telefono'] = "+57 (1) 123-4567";
        
        // Cargar la vista del manual
        $this->views->getView($this, "manual", $data);
    }

    public function descargarPDF()
    {
     
        $arrResponse = array(
            'status' => true, 
            'msg' => 'Función de descarga PDF en desarrollo'
        );
        
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function descargarDOCX()
    {
       
        $arrResponse = array(
            'status' => true, 
            'msg' => 'Función de descarga DOCX en desarrollo'
        );
        
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function obtenerCapturas()
    {
        // Función para obtener las capturas de pantalla del manual
        // Accesible para todos los usuarios

        // Lista de capturas de pantalla disponibles
        $capturas = [
            [
                'modulo' => 'Dashboard',
                'imagen' => 'dashboard_principal.png',
                'descripcion' => 'Vista principal del dashboard con estadísticas'
            ],
            [
                'modulo' => 'Funcionarios',
                'imagen' => 'funcionarios_lista.png',
                'descripcion' => 'Lista de funcionarios con opciones de gestión'
            ],
            [
                'modulo' => 'Permisos',
                'imagen' => 'permisos_diarios.png',
                'descripcion' => 'Panel de control de permisos diarios'
            ],
            [
                'modulo' => 'Inventario',
                'imagen' => 'inventario_equipos.png',
                'descripcion' => 'Gestión de equipos del inventario'
            ]
        ];

        $arrResponse = array(
            'status' => true, 
            'data' => $capturas
        );
        
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function buscarManual()
    {
        // Función para buscar contenido en el manual
        // Accesible para todos los usuarios

        $termino = isset($_POST['termino']) ? strClean($_POST['termino']) : '';
        
        if (empty($termino)) {
            $arrResponse = array(
                'status' => false, 
                'msg' => 'Debe ingresar un término de búsqueda'
            );
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        // Aquí se implementaría la búsqueda en el contenido del manual
        // Por ahora retornamos un resultado de ejemplo
        $resultados = [
            [
                'seccion' => 'Dashboard',
                'titulo' => 'Panel Principal',
                'contenido' => 'Encontró coincidencias en la sección del Dashboard...',
                'url' => '#dashboard'
            ]
        ];

        $arrResponse = array(
            'status' => true, 
            'data' => $resultados,
            'total' => count($resultados)
        );
        
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function obtenerEstadisticasManual()
    {
        // Función para obtener estadísticas de uso del manual
        // Accesible para todos los usuarios

        // Estadísticas de ejemplo
        $estadisticas = [
            'total_visitas' => 1250,
            'seccion_mas_vista' => 'Dashboard',
            'tiempo_promedio' => '8 minutos',
            'usuarios_activos' => 45
        ];

        $arrResponse = array(
            'status' => true, 
            'data' => $estadisticas
        );
        
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function enviarFeedback()
    {
        // Función para enviar feedback sobre el manual
        // Accesible para todos los usuarios

        if ($_POST) {
            $tipo = strClean($_POST['tipo']);
            $mensaje = strClean($_POST['mensaje']);
            $seccion = strClean($_POST['seccion']);
            $usuario = isset($_SESSION['userData']['nombre']) ? $_SESSION['userData']['nombre'] : 'Visitante';

            if (empty($mensaje)) {
                $arrResponse = array(
                    'status' => false, 
                    'msg' => 'Debe ingresar un mensaje'
                );
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }

            // Aquí se guardaría el feedback en la base de datos
            // Por ahora solo retornamos éxito
            $arrResponse = array(
                'status' => true, 
                'msg' => 'Feedback enviado correctamente. Gracias por su contribución.'
            );
            
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function obtenerVersion()
    {
        // Función para obtener información de la versión del manual
        // Accesible para todos los usuarios
        $info = [
            'version' => '2.1',
            'fecha_actualizacion' => '15/06/2023',
            'ultima_revision' => '20/06/2023',
            'desarrollador' => 'Equipo SAMICAM',
            'compatibilidad' => 'Chrome 80+, Firefox 74+, Edge 80+'
        ];

        $arrResponse = array(
            'status' => true, 
            'data' => $info
        );
        
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
} 