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
            $data['page_title'] = "TAREAS";
            $data['page_name'] = "tareas";
            $data['page_functions_js'] = "functions_tareas.js";
            $this->views->getView($this,"tareas",$data);
        }

        public function getTareas()
        {
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
                    $arrData[$i]['tiempo_restante'] = '<span class="badge badge-danger">Vencida</span>';
                } else {
                    if($intervalo->days > 0) {
                        $arrData[$i]['tiempo_restante'] = '<span class="badge badge-info">'.$intervalo->days.' días</span>';
                    } else {
                        $arrData[$i]['tiempo_restante'] = '<span class="badge badge-warning">'.$intervalo->h.' horas</span>';
                    }
                }

                // Formatear estado
                switch($arrData[$i]['estado']) {
                    case 'sin empezar':
                        $arrData[$i]['estado'] = '<span class="badge badge-secondary">Sin empezar</span>';
                        break;
                    case 'en curso':
                        $arrData[$i]['estado'] = '<span class="badge badge-primary">En curso</span>';
                        break;
                    case 'completada':
                        $arrData[$i]['estado'] = '<span class="badge badge-success">Completada</span>';
                        break;
                }

                // Permisos para botones
                if($_SESSION['permisosMod']['r']){
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewTarea('.$arrData[$i]['id_tarea'].')" title="Ver tarea"><i class="far fa-eye"></i></button>';
                }

                // Si es el creador de la tarea
                if($_SESSION['idUser'] == $arrData[$i]['id_usuario_creador'] && $_SESSION['permisosMod']['u']){
                    $btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditTarea('.$arrData[$i]['id_tarea'].')" title="Editar tarea"><i class="fas fa-pencil-alt"></i></button>';
                    
                    if($arrData[$i]['estado'] != 'completada') {
                        $btnComplete = '<button class="btn btn-success btn-sm" onClick="fntCompleteTarea('.$arrData[$i]['id_tarea'].')" title="Marcar como completada"><i class="fas fa-check"></i></button>';
                    }
                    
                    if($_SESSION['permisosMod']['d']){
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelTarea('.$arrData[$i]['id_tarea'].')" title="Eliminar tarea"><i class="far fa-trash-alt"></i></button>';
                    }
                }

                // Si es el usuario asignado y la tarea está sin empezar
                if($_SESSION['idUser'] == $arrData[$i]['id_usuario_asignado'] && strpos($arrData[$i]['estado'], 'Sin empezar') !== false){
                    $btnStart = '<button class="btn btn-warning btn-sm" onClick="fntStartTarea('.$arrData[$i]['id_tarea'].')" title="Iniciar tarea"><i class="fas fa-play"></i></button>';
                }

                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.' '.$btnComplete.' '.$btnStart.'</div>';
            }
            
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getTareasCalendario()
        {
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
                        'observacion' => $tarea['observacion']
                    ]
                ];
            }
            
            echo json_encode($eventos, JSON_UNESCAPED_UNICODE);
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
                        if($intervalo->days > 0) {
                            $arrData['tiempo_restante'] = $intervalo->days.' días';
                        } else {
                            $arrData['tiempo_restante'] = $intervalo->h.' horas';
                        }
                    }
                    
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function setTarea()
        {
            // Solo el super admin puede crear tareas
            if($_SESSION['userData']['idrol'] != 1) {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para realizar esta acción.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            $idTarea = intval($_POST['idTarea']);
            $idUsuarioAsignado = intval($_POST['listUsuarioAsignado']);
            $tipo = strClean($_POST['listTipo']);
            $descripcion = strClean($_POST['txtDescripcion']);
            $dependencia = intval($_POST['listDependencia']);
            $fechaInicio = $_POST['txtFechaInicio'];
            $fechaFin = $_POST['txtFechaFin'];
            $observacion = strClean($_POST['txtObservacion']);
            $estado = isset($_POST['listEstado']) ? $_POST['listEstado'] : 'sin empezar';

            if($idTarea == 0) // Nueva tarea
            {
                $request_tarea = $this->model->insertTarea($_SESSION['idUser'], $idUsuarioAsignado, $tipo, 
                                                          $descripcion, $dependencia, $fechaInicio, 
                                                          $fechaFin, $observacion);
                $option = 1;
            } else { // Actualizar tarea
                // Verificar si es el creador de la tarea
                $arrTarea = $this->model->getTarea($idTarea);
                if($arrTarea['id_usuario_creador'] != $_SESSION['idUser']) {
                    $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para editar esta tarea.');
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    die();
                }

                $request_tarea = $this->model->updateTarea($idTarea, $idUsuarioAsignado, $tipo, 
                                                          $descripcion, $dependencia, $estado,
                                                          $fechaInicio, $fechaFin, $observacion);
                $option = 2;
            }

            if($request_tarea > 0)
            {
                if($option == 1){
                    $arrResponse = array('status' => true, 'msg' => 'Tarea creada correctamente.');
                }else{
                    $arrResponse = array('status' => true, 'msg' => 'Tarea actualizada correctamente.');
                }
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error al guardar los datos.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function startTarea()
        {
            $idTarea = intval($_POST['idTarea']);
            
            // Verificar si es el usuario asignado
            $arrTarea = $this->model->getTarea($idTarea);
            if($arrTarea['id_usuario_asignado'] != $_SESSION['idUser']) {
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

            $request_tarea = $this->model->updateEstadoTarea($idTarea, 'completada');
            
            if($request_tarea > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Tarea completada correctamente.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al completar la tarea.');
            }
            
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function updateObservacion()
        {
            $idTarea = intval($_POST['idTarea']);
            $observacion = strClean($_POST['txtObservacion']);
            
            // Verificar si es el usuario asignado
            $arrTarea = $this->model->getTarea($idTarea);
            if($arrTarea['id_usuario_asignado'] != $_SESSION['idUser']) {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para editar esta observación.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            // Verificar que la tarea no esté completada
            if($arrTarea['estado'] == 'completada') {
                $arrResponse = array('status' => false, 'msg' => 'No se puede editar la observación de una tarea completada.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            // Verificar que no haya vencido la fecha de fin
            $fechaActual = new DateTime();
            $fechaFin = new DateTime($arrTarea['fecha_fin']);
            if($fechaFin < $fechaActual) {
                $arrResponse = array('status' => false, 'msg' => 'No se puede editar la observación de una tarea vencida.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            $request_tarea = $this->model->updateObservacionTarea($idTarea, $observacion);
            
            if($request_tarea > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Observación actualizada correctamente.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al actualizar la observación.');
            }
            
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
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
            $htmlOptions = "";
            $arrData = $this->model->getUsuariosAsignables();
            if(count($arrData) > 0 ){
                for ($i=0; $i < count($arrData); $i++) { 
                    $htmlOptions .= '<option value="'.$arrData[$i]['ideusuario'].'">'.$arrData[$i]['nombres'].'</option>';
                }
            }
            echo $htmlOptions;
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
    }
?>