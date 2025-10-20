<?php

class RadicadosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todos los radicados
    public function getRadicados()
    {
        $sql = "SELECT * FROM tbl_radicados WHERE status = 1 ORDER BY fecha_radicado DESC";
        return $this->select_all($sql);
    }

    // Obtener radicado por ID
    public function getRadicado($id)
    {
        $sql = "SELECT * FROM tbl_radicados WHERE id_radicado = ? AND status = 1";
        return $this->select($sql, [$id]);
    }

    // Crear nuevo radicado
    public function insertRadicado($asunto, $entidad, $medio, $fechaEnvio, $numeroRadicado, $fechaRadicado, $usuario)
    {
        $sql = "INSERT INTO tbl_radicados (asunto_comunicacion, entidad_envio, medio_envio, fecha_envio, numero_radicado, fecha_radicado, usuario_creador) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->insert($sql, [$asunto, $entidad, $medio, $fechaEnvio, $numeroRadicado, $fechaRadicado, $usuario]);
    }

    // Actualizar radicado
    public function updateRadicado($id, $asunto, $entidad, $medio, $fechaEnvio, $numeroRadicado, $fechaRadicado)
    {
        $sql = "UPDATE tbl_radicados SET asunto_comunicacion = ?, entidad_envio = ?, medio_envio = ?, fecha_envio = ?, numero_radicado = ?, fecha_radicado = ? WHERE id_radicado = ?";
        return $this->update($sql, [$asunto, $entidad, $medio, $fechaEnvio, $numeroRadicado, $fechaRadicado, $id]);
    }

    // Eliminar radicado (soft delete)
    public function deleteRadicado($id)
    {
        $sql = "UPDATE tbl_radicados SET status = 0 WHERE id_radicado = ?";
        return $this->update($sql, [$id]);
    }

    // Verificar si el número de radicado ya existe
    public function existeNumeroRadicado($numeroRadicado, $idExcluir = null)
    {
        $sql = "SELECT COUNT(*) as count FROM tbl_radicados WHERE numero_radicado = ? AND status = 1";
        $params = [$numeroRadicado];
        
        if ($idExcluir) {
            $sql .= " AND id_radicado != ?";
            $params[] = $idExcluir;
        }
        
        $result = $this->select($sql, $params);
        return $result['count'] > 0;
    }

    // Estadísticas por medio de envío
    public function getEstadisticasPorMedio($anio = null)
    {
        $anio = $anio ?? date('Y');
        $sql = "SELECT medio_envio, COUNT(*) as total FROM tbl_radicados WHERE YEAR(fecha_radicado) = ? AND status = 1 GROUP BY medio_envio";
        return $this->select_all($sql, [$anio]);
    }

    // Estadísticas por mes
    public function getEstadisticasPorMes($anio = null)
    {
        $anio = $anio ?? date('Y');
        $sql = "SELECT MONTH(fecha_radicado) as mes, COUNT(*) as total FROM tbl_radicados WHERE YEAR(fecha_radicado) = ? AND status = 1 GROUP BY MONTH(fecha_radicado) ORDER BY mes";
        return $this->select_all($sql, [$anio]);
    }

    // Top entidades con más radicados
    public function getTopEntidades($anio = null, $limit = 10)
    {
        $anio = $anio ?? date('Y');
        $sql = "SELECT entidad_envio, COUNT(*) as total FROM tbl_radicados WHERE YEAR(fecha_radicado) = ? AND status = 1 GROUP BY entidad_envio ORDER BY total DESC LIMIT ?";
        return $this->select_all($sql, [$anio, $limit]);
    }

    // Obtener radicados con filtros
    public function getRadicadosConFiltros($filtros = [])
    {
        $sql = "SELECT * FROM tbl_radicados WHERE status = 1";
        $params = [];

        if (!empty($filtros['fecha_inicio']) && !empty($filtros['fecha_fin'])) {
            $sql .= " AND fecha_radicado BETWEEN ? AND ?";
            $params[] = $filtros['fecha_inicio'];
            $params[] = $filtros['fecha_fin'];
        }

        if (!empty($filtros['medio_envio'])) {
            $sql .= " AND medio_envio = ?";
            $params[] = $filtros['medio_envio'];
        }

        if (!empty($filtros['entidad'])) {
            $sql .= " AND entidad_envio LIKE ?";
            $params[] = "%{$filtros['entidad']}%";
        }

        $sql .= " ORDER BY fecha_radicado DESC";

        if (!empty($params)) {
            return $this->select_all($sql, $params);
        }
        
        return $this->select_all($sql);
    }
}