<?php

class HojasVidaEquiposModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getEquiposConMovimientos()
    {
        $sql = "SELECT 
                    'impresora' as tipo_equipo,
                    i.id_impresora as id_equipo,
                    i.numero_impresora as numero,
                    i.marca,
                    i.modelo,
                    i.estado,
                    i.disponibilidad,
                    COUNT(m.id_movimiento) as total_movimientos,
                    MAX(m.fecha_hora) as ultimo_movimiento
                FROM tbl_impresoras i
                LEFT JOIN tbl_equipos_movimientos m ON i.id_impresora = m.id_equipo AND m.tipo_equipo = 'impresora'
                WHERE i.status != 0
                GROUP BY i.id_impresora
                
                UNION ALL
                
                SELECT 
                    'escaner' as tipo_equipo,
                    e.id_escaner as id_equipo,
                    e.numero_escaner as numero,
                    e.marca,
                    e.modelo,
                    e.estado,
                    e.disponibilidad,
                    COUNT(m.id_movimiento) as total_movimientos,
                    MAX(m.fecha_hora) as ultimo_movimiento
                FROM tbl_escaneres e
                LEFT JOIN tbl_equipos_movimientos m ON e.id_escaner = m.id_equipo AND m.tipo_equipo = 'escaner'
                WHERE e.status != 0
                GROUP BY e.id_escaner
                
                UNION ALL
                
                SELECT 
                    'pc_torre' as tipo_equipo,
                    p.id_pc_torre as id_equipo,
                    p.numero_pc as numero,
                    p.marca,
                    p.modelo,
                    p.estado,
                    p.disponibilidad,
                    COUNT(m.id_movimiento) as total_movimientos,
                    MAX(m.fecha_hora) as ultimo_movimiento
                FROM tbl_pc_torre p
                LEFT JOIN tbl_equipos_movimientos m ON p.id_pc_torre = m.id_equipo AND m.tipo_equipo = 'pc_torre'
                WHERE p.status != 0
                GROUP BY p.id_pc_torre
                
                UNION ALL
                
                SELECT 
                    'todo_en_uno' as tipo_equipo,
                    t.id_todo_en_uno as id_equipo,
                    t.numero_pc as numero,
                    t.marca,
                    t.modelo,
                    t.estado,
                    t.disponibilidad,
                    COUNT(m.id_movimiento) as total_movimientos,
                    MAX(m.fecha_hora) as ultimo_movimiento
                FROM tbl_todo_en_uno t
                LEFT JOIN tbl_equipos_movimientos m ON t.id_todo_en_uno = m.id_equipo AND m.tipo_equipo = 'todo_en_uno'
                WHERE t.status != 0
                GROUP BY t.id_todo_en_uno
                
                UNION ALL
                
                SELECT 
                    'portatil' as tipo_equipo,
                    p.id_portatil as id_equipo,
                    p.numero_pc as numero,
                    p.marca,
                    p.modelo,
                    p.estado,
                    p.disponibilidad,
                    COUNT(m.id_movimiento) as total_movimientos,
                    MAX(m.fecha_hora) as ultimo_movimiento
                FROM tbl_portatiles p
                LEFT JOIN tbl_equipos_movimientos m ON p.id_portatil = m.id_equipo AND m.tipo_equipo = 'portatil'
                WHERE p.status != 0
                GROUP BY p.id_portatil
                
                ORDER BY ultimo_movimiento DESC";
        
        return $this->select_all($sql);
    }

    public function getHojaVidaEquipo($idEquipo, $tipoEquipo)
    {
        $equipo = $this->getDetalleEquipo($idEquipo, $tipoEquipo);
        $movimientos = $this->getMovimientosEquipo($idEquipo, $tipoEquipo);
        
        return [
            'tipo_equipo' => $tipoEquipo,
            'equipo' => $equipo ?: [],
            'movimientos' => $movimientos ?: []
        ];
    }

    private function getDetalleEquipo($idEquipo, $tipoEquipo)
    {
        $sql = "";
        switch ($tipoEquipo) {
            case 'impresora':
                $sql = "SELECT * FROM tbl_impresoras WHERE id_impresora = ? AND status != 0";
                break;
            case 'escaner':
                $sql = "SELECT * FROM tbl_escaneres WHERE id_escaner = ? AND status != 0";
                break;
            case 'pc_torre':
                $sql = "SELECT * FROM tbl_pc_torre WHERE id_pc_torre = ? AND status != 0";
                break;
            case 'todo_en_uno':
                $sql = "SELECT * FROM tbl_todo_en_uno WHERE id_todo_en_uno = ? AND status != 0";
                break;
            case 'portatil':
                $sql = "SELECT * FROM tbl_portatiles WHERE id_portatil = ? AND status != 0";
                break;
        }
        
        if (!empty($sql)) {
            $result = $this->select($sql, [$idEquipo]);
            return $result ?: null;
        }
        return null;
    }

    private function getMovimientosEquipo($idEquipo, $tipoEquipo)
    {
        $sql = "SELECT * FROM tbl_equipos_movimientos 
                WHERE id_equipo = ? AND tipo_equipo = ? 
                ORDER BY fecha_hora DESC";
        $result = $this->select_all($sql, [$idEquipo, $tipoEquipo]);
        return $result ?: [];
    }
}