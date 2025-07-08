<?php

class PermisosController extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
            die();
        }
    }

    public function permisos()
    {
        $data['page_tag'] = "Gestión de Permisos";
        $data['page_title'] = "Permisos de Funcionarios";
        $data['page_name'] = "permisos";
        $data['page_functions_js'] = "functions_permisos.js";
        
        $this->views->getView($this, "permisos", $data);
    }

    // API para obtener tipos de permisos
    public function getTiposPermisos()
    {
        if ($_POST) {
            $permisosModel = new PermisosModel();
            $tipos = $permisosModel->getTiposPermisos();
            echo json_encode($tipos);
        }
        die();
    }

    // API para validar límites
    public function validarLimites()
    {
        if ($_POST) {
            $funcionarioId = intval($_POST['funcionario_id']);
            $tipoPermisoId = intval($_POST['tipo_permiso_id']);
            $fechaPermiso = strClean($_POST['fecha_permiso']);
            $tipoFuncionario = strClean($_POST['tipo_funcionario']) ?: 'planta';

            $permisosModel = new PermisosModel();
            $validacion = $permisosModel->validarLimitePermisos($funcionarioId, $tipoPermisoId, $fechaPermiso, $tipoFuncionario);
            
            echo json_encode($validacion);
        }
        die();
    }

    // API para crear permiso
    public function crearPermiso()
    {
        if ($_POST) {
            $data = [
                'id_funcionario' => intval($_POST['funcionario_id']),
                'fecha_permiso' => strClean($_POST['fecha_permiso']),
                'motivo' => strClean($_POST['motivo']),
                'tipo_permiso_fk' => intval($_POST['tipo_permiso_id']),
                'tipo_funcionario' => strClean($_POST['tipo_funcionario']) ?: 'planta',
                'es_permiso_especial' => intval($_POST['es_especial']) ?: 0,
                'justificacion_especial' => strClean($_POST['justificacion']) ?: '',
                'observaciones' => strClean($_POST['observaciones']) ?: ''
            ];

            $permisosModel = new PermisosModel();
            $resultado = $permisosModel->crearPermiso($data);
            
            echo json_encode($resultado);
        }
        die();
    }

    // API para obtener permisos
    public function getPermisos()
    {
        if ($_POST) {
            $filtros = [
                'funcionario_id' => !empty($_POST['funcionario_id']) ? intval($_POST['funcionario_id']) : null,
                'fecha_inicio' => !empty($_POST['fecha_inicio']) ? strClean($_POST['fecha_inicio']) : null,
                'fecha_fin' => !empty($_POST['fecha_fin']) ? strClean($_POST['fecha_fin']) : null,
                'tipo_permiso' => !empty($_POST['tipo_permiso']) ? intval($_POST['tipo_permiso']) : null,
                'dependencia' => !empty($_POST['dependencia']) ? strClean($_POST['dependencia']) : null
            ];

            $permisosModel = new PermisosModel();
            $permisos = $permisosModel->getPermisosCompletos($filtros);
            
            echo json_encode($permisos);
        }
        die();
    }

    // API para estadísticas
    public function getEstadisticas()
    {
        if ($_POST) {
            $anio = !empty($_POST['anio']) ? intval($_POST['anio']) : date('Y');
            
            $permisosModel = new PermisosModel();
            $estadisticas = $permisosModel->getEstadisticasPermisos($anio);
            
            echo json_encode($estadisticas);
        }
        die();
    }

    // API para resumen mensual
    public function getResumenMensual()
    {
        if ($_POST) {
            $funcionarioId = intval($_POST['funcionario_id']);
            $mes = intval($_POST['mes']) ?: date('n');
            $anio = intval($_POST['anio']) ?: date('Y');
            $tipoFuncionario = strClean($_POST['tipo_funcionario']) ?: 'planta';

            $permisosModel = new PermisosModel();
            $resumen = $permisosModel->getResumenMensualFuncionario($funcionarioId, $mes, $anio, $tipoFuncionario);
            
            echo json_encode($resumen);
        }
        die();
    }

    // Configuración de límites
    public function configuracion()
    {
        $data['page_tag'] = "Configuración de Permisos";
        $data['page_title'] = "Configuración de Límites";
        $data['page_name'] = "configuracion_permisos";
        $data['page_functions_js'] = "functions_config_permisos.js";
        
        $this->views->getView($this, "configuracion_permisos", $data);
    }

    // API para configurar límites
    public function configurarLimites()
    {
        if ($_POST) {
            $data = [
                'cargo_fk' => !empty($_POST['cargo_id']) ? intval($_POST['cargo_id']) : null,
                'dependencia_fk' => !empty($_POST['dependencia_id']) ? intval($_POST['dependencia_id']) : null,
                'tipo_permiso_fk' => intval($_POST['tipo_permiso_id']),
                'limite_mensual' => intval($_POST['limite_mensual']),
                'limite_anual' => !empty($_POST['limite_anual']) ? intval($_POST['limite_anual']) : null,
                'requiere_reemplazo' => intval($_POST['requiere_reemplazo']) ?: 0
            ];

            $permisosModel = new PermisosModel();
            $resultado = $permisosModel->configurarLimites($data);
            
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Configuración guardada exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar la configuración']);
            }
        }
        die();
    }

    // API para obtener configuración actual
    public function getConfiguracion()
    {
        if ($_POST) {
            $permisosModel = new PermisosModel();
            $configuracion = $permisosModel->getConfiguracionLimites();
            
            echo json_encode($configuracion);
        }
        die();
    }

    // API para actualizar estado de permiso
    public function actualizarEstado()
    {
        if ($_POST) {
            $idPermiso = intval($_POST['id_permiso']);
            $estado = strClean($_POST['estado']);
            $observaciones = strClean($_POST['observaciones']) ?: '';

            $permisosModel = new PermisosModel();
            $resultado = $permisosModel->actualizarEstadoPermiso($idPermiso, $estado, $observaciones);
            
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Estado actualizado exitosamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado']);
            }
        }
        die();
    }

    // Vista de gestión de motivos
    public function motivos()
    {
        $data['page_tag'] = "Gestión de Motivos";
        $data['page_title'] = "Motivos de Permisos";
        $data['page_name'] = "motivos";
        $data['page_functions_js'] = "functions_motivos.js";
        
        $this->views->getView($this, "motivos", $data);
    }

    // API para obtener motivos
    public function getMotivos()
    {
        if ($_POST) {
            $permisosModel = new PermisosModel();
            $motivos = $permisosModel->getMotivos();
            echo json_encode($motivos);
        }
        die();
    }

    // API para crear/editar motivo
    public function setMotivo()
    {
        if ($_POST) {
            $id = !empty($_POST['id_motivo']) ? intval($_POST['id_motivo']) : 0;
            $nombre = strClean($_POST['nombre']);
            $descripcion = strClean($_POST['descripcion']);
            $status = intval($_POST['status']);

            $permisosModel = new PermisosModel();
            
            if ($id == 0) {
                $resultado = $permisosModel->insertMotivo($nombre, $descripcion, $status);
                $msg = $resultado ? 'Motivo creado correctamente' : 'Error al crear el motivo';
            } else {
                $resultado = $permisosModel->updateMotivo($id, $nombre, $descripcion, $status);
                $msg = $resultado ? 'Motivo actualizado correctamente' : 'Error al actualizar el motivo';
            }
            
            echo json_encode(['status' => $resultado, 'msg' => $msg]);
        }
        die();
    }

    // API para obtener motivo por ID
    public function getMotivo(int $id)
    {
        if ($id > 0) {
            $permisosModel = new PermisosModel();
            $motivo = $permisosModel->selectMotivo($id);
            echo json_encode($motivo);
        }
        die();
    }

    // API para eliminar motivo
    public function delMotivo()
    {
        if ($_POST) {
            $id = intval($_POST['id_motivo']);
            $permisosModel = new PermisosModel();
            $resultado = $permisosModel->deleteMotivo($id);
            $msg = $resultado ? 'Motivo eliminado correctamente' : 'Error al eliminar el motivo';
            echo json_encode(['status' => $resultado, 'msg' => $msg]);
        }
        die();
    }

    // API para gráficos de permisos
    public function getFuncionariosMasPermisosPorMes()
    {
        if ($_POST) {
            $anio = !empty($_POST['anio']) ? intval($_POST['anio']) : date('Y');
            $permisosModel = new PermisosModel();
            $data = $permisosModel->getFuncionariosMasPermisosPorMes($anio);
            echo json_encode($data);
        }
        die();
    }
    public function getCantidadPermisosPorFuncionario()
    {
        if ($_POST) {
            $anio = !empty($_POST['anio']) ? intval($_POST['anio']) : date('Y');
            $permisosModel = new PermisosModel();
            $data = $permisosModel->getCantidadPermisosPorFuncionario($anio);
            echo json_encode($data);
        }
        die();
    }
    public function getDependenciaMasPermisos()
    {
        if ($_POST) {
            $anio = !empty($_POST['anio']) ? intval($_POST['anio']) : date('Y');
            $permisosModel = new PermisosModel();
            $data = $permisosModel->getDependenciaMasPermisos($anio);
            echo json_encode($data);
        }
        die();
    }
}