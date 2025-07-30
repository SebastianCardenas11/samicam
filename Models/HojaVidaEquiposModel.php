<?php

class HojaVidaEquiposModel extends MySql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function selectEquipos()
    {
        $equipos = array();
        
        // PC Torre
        $sql = "SELECT 
                    id_pc_torre as id,
                    'PC Torre' as tipo,
                    numero_pc as numero_equipo,
                    marca,
                    modelo,
                    COALESCE(serial, 'N/A') as serial,
                    estado,
                    disponibilidad,
                    fecha_registro
                FROM tbl_pc_torre
                WHERE status = 1";
        $request = $this->select_all($sql);
        if (!empty($request)) {
            $equipos = array_merge($equipos, $request);
        }

        // Portátiles
        $sql = "SELECT 
                    id_portatil as id,
                    'Portátil' as tipo,
                    numero_pc as numero_equipo,
                    marca,
                    modelo,
                    COALESCE(serial, 'N/A') as serial,
                    estado,
                    disponibilidad,
                    fecha_registro
                FROM tbl_portatiles
                WHERE status = 1";
        $request = $this->select_all($sql);
        if (!empty($request)) {
            $equipos = array_merge($equipos, $request);
        }

        // Todo en Uno
        $sql = "SELECT 
                    id_todo_en_uno as id,
                    'Todo en Uno' as tipo,
                    numero_pc as numero_equipo,
                    marca,
                    modelo,
                    COALESCE(serial, 'N/A') as serial,
                    estado,
                    disponibilidad,
                    fecha_registro
                FROM tbl_todo_en_uno
                WHERE status = 1";
        $request = $this->select_all($sql);
        if (!empty($request)) {
            $equipos = array_merge($equipos, $request);
        }

        // Impresoras
        $sql = "SELECT 
                    id_impresora as id,
                    'Impresora' as tipo,
                    numero_impresora as numero_equipo,
                    marca,
                    modelo,
                    COALESCE(serial, 'N/A') as serial,
                    estado,
                    disponibilidad,
                    fecha_registro
                FROM tbl_impresoras
                WHERE status = 1";
        $request = $this->select_all($sql);
        if (!empty($request)) {
            $equipos = array_merge($equipos, $request);
        }

        // Escáneres
        $sql = "SELECT 
                    id_escaner as id,
                    'Escáner' as tipo,
                    numero_escaner as numero_equipo,
                    marca,
                    modelo,
                    COALESCE(serial, 'N/A') as serial,
                    estado,
                    disponibilidad,
                    fecha_registro
                FROM tbl_escaneres
                WHERE status = 1";
        $request = $this->select_all($sql);
        if (!empty($request)) {
            $equipos = array_merge($equipos, $request);
        }

        return $equipos;
    }

    public function selectEquipo($idequipo, $tipo)
    {
        $sql = "";
        
        switch ($tipo) {
            case 'PC Torre':
                $sql = "SELECT 
                            id_pc_torre as id,
                            'PC Torre' as tipo,
                            numero_pc as numero_equipo,
                            marca,
                            modelo,
                            COALESCE(serial, 'N/A') as serial,
                            COALESCE(ram, 'N/A') as ram,
                            COALESCE(velocidad_ram, 'N/A') as velocidad_ram,
                            COALESCE(procesador, 'N/A') as procesador,
                            COALESCE(velocidad_procesador, 'N/A') as velocidad_procesador,
                            COALESCE(disco_duro, 'N/A') as disco_duro,
                            COALESCE(capacidad, 'N/A') as capacidad,
                            COALESCE(sistema_operativo, 'N/A') as sistema_operativo,
                            COALESCE(numero_activo, 'N/A') as numero_activo,
                            COALESCE(monitor, 'N/A') as monitor,
                            COALESCE(numero_activo_monitor, 'N/A') as numero_activo_monitor,
                            COALESCE(serial_monitor, 'N/A') as serial_monitor,
                            estado,
                            disponibilidad,
                            fecha_registro
                        FROM tbl_pc_torre
                        WHERE id_pc_torre = $idequipo AND status = 1";
                break;
            case 'Portátil':
                $sql = "SELECT 
                            id_portatil as id,
                            'Portátil' as tipo,
                            numero_pc as numero_equipo,
                            marca,
                            modelo,
                            COALESCE(serial, 'N/A') as serial,
                            COALESCE(ram, 'N/A') as ram,
                            COALESCE(velocidad_ram, 'N/A') as velocidad_ram,
                            COALESCE(procesador, 'N/A') as procesador,
                            COALESCE(velocidad_procesador, 'N/A') as velocidad_procesador,
                            COALESCE(disco_duro, 'N/A') as disco_duro,
                            COALESCE(capacidad, 'N/A') as capacidad,
                            COALESCE(sistema_operativo, 'N/A') as sistema_operativo,
                            COALESCE(numero_activo, 'N/A') as numero_activo,
                            estado,
                            disponibilidad,
                            fecha_registro
                        FROM tbl_portatiles
                        WHERE id_portatil = $idequipo AND status = 1";
                break;
            case 'Todo en Uno':
                $sql = "SELECT 
                            id_todo_en_uno as id,
                            'Todo en Uno' as tipo,
                            numero_pc as numero_equipo,
                            marca,
                            modelo,
                            COALESCE(serial, 'N/A') as serial,
                            COALESCE(ram, 'N/A') as ram,
                            COALESCE(velocidad_ram, 'N/A') as velocidad_ram,
                            COALESCE(procesador, 'N/A') as procesador,
                            COALESCE(velocidad_procesador, 'N/A') as velocidad_procesador,
                            COALESCE(disco_duro, 'N/A') as disco_duro,
                            COALESCE(capacidad, 'N/A') as capacidad,
                            COALESCE(sistema_operativo, 'N/A') as sistema_operativo,
                            COALESCE(numero_activo, 'N/A') as numero_activo,
                            estado,
                            disponibilidad,
                            fecha_registro
                        FROM tbl_todo_en_uno
                        WHERE id_todo_en_uno = $idequipo AND status = 1";
                break;
            case 'Impresora':
                $sql = "SELECT 
                            id_impresora as id,
                            'Impresora' as tipo,
                            numero_impresora as numero_equipo,
                            marca,
                            modelo,
                            COALESCE(serial, 'N/A') as serial,
                            COALESCE(consumible, 'N/A') as consumible,
                            estado,
                            disponibilidad,
                            fecha_registro
                        FROM tbl_impresoras
                        WHERE id_impresora = $idequipo AND status = 1";
                break;
            case 'Escáner':
                $sql = "SELECT 
                            id_escaner as id,
                            'Escáner' as tipo,
                            numero_escaner as numero_equipo,
                            marca,
                            modelo,
                            COALESCE(serial, 'N/A') as serial,
                            estado,
                            disponibilidad,
                            fecha_registro
                        FROM tbl_escaneres
                        WHERE id_escaner = $idequipo AND status = 1";
                break;
        }
        
        if (!empty($sql)) {
            $request = $this->select($sql);
            return $request;
        }
        
        return array();
    }
    
    public function getMovimientosEquipo($idequipo, $tipo)
    {
        // Mapear tipos de equipo a los valores de la tabla
        $tipoEquipoMap = [
            'PC Torre' => 'pc_torre',
            'Portátil' => 'portatil', 
            'Todo en Uno' => 'todo_en_uno',
            'Impresora' => 'impresora',
            'Escáner' => 'escaner'
        ];
        
        $tipoEquipo = isset($tipoEquipoMap[$tipo]) ? $tipoEquipoMap[$tipo] : strtolower($tipo);
        
        $sql = "SELECT 
                    DATE_FORMAT(fecha_hora, '%Y-%m-%d') as fecha,
                    CASE 
                        WHEN tipo_movimiento = 'entrada' THEN 'Entrada'
                        WHEN tipo_movimiento = 'salida' THEN 'Salida'
                        ELSE 'Movimiento'
                    END as tipo,
                    COALESCE(observacion, 'Sin observaciones') as descripcion,
                    usuario
                FROM tbl_equipos_movimientos 
                WHERE id_equipo = $idequipo 
                AND tipo_equipo = '$tipoEquipo'
                ORDER BY fecha_hora DESC";
        
        $request = $this->select_all($sql);
        
        // Si no hay movimientos, devolver array vacío
        if (empty($request)) {
            return [];
        }
        
        return $request;
    }
}