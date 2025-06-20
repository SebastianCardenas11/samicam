<?php

class FuncionariosOps extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
        getPermisos(MFUNCIONARIOSOPS);
    }

    public function FuncionariosOps()
    {
        if (empty($_SESSION['permisosMod']['r'])) {
            header("Location:" . base_url() . '/dashboard');
        }
        $data['dependencias'] = $this->model->selectDependencias();
        $data['cargos'] = $this->model->selectCargos();
        $data['contrato'] = $this->model->selectContratoOps();
        $data['page_id'] = 4;
        $data['page_tag'] = "Funcionarios Ops";
        $data['page_title'] = "Funcionarios Ops";
        $data['page_name'] = "Funcionarios Ops";
        $data['page_functions_js'] = "functions_funcionariosOps.js";
        
        // Registrar acceso al módulo
        $this->registrarAccesoModulo("Funcionarios Ops");
        
        $this->views->getView($this, "funcionariosOps", $data);
    }


    public function setFuncionario()
    {
        if ($_POST) {
            try {
                // Definir campos requeridos
                $camposRequeridos = [
                    'nombre_contratista' => 'Nombre del Contratista',
                    'identificacion_contratista' => 'Identificación del Contratista',
                    'numero_contrato' => 'Número de Contrato',
                    'objeto' => 'Objeto del Contrato',
                    'valor_contrato' => 'Valor del Contrato',
                    'estado_contrato' => 'Estado del Contrato'
                ];

                // Verificar campos vacíos
                $camposFaltantes = [];
                foreach ($camposRequeridos as $campo => $nombre) {
                    if (empty($_POST[$campo])) {
                        $camposFaltantes[] = $nombre;
                    }
                }

                // Si hay campos faltantes, devolver error con la lista
                if (!empty($camposFaltantes)) {
                    $arrResponse = array(
                        "status" => false, 
                        "msg" => 'Por favor complete los siguientes campos obligatorios: ' . implode(', ', $camposFaltantes)
                    );
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                $id = intval($_POST['idFuncionario']);
                
                // Campos básicos obligatorios
                $strData = array(
                    'anio' => !empty($_POST['anio']) ? strClean($_POST['anio']) : date('Y'),
                    'nit' => strClean($_POST['nit']),
                    'nombre_entidad' => strClean($_POST['nombre_entidad']),
                    'numero_contrato' => strClean($_POST['numero_contrato']),
                    'fecha_firma_contrato' => !empty($_POST['fecha_firma_contrato']) ? strClean($_POST['fecha_firma_contrato']) : null,
                    'numero_proceso' => strClean($_POST['numero_proceso']),
                    'forma_contratacion' => strClean($_POST['forma_contratacion']),
                    'codigo_banco_proyecto' => strClean($_POST['codigo_banco_proyecto']),
                    'linea_estrategia' => strClean($_POST['linea_estrategia']),
                    'fuente_recurso' => strClean($_POST['fuente_recurso']),
                    'objeto' => strClean($_POST['objeto']),
                    'fecha_inicio' => !empty($_POST['fecha_inicio']) ? strClean($_POST['fecha_inicio']) : null,
                    'plazo_contrato' => strClean($_POST['plazo_contrato']),
                    'valor_contrato' => !empty($_POST['valor_contrato']) ? floatval($_POST['valor_contrato']) : 0,
                    'clase_contrato' => strClean($_POST['clase_contrato']),
                    'nombre_contratista' => strClean($_POST['nombre_contratista']),
                    'identificacion_contratista' => strClean($_POST['identificacion_contratista']),
                    'sexo' => strClean($_POST['sexo']),
                    'direccion_domicilio' => strClean($_POST['direccion_domicilio']),
                    'telefono_contacto' => strClean($_POST['telefono_contacto']),
                    'correo_electronico' => strClean($_POST['correo_electronico']),
                    'edad' => strClean($_POST['edad']),
                    'entidad_bancaria' => strClean($_POST['entidad_bancaria']),
                    'tipo_cuenta' => strClean($_POST['tipo_cuenta']),
                    'numero_cuenta_bancaria' => strClean($_POST['numero_cuenta_bancaria']),
                    'numero_disp_presupuestal' => strClean($_POST['numero_disp_presupuestal']),
                    'fecha_disp_presupuestal' => !empty($_POST['fecha_disp_presupuestal']) ? strClean($_POST['fecha_disp_presupuestal']) : null,
                    'valor_disp_presupuestal' => !empty($_POST['valor_disp_presupuestal']) ? floatval($_POST['valor_disp_presupuestal']) : 0,
                    'numero_registro_presupuestal' => strClean($_POST['numero_registro_presupuestal']),
                    'fecha_registro_presupuestal' => !empty($_POST['fecha_registro_presupuestal']) ? strClean($_POST['fecha_registro_presupuestal']) : null,
                    'valor_registro_presupuestal' => !empty($_POST['valor_registro_presupuestal']) ? floatval($_POST['valor_registro_presupuestal']) : 0,
                    'cod_rubro' => strClean($_POST['cod_rubro']),
                    'rubro' => strClean($_POST['rubro']),
                    'fuente_financiacion' => strClean($_POST['fuente_financiacion']),
                    'asignado_interventor' => strClean($_POST['asignado_interventor']),
                    'unidad_ejecucion' => strClean($_POST['unidad_ejecucion']),
                    'nombre_interventor' => strClean($_POST['nombre_interventor']),
                    'identificacion_interventor' => strClean($_POST['identificacion_interventor']),
                    'tipo_vinculacion_interventor' => strClean($_POST['tipo_vinculacion_interventor']),
                    'fecha_aprobacion_garantia' => !empty($_POST['fecha_aprobacion_garantia']) ? strClean($_POST['fecha_aprobacion_garantia']) : null,
                    'anticipo_contrato' => !empty($_POST['anticipo_contrato']) ? floatval($_POST['anticipo_contrato']) : 0,
                    'valor_pagado_anticipo' => !empty($_POST['valor_pagado_anticipo']) ? floatval($_POST['valor_pagado_anticipo']) : 0,
                    'fecha_pago_anticipo' => !empty($_POST['fecha_pago_anticipo']) ? strClean($_POST['fecha_pago_anticipo']) : null,
                    'numero_adiciones' => !empty($_POST['numero_adiciones']) ? intval($_POST['numero_adiciones']) : 0,
                    'valor_total_adiciones' => !empty($_POST['valor_total_adiciones']) ? floatval($_POST['valor_total_adiciones']) : 0,
                    'numero_prorrogas' => !empty($_POST['numero_prorrogas']) ? intval($_POST['numero_prorrogas']) : 0,
                    'tiempo_prorrogas' => strClean($_POST['tiempo_prorrogas']),
                    'numero_suspensiones' => !empty($_POST['numero_suspensiones']) ? intval($_POST['numero_suspensiones']) : 0,
                    'tiempo_suspensiones' => strClean($_POST['tiempo_suspensiones']),
                    'valor_total_pagos' => !empty($_POST['valor_total_pagos']) ? floatval($_POST['valor_total_pagos']) : 0,
                    'fecha_terminacion' => !empty($_POST['fecha_terminacion']) ? strClean($_POST['fecha_terminacion']) : null,
                    'fecha_acta_liquidacion' => !empty($_POST['fecha_acta_liquidacion']) ? strClean($_POST['fecha_acta_liquidacion']) : null,
                    'estado_contrato' => strClean($_POST['estado_contrato']),
                    'observaciones' => strClean($_POST['observaciones']),
                    'proviene_recurso_reactivacion' => isset($_POST['proviene_recurso_reactivacion']) ? intval($_POST['proviene_recurso_reactivacion']) : 0
                );

                // Validar correo electrónico si se proporciona
                if (!empty($_POST['correo_electronico']) && !filter_var($_POST['correo_electronico'], FILTER_VALIDATE_EMAIL)) {
                    $arrResponse = array("status" => false, "msg" => 'El correo electrónico no tiene un formato válido.');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                // Validar valor del contrato
                if (!empty($_POST['valor_contrato']) && !is_numeric($_POST['valor_contrato'])) {
                    $arrResponse = array("status" => false, "msg" => 'El valor del contrato debe ser un número válido.');
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    die();
                }

                if ($id == 0) {
                    $request = $this->model->insertFuncionario(...array_values($strData));
                    if ($request === false) {
                        $error = $this->model->getError();
                        $arrResponse = array(
                            "status" => false, 
                            "msg" => 'Error al guardar los datos: ' . ($error ? $error : 'Error desconocido')
                        );
                    } else {
                        $arrResponse = array(
                            "status" => true, 
                            "msg" => "Funcionario OPS guardado correctamente"
                        );
                    }
                } else {
                    array_unshift($strData, $id);
                    $request = $this->model->updateFuncionario(...array_values($strData));
                    if ($request === false) {
                        $error = $this->model->getError();
                        $arrResponse = array(
                            "status" => false, 
                            "msg" => 'Error al actualizar los datos: ' . ($error ? $error : 'Error desconocido')
                        );
                    } else {
                        $arrResponse = array(
                            "status" => true, 
                            "msg" => "Funcionario OPS actualizado correctamente"
                        );
                    }
                }
                
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            } catch (Exception $e) {
                error_log("Error en setFuncionario: " . $e->getMessage());
                $arrResponse = array(
                    "status" => false, 
                    "msg" => 'Error al procesar la solicitud: ' . $e->getMessage()
                );
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    

    public function getFuncionarios()
    {
        try {
            if ($_SESSION['permisosMod']['r']) {
                $arrData = $this->model->selectFuncionarios();
                
                if (!is_array($arrData)) {
                    echo json_encode(array());
                    die();
                }
                
                for ($i = 0; $i < count($arrData); $i++) {
                    $btnView = '';
                    $btnEdit = '';
                    $btnDelete = '';

                    if ($_SESSION['permisosMod']['r']) {
                        $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['id'].')" title="Ver Funcionario"><i class="far fa-eye"></i></button>';
                    }
                    if ($_SESSION['permisosMod']['u']) {
                        $btnEdit = '<button class="btn btn-warning btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['id'].')" title="Editar Funcionario"><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if ($_SESSION['permisosMod']['d']) {
                        $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['id'].')" title="Eliminar Funcionario"><i class="far fa-trash-alt"></i></button>';
                    }

                    $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
                    
                    // Asegurar que todos los campos existan y tengan valores válidos
                    $campos_requeridos = [
                        'numero_contrato',
                        'nombre_contratista',
                        'identificacion_contratista',
                        'objeto',
                        'valor_contrato',
                        'fecha_inicio',
                        'estado_contrato'
                    ];
                    
                    foreach ($campos_requeridos as $campo) {
                        if (!isset($arrData[$i][$campo])) {
                            $arrData[$i][$campo] = '';
                        }
                    }

                    // Formatear valores numéricos
                    if (isset($arrData[$i]['valor_contrato']) && is_numeric($arrData[$i]['valor_contrato'])) {
                        $arrData[$i]['valor_contrato'] = number_format((float)$arrData[$i]['valor_contrato'], 2, '.', ',');
                    } else {
                        $arrData[$i]['valor_contrato'] = '0.00';
                    }
                }

                // Limpiar el buffer de salida
                ob_clean();
                
                // Establecer headers
                header('Content-Type: application/json');
                header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                header("Cache-Control: post-check=0, pre-check=0", false);
                header("Pragma: no-cache");
                
                // Codificar y enviar respuesta
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(array());
            }
        } catch (Exception $e) {
            error_log("Error en getFuncionarios: " . $e->getMessage());
            echo json_encode(array());
        }
        die();
    }

    public function getFuncionario($idefuncionario)
    {
        if ($_SESSION['permisosMod']['r']) {
            $idefuncionario = intval($idefuncionario);
            if ($idefuncionario > 0) {
                $arrData = $this->model->selectFuncionario($idefuncionario);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    // Solo agregar URL de imagen si existe el campo 'imagen'
                    if (isset($arrData['imagen']) && !empty($arrData['imagen'])) {
                        $urlImagen = media().'/images/sin-imagen.png';
                        $rutaImagen = 'Assets/images/funcionarios/'.$arrData['imagen'];
                        if(!file_exists($rutaImagen)){
                            $urlImagen = media().'/images/sin-imagen.png';
                        }
                        $arrData['url_imagen'] = $urlImagen;
                    }
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delFuncionario()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['d']) {
                $id = intval($_POST['idFuncionario']);
                $request = $this->model->deleteFuncionario($id);
                if ($request) {
                    $arrResponse = array('status' => true, 'msg' => 'El funcionario OPS ha sido eliminado');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el funcionario OPS');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
    
    public function getFuncionarioParaMigrar($idefuncionario)
    {
        if ($_SESSION['permisosMod']['w']) {
            $idefuncionario = intval($idefuncionario);
            if ($idefuncionario > 0) {
                $arrData = $this->model->selectFuncionario($idefuncionario);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }
}