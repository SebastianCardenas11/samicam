<?php
    class Tareas extends Controllers
    {
        public function __construct()
        {
            parent::__construct();
            session_start();
            if(empty($_SESSION['login']))
            {
                header('Location: '.base_url().'/login');
                die();
            }
            getPermisos(11); 
        }

        public function Tareas()
        {
            if(empty($_SESSION['permisosMod']['r'])){
                header("Location:".base_url().'/dashboard');
            }
            
            $data['page_tag'] = "Tareas";
            $data['page_title'] = "Tareas";
            $data['page_name'] = "Tareas";
            $data['page_functions_js'] = "functions_tareas.js";
            $data['usuarios_asignables'] = $this->model->getUsuariosAsignables();
            $this->views->getView($this,"tareas",$data);
        }

        public function getTareas()
        {
            header('Content-Type: application/json');
            
            try {
                if($_SESSION['userData']['idrol'] == 1) { // Super Admin
                    // Puede ver todas las tareas
                    $arrData = $this->model->getTareas();
                } else {
                    // Solo ve las tareas asignadas a él
                    $arrData = $this->model->getTareasByUsuarioAsignado($_SESSION['idUser']);
                }

                for ($i=0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';
                    $btnComplete = '';
                    $btnStart = '';

                    // Calcular tiempo restante
                    $fechaActual = new DateTime();
                    $fechaFin = new DateTime($arrData[$i]['fecha_fin']);
                    $intervalo = $fechaActual->diff($fechaFin);
                    
                    if($fechaFin < $fechaActual) {
                        $arrData[$i]['tiempo_restante'] = 'Vencida';
                    } else {
                        $arrData[$i]['tiempo_restante'] = $intervalo->days.' días';
                    }

                    // Permisos para botones
                    if($_SESSION['permisosMod']['r']){
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewTarea('.$arrData[$i]['id_tarea'].')"><i class="far fa-eye"></i></button>';
                    }

                    // Si la tarea está completada, solo mostrar el botón de ver
                    if($arrData[$i]['estado'] == 'completada') {
                        $arrData[$i]['options'] = '<div class="text-center">'.$btnView.'</div>';
                        continue; // Saltar al siguiente ciclo
                    }

                    // Si es el creador de la tarea
                    if($_SESSION['idUser'] == $arrData[$i]['id_usuario_creador'] && $_SESSION['permisosMod']['u']){
                        // Solo mostrar botón de editar si la tarea está sin empezar
                        if($arrData[$i]['estado'] == 'sin empezar') {
                            $btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditTarea('.$arrData[$i]['id_tarea'].')"><i class="fas fa-pencil-alt"></i></button>';
                        }
                        
                        // Solo mostrar botón de completar si la tarea está en curso
                        if($arrData[$i]['estado'] == 'en curso') {
                            $btnComplete = '<button class="btn btn-success btn-sm" onClick="fntCompleteTarea('.$arrData[$i]['id_tarea'].')"><i class="fas fa-check"></i></button>';
                        }
                        
                        if($_SESSION['permisosMod']['d']){
                            $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelTarea('.$arrData[$i]['id_tarea'].')"><i class="far fa-trash-alt"></i></button>';
                        }
                    }

                    // Verificar si el usuario actual está entre los asignados a la tarea
                    $esUsuarioAsignado = $this->model->esUsuarioAsignadoATarea($arrData[$i]['id_tarea'], $_SESSION['idUser']);
                    
                    // Si es un usuario asignado y la tarea está sin empezar
                    if($esUsuarioAsignado && $arrData[$i]['estado'] == 'sin empezar'){
                        $btnStart = '<button class="btn btn-warning btn-sm" onClick="fntStartTarea('.$arrData[$i]['id_tarea'].')"><i class="fas fa-play"></i></button>';
                    }

                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.' '.$btnComplete.' '.$btnStart.'</div>';
                }
                
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            die();
        }

        public function getTareasCalendario()
        {
            header('Content-Type: application/json');
            
            try {
                if($_SESSION['userData']['idrol'] == 1) { // Super Admin
                    // Puede ver todas las tareas
                    $arrData = $this->model->getTareas();
                } else {
                    // Solo ve las tareas asignadas a él
                    $arrData = $this->model->getTareasByUsuarioAsignado($_SESSION['idUser']);
                }

                $eventos = [];
                foreach ($arrData as $tarea) {
                    $color = '#6c757d'; 
                    if($tarea['estado'] == 'en curso') {
                        $color = '#007bff'; 
                    } else if($tarea['estado'] == 'completada') {
                        $color = '#28a745';
                    }

                    $eventos[] = [
                        'id' => $tarea['id_tarea'],
                        'title' => $tarea['descripcion'],
                        'start' => $tarea['fecha_inicio'],
                        'end' => $tarea['fecha_fin'],
                        'color' => $color,
                        'extendedProps' => [
                            'tipo' => $tarea['tipo'],
                            'dependencia' => $tarea['dependencia_nombre'],
                            'asignado' => $tarea['asignado_nombre'],
                            'creador' => $tarea['creador_nombre'],
                            'estado' => $tarea['estado'],
                            'descripcion' => $tarea['descripcion']
                        ]
                    ];
                }
                
                echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            die();
        }

        public function getTarea($idtarea)
        {
            $idtarea = intval($idtarea);
            if($idtarea > 0)
            {
                $arrData = $this->model->getTarea($idtarea);
                if(empty($arrData))
                {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }else{
                    // Calcular tiempo restante
                    $fechaActual = new DateTime();
                    $fechaFin = new DateTime($arrData['fecha_fin']);
                    $intervalo = $fechaActual->diff($fechaFin);
                    
                    if($fechaFin < $fechaActual) {
                        $arrData['tiempo_restante'] = 'Vencida';
                    } else {
                        $arrData['tiempo_restante'] = $intervalo->days.' días';
                    }
                    
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                header('Content-Type: application/json');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function setTarea()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Debug: Log todos los datos POST
                error_log("=== DEBUG TAREAS ===");
                error_log("POST data: " . print_r($_POST, true));
                
                $id_tarea = isset($_POST['idTarea']) ? intval($_POST['idTarea']) : 0;
                $id_usuario_creador = $_SESSION['idUser'];
                $usuarios_asignados = isset($_POST['usuariosIds']) ? $_POST['usuariosIds'] : [];
                $tipo = isset($_POST['listTipo']) ? $_POST['listTipo'] : '';
                $descripcion = isset($_POST['txtDescripcion']) ? $_POST['txtDescripcion'] : '';
                $dependencia_fk = isset($_POST['listDependencia']) ? intval($_POST['listDependencia']) : 0;
                $fecha_inicio = isset($_POST['txtFechaInicio']) ? $_POST['txtFechaInicio'] : '';
                $fecha_fin = isset($_POST['txtFechaFin']) ? $_POST['txtFechaFin'] : '';
                $observacion = isset($_POST['txtObservacion']) ? $_POST['txtObservacion'] : '';

                // Debug: Log las variables procesadas
                error_log("Variables procesadas:");
                error_log("id_tarea: " . $id_tarea);
                error_log("usuarios_asignados: " . print_r($usuarios_asignados, true));
                error_log("tipo: " . $tipo);
                error_log("descripcion: " . $descripcion);
                error_log("dependencia_fk: " . $dependencia_fk);
                error_log("fecha_inicio: " . $fecha_inicio);
                error_log("fecha_fin: " . $fecha_fin);
                error_log("observacion: " . $observacion);

                // Verificar permisos
                if ($id_tarea == 0) {
                    // Crear nueva tarea
                    if (empty($_SESSION['permisosMod']['w'])) {
                        $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para crear tareas.');
                        echo json_encode($arrResponse);
                        return;
                    }
                } else {
                    // Editar tarea existente
                    if (empty($_SESSION['permisosMod']['u'])) {
                        $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para editar tareas.');
                        echo json_encode($arrResponse);
                        return;
                    }
                }

                // Validar datos
                if (empty($tipo) || empty($descripcion) || empty($fecha_inicio) || empty($fecha_fin) || empty($usuarios_asignados)) {
                    $arrResponse = array('status' => false, 'msg' => 'Todos los campos son obligatorios.');
                    echo json_encode($arrResponse);
                    return;
                }

                // Procesar usuarios asignados - convertir de string a array
                if (is_string($usuarios_asignados)) {
                    $usuarios_asignados = !empty($usuarios_asignados) ? explode(',', $usuarios_asignados) : [];
                }
                $usuarios_asignados = is_array($usuarios_asignados) ? $usuarios_asignados : [$usuarios_asignados];

                // Crear o actualizar tarea
                $request_tarea = $this->model->insertTarea(
                    $id_usuario_creador,
                    $usuarios_asignados,
                    $tipo,
                    $descripcion,
                    $dependencia_fk,
                    $fecha_inicio,
                    $fecha_fin,
                    $observacion
                );

                if ($request_tarea > 0) {
                    // Enviar notificaciones a los usuarios asignados
                    require_once "Models/NotificacionesModel.php";
                    $notificacionesModel = new NotificacionesModel();
                    
                    // Obtener información completa de los usuarios asignados
                    $usuarios_info = $this->model->getUsuariosInfoCompleta($usuarios_asignados);
                    
                    // Enviar notificaciones internas del sistema
                    foreach ($usuarios_asignados as $id_usuario) {
                        $mensaje = "Se te ha asignado una nueva tarea: " . $descripcion;
                        $notificacionesModel->insertNotificacion($id_usuario, 'tarea', $mensaje);
                    }
                    
                    // Enviar notificaciones de WhatsApp (solo para nuevas tareas)
                    if ($id_tarea == 0 && !empty($usuarios_info)) {
                        $this->enviarNotificacionesWhatsApp($usuarios_info, [
                            'descripcion' => $descripcion,
                            'tipo' => $tipo,
                            'dependencia_nombre' => $this->getDependenciaNombre($dependencia_fk),
                            'fecha_inicio' => $fecha_inicio,
                            'fecha_fin' => $fecha_fin,
                            'observacion' => $observacion
                        ]);
                    }

                    if ($id_tarea == 0) {
                        $arrResponse = array('status' => true, 'msg' => 'Tarea creada correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Tarea actualizada correctamente.');
                    }
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al procesar la tarea.');
                }
                echo json_encode($arrResponse);
            }
            die();
        }

        public function startTarea()
        {
            $idTarea = intval($_POST['idTarea']);
            
            // Verificar si es el usuario asignado
            $arrTarea = $this->model->getTarea($idTarea);
            
            // Verificar si el usuario actual está entre los asignados
            $esUsuarioAsignado = $this->model->esUsuarioAsignadoATarea($idTarea, $_SESSION['idUser']);
            
            if(!$esUsuarioAsignado) {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para iniciar esta tarea.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            // Verificar que la tarea esté sin empezar
            if($arrTarea['estado'] != 'sin empezar') {
                $arrResponse = array('status' => false, 'msg' => 'La tarea ya ha sido iniciada o completada.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            $request_tarea = $this->model->updateEstadoTarea($idTarea, 'en curso');
            
            if($request_tarea > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Tarea iniciada correctamente.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al iniciar la tarea.');
            }
            
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function completeTarea()
        {
            $idTarea = intval($_POST['idTarea']);
            
            // Verificar si es el creador de la tarea
            $arrTarea = $this->model->getTarea($idTarea);
            if($arrTarea['id_usuario_creador'] != $_SESSION['idUser']) {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para completar esta tarea.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }
            
            // Verificar que la tarea esté en curso
            if($arrTarea['estado'] != 'en curso') {
                $arrResponse = array('status' => false, 'msg' => 'Solo se pueden completar tareas que estén en curso.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            $request_tarea = $this->model->updateEstadoTarea($idTarea, 'completada');
            
            if($request_tarea > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Tarea completada correctamente.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al completar la tarea.');
            }
            
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function addObservacion()
        {
            $idTarea = intval($_POST['idTarea']);
            $observacion = strClean($_POST['txtObservacion']);
            
            // Verificar si es el usuario asignado
            $arrTarea = $this->model->getTarea($idTarea);
            
            // Verificar si el usuario actual está entre los asignados
            $esUsuarioAsignado = $this->model->esUsuarioAsignadoATarea($idTarea, $_SESSION['idUser']);
            
            if(!$esUsuarioAsignado) {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para agregar observaciones a esta tarea.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            // Verificar que la tarea no esté completada
            if($arrTarea['estado'] == 'completada') {
                $arrResponse = array('status' => false, 'msg' => 'No se puede agregar observaciones a una tarea completada.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            // Verificar que no haya vencido la fecha de fin
            $fechaActual = new DateTime();
            $fechaFin = new DateTime($arrTarea['fecha_fin']);
            if($fechaFin < $fechaActual) {
                $arrResponse = array('status' => false, 'msg' => 'No se puede agregar observaciones a una tarea vencida.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            $request_obs = $this->model->insertObservacion($idTarea, $_SESSION['idUser'], $observacion);
            
            if($request_obs > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Observación agregada correctamente.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al agregar la observación.');
            }
            
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        
        public function getObservaciones($idtarea)
        {
            $idtarea = intval($idtarea);
            if($idtarea > 0)
            {
                $arrData = $this->model->getObservacionesTarea($idtarea);
                if(empty($arrData))
                {
                    $arrResponse = array('status' => false, 'msg' => 'No hay observaciones para esta tarea.');
                }else{
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                header('Content-Type: application/json');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function delTarea()
        {
            $idTarea = intval($_POST['idTarea']);
            
            // Verificar si es el creador de la tarea
            $arrTarea = $this->model->getTarea($idTarea);
            if($arrTarea['id_usuario_creador'] != $_SESSION['idUser']) {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para eliminar esta tarea.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            $request_delete = $this->model->deleteTarea($idTarea);
            if($request_delete)
            {
                $arrResponse = array('status' => true, 'msg' => 'Tarea eliminada correctamente.');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la tarea.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getUsuariosAsignables()
        {
            header('Content-Type: application/json');
            $arrData = $this->model->getUsuariosAsignables();
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getDependencias()
        {
            $htmlOptions = "";
            $arrData = $this->model->getDependencias();
            if(count($arrData) > 0 ){
                for ($i=0; $i < count($arrData); $i++) { 
                    $htmlOptions .= '<option value="'.$arrData[$i]['dependencia_pk'].'">'.$arrData[$i]['nombre'].'</option>';
                }
            }
            echo $htmlOptions;
            die();
        }

        /**
         * Envía notificaciones de WhatsApp a los usuarios asignados
         * @param array $usuarios_info Información de los usuarios
         * @param array $tarea_info Información de la tarea
         */
        private function enviarNotificacionesWhatsApp($usuarios_info, $tarea_info)
        {
            try {
                // Incluir el helper de WhatsApp
                require_once "Helpers/WhatsAppHelper.php";
                $whatsappHelper = new WhatsAppHelper();
                
                // Configurar API key (deberías obtener esto de configuración)
                // $whatsappHelper->setApiKey('TU_API_KEY_AQUI');
                
                // Enviar notificaciones
                $resultados = $whatsappHelper->sendTareaNotification($usuarios_info, $tarea_info);
                
                // Log de resultados
                foreach ($resultados as $resultado) {
                    if ($resultado['enviado']) {
                        error_log("WhatsApp enviado a {$resultado['nombre']} ({$resultado['telefono']})");
                    } else {
                        error_log("Error enviando WhatsApp a {$resultado['nombre']}: {$resultado['mensaje']}");
                    }
                }
                
            } catch (Exception $e) {
                error_log("Error en envío de WhatsApp: " . $e->getMessage());
            }
        }
        
        /**
         * Obtiene el nombre de la dependencia por ID
         * @param int $dependencia_id ID de la dependencia
         * @return string Nombre de la dependencia
         */
        private function getDependenciaNombre($dependencia_id)
        {
            $sql = "SELECT nombre FROM tbl_dependencia WHERE dependencia_pk = ?";
            $result = $this->model->select($sql, [$dependencia_id]);
            return $result ? $result['nombre'] : 'Sin dependencia';
        }

        public function getEstadisticasTareas()
        {
            if($_SESSION['permisosMod']['r'] && $_SESSION['userData']['idrol'] == 1){
                $arrData = array();
                $modelTareas = new TareasModel();

                // Obtener estadísticas por estado
                $arrData['estadoTareas'] = array(
                    'completadas' => $modelTareas->countTareasPorEstado(2), // 2 = Completada
                    'enCurso' => $modelTareas->countTareasPorEstado(1), // 1 = En curso
                    'sinEmpezar' => $modelTareas->countTareasPorEstado(0), // 0 = Sin empezar
                    'vencidas' => $modelTareas->countTareasVencidas()
                );

                // Obtener estadísticas por tipo
                $arrData['tiposTarea'] = $modelTareas->getTareasPorTipo();

                // Obtener tareas completadas por mes (últimos 12 meses)
                $arrData['tareasCompletadas'] = $modelTareas->getTareasCompletadasPorMes();

                $arrData['success'] = true;
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array('success' => false, 'msg' => 'Acceso denegado'), JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>