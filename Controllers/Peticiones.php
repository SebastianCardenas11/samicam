<?php
class Peticiones extends Controllers
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
        getPermisos(20); // Módulo de Peticiones
    }

    public function Peticiones()
    {
        if(empty($_SESSION['permisosMod']['r'])){
            header("Location:".base_url().'/dashboard');
        }
        
        $data['page_tag'] = "Peticiones";
        $data['page_title'] = "Peticiones";
        $data['page_name'] = "Peticiones";
        $data['page_functions_js'] = "functions_peticiones.js";
        
        // Obtener datos para los selectores
        $data['tipos_peticion'] = $this->model->getTiposPeticion();
        $data['dependencias'] = $this->model->getDependencias();
        $data['usuarios'] = $this->model->getUsuariosResponsables();
        
        $this->views->getView($this,"peticiones",$data);
    }

    public function getPeticiones()
    {
        if($_SESSION['permisosMod']['r'])
        {
            $arrData = $this->model->getPeticiones();
            
            for ($i=0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';
                $btnResponder = '';
                $btnRemitir = '';
                $btnDesistir = '';

                if($_SESSION['permisosMod']['r']){
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewPeticion('.$arrData[$i]['id_peticion'].')" title="Ver"><i class="far fa-eye"></i></button>';
                }

                if($_SESSION['permisosMod']['u'] && in_array($arrData[$i]['estado'], ['radicada', 'en_proceso'])){
                    $btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditPeticion('.$arrData[$i]['id_peticion'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                    $btnResponder = '<button class="btn btn-success btn-sm" onClick="fntResponderPeticion('.$arrData[$i]['id_peticion'].')" title="Responder"><i class="fas fa-reply"></i></button>';
                    $btnRemitir = '<button class="btn btn-warning btn-sm" onClick="fntRemitirPeticion('.$arrData[$i]['id_peticion'].')" title="Remitir"><i class="fas fa-share"></i></button>';
                    $btnDesistir = '<button class="btn btn-secondary btn-sm" onClick="fntDesistirPeticion('.$arrData[$i]['id_peticion'].')" title="Desistir"><i class="fas fa-times"></i></button>';
                }

                if($_SESSION['permisosMod']['d'] && $arrData[$i]['estado'] != 'respondida'){
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelPeticion('.$arrData[$i]['id_peticion'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                }

                // Estado con badge
                $estado_badge = '';
                switch($arrData[$i]['estado']) {
                    case 'radicada':
                        $estado_badge = '<span class="badge badge-info">Radicada</span>';
                        break;
                    case 'en_proceso':
                        $estado_badge = '<span class="badge badge-primary">En Proceso</span>';
                        break;
                    case 'respondida':
                        $estado_badge = '<span class="badge badge-success">Respondida</span>';
                        break;
                    case 'desistida':
                        $estado_badge = '<span class="badge badge-secondary">Desistida</span>';
                        break;
                    case 'remitida':
                        $estado_badge = '<span class="badge badge-warning">Remitida</span>';
                        break;
                    case 'vencida':
                        $estado_badge = '<span class="badge badge-danger">Vencida</span>';
                        break;
                }
                $arrData[$i]['estado_badge'] = $estado_badge;

                // Semáforo de días restantes
                $semaforo = '';
                if (in_array($arrData[$i]['estado'], ['radicada', 'en_proceso'])) {
                    $dias = $arrData[$i]['dias_habiles_restantes'];
                    if ($dias <= 0) {
                        $semaforo = '<span class="badge badge-danger">Vencida</span>';
                    } elseif ($dias <= 5) {
                        $semaforo = '<span class="badge badge-danger">'.$dias.' días</span>';
                    } elseif ($dias <= 10) {
                        $semaforo = '<span class="badge badge-warning">'.$dias.' días</span>';
                    } else {
                        $semaforo = '<span class="badge badge-success">'.$dias.' días</span>';
                    }
                } else {
                    $semaforo = '<span class="badge badge-light">N/A</span>';
                }
                $arrData[$i]['semaforo'] = $semaforo;

                $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnResponder.' '.$btnRemitir.' '.$btnDesistir.' '.$btnDelete.'</div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getPeticion($idpeticion)
    {
        if($_SESSION['permisosMod']['r'])
        {
            $idpeticion = intval($idpeticion);
            if($idpeticion > 0)
            {
                $arrData = $this->model->getPeticion($idpeticion);
                if(empty($arrData))
                {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                }else{
                    // Obtener historial
                    $arrData['historial'] = $this->model->getHistorialPeticion($idpeticion);
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function setPeticion()
    {
        if($_POST)
        {
            $idPeticion = intval($_POST['idPeticion']);
            $numero_radicado = 'RAD-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT); // Generar radicado automático
            $fecha_ingreso = $_POST['txtFechaIngreso'];
            $nombre_peticionario = strClean($_POST['txtPeticionario']);
            $descripcion_solicitud = strClean($_POST['txtDescripcion']);
            $id_tipo_peticion = intval($_POST['listTipoPeticion']);
            $areas_responsables = strClean($_POST['txtAreasResponsables']);
            $fecha_remision = !empty($_POST['txtFechaRemision']) ? $_POST['txtFechaRemision'] : null;
            $consecutivo = strClean($_POST['txtConsecutivo']);
            $dias_vencer = intval($_POST['txtDiasVencer']);
            $fecha_vencimiento = !empty($_POST['txtVencimientoTotal']) ? $_POST['txtVencimientoTotal'] : null;
            $observaciones = strClean($_POST['txtObservaciones']);

            if($idPeticion == 0)
            {
                // Crear nueva petición
                if(empty($_SESSION['permisosMod']['w']))
                {
                    $arrResponse = array("status" => false, "msg" => 'No tiene permisos para crear peticiones.');
                }
                else
                {
                    // Verificar que el radicado no exista
                    if($this->model->existeRadicado($numero_radicado))
                    {
                        $arrResponse = array("status" => false, "msg" => 'El número de radicado ya existe.');
                    }
                    else
                    {
                        $request_peticion = $this->model->insertPeticion(
                            $numero_radicado, $fecha_ingreso, $nombre_peticionario,
                            $descripcion_solicitud, $id_tipo_peticion, $areas_responsables,
                            $fecha_remision, $consecutivo, $dias_vencer, $fecha_vencimiento,
                            $observaciones, $_SESSION['idUser']
                        );

                        if($request_peticion > 0)
                        {
                            $arrResponse = array('status' => true, 'msg' => 'Petición creada correctamente.');
                            
                            // Enviar notificación
                            $this->enviarNotificacionCreacion($request_peticion);
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible crear la petición.');
                        }
                    }
                }
            }else{
                // Actualizar petición
                if(empty($_SESSION['permisosMod']['u']))
                {
                    $arrResponse = array("status" => false, "msg" => 'No tiene permisos para actualizar peticiones.');
                }
                else
                {
                    // Verificar que el radicado no exista en otra petición
                    if($this->model->existeRadicado($numero_radicado, $idPeticion))
                    {
                        $arrResponse = array("status" => false, "msg" => 'El número de radicado ya existe en otra petición.');
                    }
                    else
                    {
                        $request_peticion = $this->model->updatePeticion(
                            $idPeticion, $numero_radicado, $fecha_ingreso, $nombre_peticionario,
                            $descripcion_solicitud, $id_tipo_peticion, $areas_responsables,
                            $fecha_remision, $consecutivo, $dias_vencer, $fecha_vencimiento,
                            $observaciones, $_SESSION['idUser']
                        );

                        if($request_peticion)
                        {
                            $arrResponse = array('status' => true, 'msg' => 'Petición actualizada correctamente.');
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible actualizar la petición.');
                        }
                    }
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function responderPeticion()
    {
        if($_POST)
        {
            if(empty($_SESSION['permisosMod']['u']))
            {
                $arrResponse = array("status" => false, "msg" => 'No tiene permisos para responder peticiones.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            $idPeticion = intval($_POST['idPeticion']);
            $comentario_respuesta = strClean($_POST['txtRespuesta']);
            $archivo_respuesta = null;

            // Manejar archivo de respuesta
            if(isset($_FILES['fileRespuesta']) && $_FILES['fileRespuesta']['error'] == UPLOAD_ERR_OK)
            {
                $archivo_temp = $_FILES['fileRespuesta']['tmp_name'];
                $nombre_original = $_FILES['fileRespuesta']['name'];
                $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
                
                // Validar extensión
                $extensiones_permitidas = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
                if(!in_array($extension, $extensiones_permitidas))
                {
                    $arrResponse = array('status' => false, 'msg' => 'Tipo de archivo no permitido.');
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    die();
                }
                
                // Generar nombre único
                $archivo_respuesta = md5(uniqid() . $nombre_original) . '.' . $extension;
                $ruta_destino = 'uploads/peticiones/' . $archivo_respuesta;
                
                // Crear directorio si no existe
                if(!is_dir('uploads/peticiones/'))
                {
                    mkdir('uploads/peticiones/', 0777, true);
                }
                
                if(!move_uploaded_file($archivo_temp, $ruta_destino))
                {
                    $arrResponse = array('status' => false, 'msg' => 'Error al subir el archivo.');
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                    die();
                }
            }

            $request_respuesta = $this->model->responderPeticion(
                $idPeticion, $comentario_respuesta, $archivo_respuesta, $_SESSION['idUser']
            );

            if($request_respuesta)
            {
                $arrResponse = array('status' => true, 'msg' => 'Petición respondida correctamente.');
                
                // Enviar notificación
                $this->enviarNotificacionRespuesta($idPeticion);
            }else{
                $arrResponse = array("status" => false, "msg" => 'No es posible responder la petición.');
            }

            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function remitirPeticion()
    {
        if($_POST)
        {
            if(empty($_SESSION['permisosMod']['u']))
            {
                $arrResponse = array("status" => false, "msg" => 'No tiene permisos para remitir peticiones.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            $idPeticion = intval($_POST['idPeticion']);
            $area_remitida = intval($_POST['listAreaRemitida']);
            $motivo_remision = strClean($_POST['txtMotivoRemision']);

            $request_remision = $this->model->remitirPeticion(
                $idPeticion, $area_remitida, $motivo_remision, $_SESSION['idUser']
            );

            if($request_remision)
            {
                $arrResponse = array('status' => true, 'msg' => 'Petición remitida correctamente.');
                
                // Enviar notificación
                $this->enviarNotificacionRemision($idPeticion, $area_remitida);
            }else{
                $arrResponse = array("status" => false, "msg" => 'No es posible remitir la petición.');
            }

            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function desistirPeticion()
    {
        if($_POST)
        {
            if(empty($_SESSION['permisosMod']['u']))
            {
                $arrResponse = array("status" => false, "msg" => 'No tiene permisos para desistir peticiones.');
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }

            $idPeticion = intval($_POST['idPeticion']);
            $observaciones = strClean($_POST['txtObservaciones']);

            $request_desistir = $this->model->desistirPeticion(
                $idPeticion, $observaciones, $_SESSION['idUser']
            );

            if($request_desistir)
            {
                $arrResponse = array('status' => true, 'msg' => 'Petición marcada como desistida.');
            }else{
                $arrResponse = array("status" => false, "msg" => 'No es posible desistir la petición.');
            }

            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delPeticion()
    {
        if($_POST)
        {
            if(empty($_SESSION['permisosMod']['d']))
            {
                $arrResponse = array('status' => false, 'msg' => 'No tiene permisos para eliminar peticiones.');
            }else{
                $idPeticion = intval($_POST['idPeticion']);
                $requestDelete = $this->model->deletePeticion($idPeticion);
                if($requestDelete)
                {
                    $arrResponse = array('status' => true, 'msg' => 'Petición eliminada correctamente.');
                }else{
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la petición.');
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getEstadisticas()
    {
        if($_SESSION['permisosMod']['r'])
        {
            $estadisticas = $this->model->getEstadisticas();
            echo json_encode($estadisticas, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getReporte()
    {
        if($_SESSION['permisosMod']['r'])
        {
            $tipo = $_GET['tipo'] ?? 'todas';
            $fecha_inicio = $_GET['fecha_inicio'] ?? null;
            $fecha_fin = $_GET['fecha_fin'] ?? null;
            $dependencia = $_GET['dependencia'] ?? null;

            $reporte = $this->model->getReporte($tipo, $fecha_inicio, $fecha_fin, $dependencia);
            
            // Configurar headers para descarga
            if(isset($_GET['export']) && $_GET['export'] == 'excel')
            {
                $this->exportarExcel($reporte, $tipo);
            }
            else
            {
                echo json_encode($reporte, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function getTiposPeticion()
    {
        $htmlOptions = "";
        $arrData = $this->model->getTiposPeticion();
        if(count($arrData) > 0 ){
            for ($i=0; $i < count($arrData); $i++) { 
                $htmlOptions .= '<option value="'.$arrData[$i]['id_tipo'].'">'.$arrData[$i]['nombre'].'</option>';
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

    public function actualizarEstados()
    {
        // Esta función se puede llamar por cron job o manualmente
        $result = $this->model->actualizarEstados();
        
        if($result)
        {
            $arrResponse = array('status' => true, 'msg' => 'Estados actualizados correctamente.');
        }else{
            $arrResponse = array('status' => false, 'msg' => 'Error al actualizar estados.');
        }
        
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Métodos privados para notificaciones
    private function enviarNotificacionCreacion($id_peticion)
    {
        try {
            $peticion = $this->model->getPeticion($id_peticion);
            
            // Enviar WhatsApp
            require_once "Helpers/WhatsAppHelper.php";
            $whatsappHelper = new WhatsAppHelper();
            
            $mensaje = "🔔 Nueva petición radicada:\n";
            $mensaje .= "📋 Radicado: {$peticion['numero_radicado']}\n";
            $mensaje .= "👤 Peticionario: {$peticion['nombre_peticionario']}\n";
            $mensaje .= "📂 Tipo: {$peticion['tipo_peticion_nombre']}\n";
            $mensaje .= "🏢 Dependencia: {$peticion['dependencia_nombre']}\n";
            $mensaje .= "📅 Vence: {$peticion['fecha_vencimiento_format']}\n";
            $mensaje .= "⏰ Días hábiles: {$peticion['dias_habiles_restantes']}";
            
            $numero = $whatsappHelper->getNumeroPorTipo('general');
            $whatsappHelper->sendWhatsAppMessage($numero, $mensaje);
            
        } catch (Exception $e) {
            error_log("Error enviando notificación de creación: " . $e->getMessage());
        }
    }

    private function enviarNotificacionRespuesta($id_peticion)
    {
        try {
            $peticion = $this->model->getPeticion($id_peticion);
            
            // Enviar WhatsApp
            require_once "Helpers/WhatsAppHelper.php";
            $whatsappHelper = new WhatsAppHelper();
            
            $mensaje = "✅ Petición respondida:\n";
            $mensaje .= "📋 Radicado: {$peticion['numero_radicado']}\n";
            $mensaje .= "👤 Peticionario: {$peticion['nombre_peticionario']}\n";
            $mensaje .= "📅 Respondida: {$peticion['fecha_respuesta_format']}\n";
            $mensaje .= "⏱️ Días hábiles de respuesta: {$peticion['dias_habiles_respuesta']}";
            
            $numero = $whatsappHelper->getNumeroPorTipo('general');
            $whatsappHelper->sendWhatsAppMessage($numero, $mensaje);
            
        } catch (Exception $e) {
            error_log("Error enviando notificación de respuesta: " . $e->getMessage());
        }
    }

    private function enviarNotificacionRemision($id_peticion, $area_remitida)
    {
        try {
            $peticion = $this->model->getPeticion($id_peticion);
            
            // Enviar WhatsApp
            require_once "Helpers/WhatsAppHelper.php";
            $whatsappHelper = new WhatsAppHelper();
            
            $mensaje = "↗️ Petición remitida:\n";
            $mensaje .= "📋 Radicado: {$peticion['numero_radicado']}\n";
            $mensaje .= "👤 Peticionario: {$peticion['nombre_peticionario']}\n";
            $mensaje .= "🏢 Remitida a: {$peticion['area_remitida_nombre']}\n";
            $mensaje .= "📝 Motivo: {$peticion['motivo_remision']}";
            
            $numero = $whatsappHelper->getNumeroPorTipo('general');
            $whatsappHelper->sendWhatsAppMessage($numero, $mensaje);
            
        } catch (Exception $e) {
            error_log("Error enviando notificación de remisión: " . $e->getMessage());
        }
    }

    private function exportarExcel($data, $tipo)
    {
        // Implementar exportación a Excel usando PhpSpreadsheet
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_peticiones_'.$tipo.'_'.date('Y-m-d').'.xlsx"');
        header('Cache-Control: max-age=0');
        
        // Aquí iría la lógica de PhpSpreadsheet
        // Por simplicidad, exportamos como CSV
        $output = fopen('php://output', 'w');
        
        // Headers
        fputcsv($output, ['Radicado', 'Fecha Ingreso', 'Peticionario', 'Tipo', 'Dependencia', 'Estado', 'Días Restantes']);
        
        // Datos
        foreach($data as $row) {
            fputcsv($output, [
                $row['numero_radicado'],
                $row['fecha_ingreso_format'] ?? $row['fecha_ingreso'],
                $row['nombre_peticionario'],
                $row['tipo_peticion'] ?? $row['tipo_peticion_nombre'],
                $row['dependencia'] ?? $row['dependencia_nombre'],
                $row['estado'],
                $row['dias_habiles_restantes'] ?? 'N/A'
            ]);
        }
        
        fclose($output);
    }
}
?>