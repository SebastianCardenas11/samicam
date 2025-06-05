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
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        error_log("Iniciando setFuncionario en FuncionariosOps");
    
        if ($_POST) {
            // Validación básica de campos obligatorios
            if (
                empty($_POST['anio']) ||
                empty($_POST['nit']) ||
                empty($_POST['nombre_entidad']) ||
                empty($_POST['numero_contrato']) ||
                empty($_POST['fecha_firma_contrato']) ||
                empty($_POST['numero_proceso']) ||
                empty($_POST['forma_contratacion']) ||
                empty($_POST['nombre_contratista']) ||
                empty($_POST['identificacion_contratista']) ||
                empty($_POST['sexo']) ||
                empty($_POST['edad'])
            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos obligatorios incompletos.');
            } else {
                // Recoger todos los campos del formulario
                $anio = strClean($_POST['anio']);
                $nit = strClean($_POST['nit']);
                $nombre_entidad = strClean($_POST['nombre_entidad']);
                $numero_contrato = strClean($_POST['numero_contrato']);
                $fecha_firma_contrato = strClean($_POST['fecha_firma_contrato']);
                $numero_proceso = strClean($_POST['numero_proceso']);
                $forma_contratacion = strClean($_POST['forma_contratacion']);
                $codigo_banco_proyecto = strClean($_POST['codigo_banco_proyecto']);
                $linea_estrategia = strClean($_POST['linea_estrategia']);
                $fuente_recurso = strClean($_POST['fuente_recurso']);
                $objeto = strClean($_POST['objeto']);
                $fecha_inicio = strClean($_POST['fecha_inicio']);
                $plazo_contrato = strClean($_POST['plazo_contrato']);
                $valor_contrato = floatval($_POST['valor_contrato']);
                $clase_contrato = strClean($_POST['clase_contrato']);
                $nombre_contratista = strClean($_POST['nombre_contratista']);
                $identificacion_contratista = strClean($_POST['identificacion_contratista']);
                $sexo = strClean($_POST['sexo']);
                $direccion_domicilio = strClean($_POST['direccion_domicilio']);
                $telefono_contacto = strClean($_POST['telefono_contacto']);
                $correo_electronico = strClean($_POST['correo_electronico']);
                $edad = intval($_POST['edad']);
                $entidad_bancaria = strClean($_POST['entidad_bancaria']);
                $tipo_cuenta = strClean($_POST['tipo_cuenta']);
                $numero_cuenta_bancaria = strClean($_POST['numero_cuenta_bancaria']);
                $numero_disp_presupuestal = strClean($_POST['numero_disp_presupuestal']);
                $fecha_disp_presupuestal = strClean($_POST['fecha_disp_presupuestal']);
                $valor_disp_presupuestal = floatval($_POST['valor_disp_presupuestal']);
                $numero_registro_presupuestal = strClean($_POST['numero_registro_presupuestal']);
                $fecha_registro_presupuestal = strClean($_POST['fecha_registro_presupuestal']);
                $valor_registro_presupuestal = floatval($_POST['valor_registro_presupuestal']);
                $cod_rubro = strClean($_POST['cod_rubro']);
                $rubro = strClean($_POST['rubro']);
                $fuente_financiacion = strClean($_POST['fuente_financiacion']);
                $asignado_interventor = strClean($_POST['asignado_interventor']);
                $unidad_ejecucion = strClean($_POST['unidad_ejecucion']);
                $nombre_interventor = strClean($_POST['nombre_interventor']);
                $identificacion_interventor = strClean($_POST['identificacion_interventor']);
                $tipo_vinculacion_interventor = strClean($_POST['tipo_vinculacion_interventor']);
                $fecha_aprobacion_garantia = strClean($_POST['fecha_aprobacion_garantia']);
                $anticipo_contrato = floatval($_POST['anticipo_contrato']);
                $valor_pagado_anticipo = floatval($_POST['valor_pagado_anticipo']);
                $fecha_pago_anticipo = strClean($_POST['fecha_pago_anticipo']);
                $numero_adiciones = intval($_POST['numero_adiciones']);
                $valor_total_adiciones = floatval($_POST['valor_total_adiciones']);
                $numero_prorrogas = intval($_POST['numero_prorrogas']);
                $tiempo_prorrogas = strClean($_POST['tiempo_prorrogas']);
                $numero_suspensiones = intval($_POST['numero_suspensiones']);
                $tiempo_suspensiones = strClean($_POST['tiempo_suspensiones']);
                $valor_total_pagos = floatval($_POST['valor_total_pagos']);
                $fecha_terminacion = strClean($_POST['fecha_terminacion']);
                $fecha_acta_liquidacion = strClean($_POST['fecha_acta_liquidacion']);
                $estado_contrato = strClean($_POST['estado_contrato']);
                $observaciones = strClean($_POST['observaciones']);
                $proviene_recurso_reactivacion = isset($_POST['proviene_recurso_reactivacion']) ? intval($_POST['proviene_recurso_reactivacion']) : 0;

                $request = $this->model->insertFuncionario(
                    $anio,
                    $nit,
                    $nombre_entidad,
                    $numero_contrato,
                    $fecha_firma_contrato,
                    $numero_proceso,
                    $forma_contratacion,
                    $codigo_banco_proyecto,
                    $linea_estrategia,
                    $fuente_recurso,
                    $objeto,
                    $fecha_inicio,
                    $plazo_contrato,
                    $valor_contrato,
                    $clase_contrato,
                    $nombre_contratista,
                    $identificacion_contratista,
                    $sexo,
                    $direccion_domicilio,
                    $telefono_contacto,
                    $correo_electronico,
                    $edad,
                    $entidad_bancaria,
                    $tipo_cuenta,
                    $numero_cuenta_bancaria,
                    $numero_disp_presupuestal,
                    $fecha_disp_presupuestal,
                    $valor_disp_presupuestal,
                    $numero_registro_presupuestal,
                    $fecha_registro_presupuestal,
                    $valor_registro_presupuestal,
                    $cod_rubro,
                    $rubro,
                    $fuente_financiacion,
                    $asignado_interventor,
                    $unidad_ejecucion,
                    $nombre_interventor,
                    $identificacion_interventor,
                    $tipo_vinculacion_interventor,
                    $fecha_aprobacion_garantia,
                    $anticipo_contrato,
                    $valor_pagado_anticipo,
                    $fecha_pago_anticipo,
                    $numero_adiciones,
                    $valor_total_adiciones,
                    $numero_prorrogas,
                    $tiempo_prorrogas,
                    $numero_suspensiones,
                    $tiempo_suspensiones,
                    $valor_total_pagos,
                    $fecha_terminacion,
                    $fecha_acta_liquidacion,
                    $estado_contrato,
                    $observaciones,
                    $proviene_recurso_reactivacion
                );

                if ($request > 0) {
                    $arrResponse = array("status" => true, "msg" => "Funcionario OPS guardado correctamente.");
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    

    public function getFuncionarios()
    {
        if ($_SESSION['permisosMod']['r']) {
            $arrData = $this->model->selectFuncionarios();
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                // Si tienes imagen, ajusta aquí, si no, puedes omitirlo
                // $arrData[$i]['imagen'] = ...;

                // Mostrar el estado usando estado_contrato
                $arrData[$i]['estado'] = $arrData[$i]['estado_contrato'];

                // Usar 'id' como clave primaria
                $id = $arrData[$i]['id'];

                if ($_SESSION['permisosMod']['r']) {
                    $btnView = '<button class="btn btn-info" onClick="fntViewInfo(' . $id . ')" title="Ver Funcionario"><i class="bi bi-eye"></i></button>';
                }
                if ($_SESSION['permisosMod']['u']) {
                    $btnEdit = '<button class="btn btn-warning" onClick="fntEditInfo(this,' . $id . ')" title="Editar Funcionario"><i class="bi bi-pencil"></i></button>';
                }
                if ($_SESSION['permisosMod']['d']) {
                    $btnDelete = '<button class="btn btn-danger" onClick="fntDelInfo(' . $id . ')" title="Eliminar Usuario"><i class="bi bi-trash3"></i></button>';
                }

                $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
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