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
    
    public function selectMantenimientos($idequipo, $tipo)
    {
        $sql = "SELECT 
                    fecha_mantenimiento,
                    estacion_trabajo,
                    nombre_usuario,
                    cedula_usuario,
                    tipo_dispositivo,
                    error_reportado,
                    acciones_realizadas,
                    tecnico_servicio,
                    fecha_registro
                FROM tbl_mantenimientos_equipos 
                WHERE id_equipo = $idequipo 
                AND tipo_equipo = '$tipo'
                AND status = 1
                ORDER BY fecha_mantenimiento DESC";
        
        $request = $this->select_all($sql);
        return $request ?? [];
    }
    
    public function insertMantenimiento($idEquipo, $tipoEquipo, $fechaMantenimiento, $estacionTrabajo,
                                      $nombreUsuario, $cedulaUsuario, $tipoDispositivo, $errorReportado,
                                      $accionesRealizadas, $tecnicoServicio)
    {
        $sql = "INSERT INTO tbl_mantenimientos_equipos (
                    id_equipo, tipo_equipo, fecha_mantenimiento, estacion_trabajo,
                    nombre_usuario, cedula_usuario, tipo_dispositivo, error_reportado,
                    acciones_realizadas, tecnico_servicio
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $arrData = array(
            $idEquipo, $tipoEquipo, $fechaMantenimiento, $estacionTrabajo,
            $nombreUsuario, $cedulaUsuario, $tipoDispositivo, $errorReportado,
            $accionesRealizadas, $tecnicoServicio
        );
        
        $request = $this->insert($sql, $arrData);
        return $request;
    }
    
    public function selectTodosMantenimientos()
    {
        $sql = "SELECT 
                    m.fecha_mantenimiento,
                    m.estacion_trabajo,
                    m.nombre_usuario,
                    m.cedula_usuario,
                    m.tipo_dispositivo,
                    m.error_reportado,
                    m.acciones_realizadas,
                    m.tecnico_servicio,
                    CASE 
                        WHEN m.tipo_equipo = 'PC Torre' THEN (SELECT numero_pc FROM tbl_pc_torre WHERE id_pc_torre = m.id_equipo)
                        WHEN m.tipo_equipo = 'Portátil' THEN (SELECT numero_pc FROM tbl_portatiles WHERE id_portatil = m.id_equipo)
                        WHEN m.tipo_equipo = 'Todo en Uno' THEN (SELECT numero_pc FROM tbl_todo_en_uno WHERE id_todo_en_uno = m.id_equipo)
                        WHEN m.tipo_equipo = 'Impresora' THEN (SELECT numero_impresora FROM tbl_impresoras WHERE id_impresora = m.id_equipo)
                        WHEN m.tipo_equipo = 'Escáner' THEN (SELECT numero_escaner FROM tbl_escaneres WHERE id_escaner = m.id_equipo)
                        ELSE 'N/A'
                    END as numero_equipo
                FROM tbl_mantenimientos_equipos m
                WHERE m.status = 1
                ORDER BY m.fecha_mantenimiento DESC";
        
        $request = $this->select_all($sql);
        return $request ?? [];
    }
    
    public function getHistorialFuncionarios($idequipo, $tipo)
    {
        $sql = "SELECT 
                    h.fecha_asignacion,
                    h.fecha_desasignacion,
                    h.estado,
                    h.observaciones,
                    fp.nombre_completo as nombre_funcionario,
                    'Funcionario Planta' as tipo_funcionario_desc
                FROM tbl_historial_funcionarios_equipos h
                LEFT JOIN tbl_funcionarios_planta fp ON h.funcionario_planta_id = fp.idefuncionario
                WHERE h.id_equipo = $idequipo 
                AND h.tipo_equipo = '$tipo'
                ORDER BY h.fecha_asignacion DESC";
        
        $request = $this->select_all($sql);
        return $request ?? [];
    }
    
    public function getFuncionarioActual($idequipo, $tipo)
    {
        $sql = "SELECT 
                    fp.nombre_completo as nombre_funcionario,
                    'Funcionario Planta' as tipo_funcionario_desc
                FROM tbl_historial_funcionarios_equipos h
                LEFT JOIN tbl_funcionarios_planta fp ON h.funcionario_planta_id = fp.idefuncionario
                WHERE h.id_equipo = $idequipo 
                AND h.tipo_equipo = '$tipo'
                AND h.estado = 'activo'
                ORDER BY h.fecha_asignacion DESC
                LIMIT 1";
        
        $request = $this->select($sql);
        return $request ?? [];
    }
}