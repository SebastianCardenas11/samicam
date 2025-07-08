<?php

class PermisosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener tipos de permisos activos
    public function getTiposPermisos()
    {
        $sql = "SELECT * FROM tbl_tipos_permisos WHERE status = 1 ORDER BY nombre";
        return $this->select_all($sql);
    }

    // Validar límites de permisos
    public function validarLimitePermisos($funcionarioId, $tipoPermisoId, $fechaPermiso, $tipoFuncionario = 'planta')
    {
        $sql = "SELECT validar_limite_permisos(?, ?, ?, ?) as resultado";
        $params = [$funcionarioId, $tipoPermisoId, $fechaPermiso, $tipoFuncionario];
        $result = $this->select($sql, $params);
        
        if ($result) {
            return json_decode($result['resultado'], true);
        }
        
        return ['permitido' => false, 'limite_mensual' => 3, 'permisos_usados' => 0, 'permisos_restantes' => 0];
    }

    // Crear permiso con validación
    public function crearPermiso($data)
    {
        // Validar límites primero
        $validacion = $this->validarLimitePermisos(
            $data['id_funcionario'],
            $data['tipo_permiso_fk'],
            $data['fecha_permiso'],
            $data['tipo_funcionario']
        );

        if (!$validacion['permitido'] && !$data['es_permiso_especial']) {
            return [
                'success' => false,
                'message' => "Límite mensual excedido. Permisos usados: {$validacion['permisos_usados']}/{$validacion['limite_mensual']}"
            ];
        }

        $sql = "INSERT INTO tbl_permisos (id_funcionario, fecha_permiso, mes, anio, motivo, tipo_permiso_fk, 
                estado, tipo_funcionario, es_permiso_especial, justificacion_especial, observaciones) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['id_funcionario'],
            $data['fecha_permiso'],
            date('n', strtotime($data['fecha_permiso'])),
            date('Y', strtotime($data['fecha_permiso'])),
            $data['motivo'],
            $data['tipo_permiso_fk'],
            $data['estado'] ?? 'Aprobado',
            $data['tipo_funcionario'] ?? 'planta',
            $data['es_permiso_especial'] ?? 0,
            $data['justificacion_especial'] ?? '',
            $data['observaciones'] ?? ''
        ];

        $result = $this->insert($sql, $params);
        
        if ($result) {
            // Registrar en historial
            $this->registrarHistorial($data);
            return ['success' => true, 'message' => 'Permiso creado exitosamente'];
        }
        
        return ['success' => false, 'message' => 'Error al crear el permiso'];
    }

    // Registrar en historial
    private function registrarHistorial($data)
    {
        $sql = "INSERT INTO tbl_historial_permisos (id_funcionario, fecha_permiso, mes, anio, motivo, 
                tipo_permiso_fk, estado, tipo_funcionario, es_permiso_especial, justificacion_especial, observaciones) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $params = [
            $data['id_funcionario'],
            $data['fecha_permiso'],
            date('n', strtotime($data['fecha_permiso'])),
            date('Y', strtotime($data['fecha_permiso'])),
            $data['motivo'],
            $data['tipo_permiso_fk'],
            $data['estado'] ?? 'Aprobado',
            $data['tipo_funcionario'] ?? 'planta',
            $data['es_permiso_especial'] ?? 0,
            $data['justificacion_especial'] ?? '',
            $data['observaciones'] ?? ''
        ];

        $this->insert($sql, $params);
    }

    // Obtener permisos con información completa
    public function getPermisosCompletos($filtros = [])
    {
        $sql = "SELECT * FROM vista_permisos_funcionarios WHERE 1=1";
        $params = [];

        if (!empty($filtros['funcionario_id'])) {
            $sql .= " AND id_funcionario = ?";
            $params[] = $filtros['funcionario_id'];
        }

        if (!empty($filtros['fecha_inicio']) && !empty($filtros['fecha_fin'])) {
            $sql .= " AND fecha_permiso BETWEEN ? AND ?";
            $params[] = $filtros['fecha_inicio'];
            $params[] = $filtros['fecha_fin'];
        }

        if (!empty($filtros['tipo_permiso'])) {
            $sql .= " AND tipo_permiso_fk = ?";
            $params[] = $filtros['tipo_permiso'];
        }

        if (!empty($filtros['dependencia'])) {
            $sql .= " AND dependencia LIKE ?";
            $params[] = "%{$filtros['dependencia']}%";
        }

        $sql .= " ORDER BY fecha_permiso DESC";

        if (!empty($params)) {
            return $this->select_all($sql, $params);
        }
        
        return $this->select_all($sql);
    }

    // Obtener estadísticas de permisos
    public function getEstadisticasPermisos($anio = null)
    {
        $anio = $anio ?? date('Y');
        
        $sql = "SELECT 
                    tp.nombre as tipo_permiso,
                    tp.color_display,
                    COUNT(*) as total_permisos,
                    MONTH(p.fecha_permiso) as mes
                FROM tbl_permisos p
                LEFT JOIN tbl_tipos_permisos tp ON p.tipo_permiso_fk = tp.id_tipo_permiso
                WHERE YEAR(p.fecha_permiso) = ?
                GROUP BY tp.id_tipo_permiso, MONTH(p.fecha_permiso)
                ORDER BY mes, tp.nombre";
        
        return $this->select_all($sql, [$anio]);
    }

    // Configurar límites por cargo/dependencia
    public function configurarLimites($data)
    {
        $sql = "INSERT INTO tbl_configuracion_permisos_cargo 
                (cargo_fk, dependencia_fk, tipo_permiso_fk, limite_mensual, limite_anual, requiere_reemplazo) 
                VALUES (?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                limite_mensual = VALUES(limite_mensual),
                limite_anual = VALUES(limite_anual),
                requiere_reemplazo = VALUES(requiere_reemplazo)";
        
        $params = [
            $data['cargo_fk'] ?? null,
            $data['dependencia_fk'] ?? null,
            $data['tipo_permiso_fk'],
            $data['limite_mensual'],
            $data['limite_anual'] ?? null,
            $data['requiere_reemplazo'] ?? 0
        ];

        return $this->insert($sql, $params);
    }

    // Obtener configuración de límites
    public function getConfiguracionLimites()
    {
        $sql = "SELECT 
                    cpc.*,
                    c.nombre as cargo_nombre,
                    d.nombre as dependencia_nombre,
                    tp.nombre as tipo_permiso_nombre
                FROM tbl_configuracion_permisos_cargo cpc
                LEFT JOIN tbl_cargos c ON cpc.cargo_fk = c.idecargos
                LEFT JOIN tbl_dependencia d ON cpc.dependencia_fk = d.dependencia_pk
                LEFT JOIN tbl_tipos_permisos tp ON cpc.tipo_permiso_fk = tp.id_tipo_permiso
                WHERE cpc.status = 1
                ORDER BY c.nombre, d.nombre, tp.nombre";
        
        return $this->select_all($sql);
    }

    // Actualizar estado de permiso
    public function actualizarEstadoPermiso($idPermiso, $estado, $observaciones = '')
    {
        $sql = "UPDATE tbl_permisos SET estado = ?, observaciones = ? WHERE id_permiso = ?";
        return $this->update($sql, [$estado, $observaciones, $idPermiso]);
    }

    // Obtener resumen mensual por funcionario
    public function getResumenMensualFuncionario($funcionarioId, $mes, $anio, $tipoFuncionario = 'planta')
    {
        $sql = "SELECT 
                    tp.nombre as tipo_permiso,
                    tp.color_display,
                    COUNT(*) as total_usado,
                    COALESCE(cpc.limite_mensual, 3) as limite_mensual
                FROM tbl_permisos p
                LEFT JOIN tbl_tipos_permisos tp ON p.tipo_permiso_fk = tp.id_tipo_permiso
                LEFT JOIN tbl_funcionarios_planta f ON p.id_funcionario = f.idefuncionario AND p.tipo_funcionario = 'planta'
                LEFT JOIN tbl_configuracion_permisos_cargo cpc ON (
                    (cpc.cargo_fk = f.cargo_fk OR cpc.cargo_fk IS NULL) AND
                    (cpc.dependencia_fk = f.dependencia_fk OR cpc.dependencia_fk IS NULL) AND
                    cpc.tipo_permiso_fk = tp.id_tipo_permiso
                )
                WHERE p.id_funcionario = ? 
                AND p.mes = ? 
                AND p.anio = ? 
                AND p.tipo_funcionario = ?
                GROUP BY tp.id_tipo_permiso
                ORDER BY tp.nombre";
        
        return $this->select_all($sql, [$funcionarioId, $mes, $anio, $tipoFuncionario]);
    }

    // Método requerido por helpers.php para compatibilidad
    public function permisosModulo($idrol)
    {
        $sql = "SELECT p.*, m.titulo as modulo 
                FROM permisos p 
                INNER JOIN modulo m ON p.moduloid = m.idmodulo 
                WHERE p.rolid = ? AND m.status = 1
                ORDER BY m.idmodulo";
        $permisos = $this->select_all($sql, [$idrol]);
        
        $arrPermisos = [];
        if (count($permisos) > 0) {
            foreach ($permisos as $permiso) {
                $arrPermisos[$permiso['moduloid']] = $permiso;
            }
        }
        return $arrPermisos;
    }

    // Obtener todos los módulos activos
    public function selectModulos()
    {
        $sql = "SELECT * FROM modulo WHERE status = 1 ORDER BY idmodulo";
        return $this->select_all($sql);
    }

    // Obtener permisos de un rol sobre los módulos
    public function selectPermisosRol($idrol)
    {
        $sql = "SELECT p.moduloid, p.r, p.w, p.u, p.d, p.v
                FROM permisos p
                INNER JOIN modulo m ON p.moduloid = m.idmodulo
                WHERE p.rolid = ? AND m.status = 1
                ORDER BY m.idmodulo";
        return $this->select_all($sql, [$idrol]);
    }

    // Eliminar todos los permisos de un rol
    public function deletePermisos($idrol)
    {
        $sql = "DELETE FROM permisos WHERE rolid = ?";
        return $this->delete($sql, [$idrol]);
    }

    // Insertar permisos para un rol y módulo
    public function insertPermisos($idrol, $idmodulo, $r, $w, $u, $d, $v)
    {
        $sql = "INSERT INTO permisos (rolid, moduloid, r, w, u, d, v) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $params = [$idrol, $idmodulo, $r, $w, $u, $d, $v];
        return $this->insert($sql, $params);
    }

    // Obtener información de un rol
    public function getRol($idrol)
    {
        require_once("Models/RolesModel.php");
        $rolesModel = new RolesModel();
        return $rolesModel->selectRol($idrol);
    }

    // Funcionarios con más permisos por mes
    public function getFuncionariosMasPermisosPorMes($anio = null) {
        $anio = $anio ?? date('Y');
        $sql = "SELECT f.nombre_completo, MONTH(p.fecha_permiso) as mes, COUNT(*) as total
                FROM tbl_permisos p
                INNER JOIN tbl_funcionarios_planta f ON p.id_funcionario = f.idefuncionario
                WHERE YEAR(p.fecha_permiso) = ?
                GROUP BY f.idefuncionario, mes
                ORDER BY mes, total DESC";
        return $this->select_all($sql, [$anio]);
    }

    // Cantidad de permisos por funcionario
    public function getCantidadPermisosPorFuncionario($anio = null) {
        $anio = $anio ?? date('Y');
        $sql = "SELECT f.nombre_completo, COUNT(*) as total
                FROM tbl_permisos p
                INNER JOIN tbl_funcionarios_planta f ON p.id_funcionario = f.idefuncionario
                WHERE YEAR(p.fecha_permiso) = ?
                GROUP BY f.idefuncionario
                ORDER BY total DESC";
        return $this->select_all($sql, [$anio]);
    }

    // Dependencia con más permisos
    public function getDependenciaMasPermisos($anio = null) {
        $anio = $anio ?? date('Y');
        $sql = "SELECT d.nombre as dependencia, COUNT(*) as total
                FROM tbl_permisos p
                INNER JOIN tbl_funcionarios_planta f ON p.id_funcionario = f.idefuncionario
                INNER JOIN tbl_dependencia d ON f.dependencia_fk = d.dependencia_pk
                WHERE YEAR(p.fecha_permiso) = ?
                GROUP BY d.dependencia_pk
                ORDER BY total DESC";
        return $this->select_all($sql, [$anio]);
    }

    // CRUD Motivos de Permisos
    public function getMotivos()
    {
        $sql = "SELECT * FROM tbl_motivos_permisos ORDER BY nombre";
        return $this->select_all($sql);
    }

    public function selectMotivo($id)
    {
        $sql = "SELECT * FROM tbl_motivos_permisos WHERE id_motivo = ?";
        return $this->select($sql, [$id]);
    }

    public function insertMotivo($nombre, $descripcion, $status)
    {
        $sql = "INSERT INTO tbl_motivos_permisos (nombre, descripcion, status) VALUES (?, ?, ?)";
        return $this->insert($sql, [$nombre, $descripcion, $status]);
    }

    public function updateMotivo($id, $nombre, $descripcion, $status)
    {
        $sql = "UPDATE tbl_motivos_permisos SET nombre = ?, descripcion = ?, status = ? WHERE id_motivo = ?";
        return $this->update($sql, [$nombre, $descripcion, $status, $id]);
    }

    public function deleteMotivo($id)
    {
        // Verificar si el motivo está siendo usado en permisos
        $sqlCheck = "SELECT COUNT(*) as count FROM tbl_permisos WHERE motivo IN (SELECT nombre FROM tbl_motivos_permisos WHERE id_motivo = ?)";
        $result = $this->select($sqlCheck, [$id]);
        
        if ($result && $result['count'] > 0) {
            // Si está siendo usado, solo desactivar
            $sql = "UPDATE tbl_motivos_permisos SET status = 0 WHERE id_motivo = ?";
            return $this->update($sql, [$id]);
        } else {
            // Si no está siendo usado, eliminar completamente
            $sql = "DELETE FROM tbl_motivos_permisos WHERE id_motivo = ?";
            return $this->delete($sql, [$id]);
        }
    }
}