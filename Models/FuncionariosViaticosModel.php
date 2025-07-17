<?php
class FuncionariosViaticosModel extends Mysql
{
    private $intIdViatico;
    private $intIdFuncionario;
    private $strDescripcion;
    private $floatMonto;
    private $strFechaAprobacion;
    private $strFechaSalida;
    private $strFechaRegreso;
    private $intEstatus;
    private $strUso;

    public function __construct()
    {
        parent::__construct();
    }
    
    // Insertar nuevo viático (todos los campos)
    public function insertViatico(
        int $funci_fk,
        string $cargo,
        string $dependencia,
        string $motivo_gasto,
        string $lugar_comision_departamento,
        string $lugar_comision_ciudad,
        string $finalidad_comision,
        string $descripcion,
        string $fecha_aprobacion,
        string $fecha_salida,
        string $fecha_regreso,
        int $n_dias,
        float $valor_dia,
        float $valor_viatico,
        string $tipo_transporte,
        float $valor_transporte,
        float $total_liquidado
    ){
        $sql = "INSERT INTO tbl_viaticos (
            funci_fk, cargo, dependencia, motivo_gasto, lugar_comision_departamento, lugar_comision_ciudad, finalidad_comision, descripcion, fecha_aprobacion, fecha_salida, fecha_regreso, n_dias, valor_dia, valor_viatico, tipo_transporte, valor_transporte, total_liquidado, estatus
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $arrData = array(
            $funci_fk, $cargo, $dependencia, $motivo_gasto, $lugar_comision_departamento, $lugar_comision_ciudad, $finalidad_comision, $descripcion, $fecha_aprobacion, $fecha_salida, $fecha_regreso, $n_dias, $valor_dia, $valor_viatico, $tipo_transporte, $valor_transporte, $total_liquidado
        );
        $request = $this->insert($sql, $arrData);
        // Descontar el total_liquidado del capital disponible
        if ($request > 0) {
            $year = date('Y', strtotime($fecha_aprobacion));
            $sqlCapital = "SELECT capital_disponible FROM tbl_capital_viaticos WHERE anio = ?";
            $requestCapital = $this->select($sqlCapital, [$year]);
            if ($requestCapital) {
                $capitalDisponible = $requestCapital['capital_disponible'];
                $nuevoCapital = $capitalDisponible - $total_liquidado;
                $sqlUpdate = "UPDATE tbl_capital_viaticos SET capital_disponible = ? WHERE anio = ?";
                $this->update($sqlUpdate, [$nuevoCapital, $year]);
            }
        }
        return $request;
    }

    // Eliminar un viático
    public function deleteViatico(int $idViatico)
    {
        // Primero obtenemos el total_liquidado y la fecha del viático para actualizar el capital disponible
        $sql = "SELECT total_liquidado, fecha_aprobacion FROM tbl_viaticos WHERE idViatico = ? AND estatus = 1";
        $request = $this->select($sql, [$idViatico]);
        
        if (empty($request)) {
            return false;
        }
        
        $total_liquidado = $request['total_liquidado'];
        $year = date('Y', strtotime($request['fecha_aprobacion']));
        
        // Actualizamos el estatus del viático a 0 (eliminado)
        $sql = "UPDATE tbl_viaticos SET estatus = 0 WHERE idViatico = ?";
        $request = $this->update($sql, [$idViatico]);
        
        if ($request) {
            // Devolvemos el total_liquidado al capital disponible
            $sqlCapital = "SELECT capital_disponible FROM tbl_capital_viaticos WHERE anio = ?";
            $requestCapital = $this->select($sqlCapital, [$year]);
            
            if ($requestCapital) {
                $capitalDisponible = $requestCapital['capital_disponible'];
                $nuevoCapital = $capitalDisponible + $total_liquidado;
                $sqlUpdate = "UPDATE tbl_capital_viaticos SET capital_disponible = ? WHERE anio = ?";
                $this->update($sqlUpdate, [$nuevoCapital, $year]);
            }
            
            return true;
        }
        
        return false;
    }

    // Obtener histórico de viáticos otorgados por funcionario para el año (por cantidad)
    public function getHistoricoViaticos($year)
    {
        $sql = "SELECT v.funci_fk as idefuncionario, 
                fp.nombre_completo, 
                COUNT(v.idViatico) as total_viaticos_asignados,
                SUM(v.total_liquidado) as total_valor_viaticos
                FROM tbl_viaticos v
                INNER JOIN tbl_funcionarios_planta fp ON v.funci_fk = fp.idefuncionario
                WHERE YEAR(v.fecha_aprobacion) = ? AND v.estatus = 1
                GROUP BY v.funci_fk, fp.nombre_completo";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Obtener detalle de viáticos otorgados a funcionarios con todos los campos nuevos
    public function getDetalleViaticos($year)
    {
        $sql = "SELECT v.idViatico, 
                fp.nombre_completo, 
                v.cargo,
                v.dependencia,
                v.motivo_gasto,
                v.lugar_comision_departamento,
                v.lugar_comision_ciudad,
                v.finalidad_comision,
                v.descripcion, 
                v.fecha_aprobacion, v.fecha_salida, v.fecha_regreso,
                v.n_dias, v.valor_dia, v.valor_viatico, v.tipo_transporte, v.valor_transporte, v.total_liquidado
                FROM tbl_viaticos v
                INNER JOIN tbl_funcionarios_planta fp ON v.funci_fk = fp.idefuncionario
                WHERE YEAR(v.fecha_aprobacion) = ? AND v.estatus = 1
                ORDER BY v.fecha_aprobacion DESC";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Obtener un viático específico por ID
    public function getViatico(int $idViatico)
    {
        $sql = "SELECT v.*, 
                fp.nombre_completo,
                c.nombre as cargo,
                d.nombre as dependencia
                FROM tbl_viaticos v
                INNER JOIN tbl_funcionarios_planta fp ON v.funci_fk = fp.idefuncionario
                INNER JOIN tbl_cargos c ON fp.cargo_fk = c.idecargos
                INNER JOIN tbl_dependencia d ON fp.dependencia_fk = d.dependencia_pk
                WHERE v.idViatico = ?";
        $request = $this->select($sql, [$idViatico]);
        return $request;
    }

    // Obtener todos los viáticos del año (activos y eliminados)
    public function getAllViaticos($year)
    {
        $sql = "SELECT v.*, fp.nombre_completo
                FROM tbl_viaticos v
                INNER JOIN tbl_funcionarios_planta fp ON v.funci_fk = fp.idefuncionario
                WHERE YEAR(v.fecha_aprobacion) = ?
                ORDER BY v.fecha_aprobacion DESC";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Obtener funcionarios con tipo de contrato Carrera o Libre nombramiento
    public function getFuncionariosValidos()
    {
        $sql = "SELECT 
                fp.idefuncionario, 
                fp.nombre_completo,
                tc.tipo_cont
                FROM tbl_funcionarios_planta fp
                LEFT JOIN tbl_contrato tc ON fp.contrato_fk = tc.id_contrato
                WHERE fp.status = 1
                ORDER BY fp.nombre_completo ASC";
        
        $request = $this->select_all($sql);
        return $request;
    }

    // Obtener capital disponible para el año actual
    public function getCapitalDisponible($year)
    {
        // Obtener el capital total
        $sqlTotal = "SELECT capital_total FROM tbl_capital_viaticos WHERE anio = ?";
        $requestTotal = $this->select($sqlTotal, [$year]);
        $capitalTotal = $requestTotal ? floatval($requestTotal['capital_total']) : 0;
        // Sumar todos los viáticos entregados (activos) en el año
        $sqlUsado = "SELECT SUM(total_liquidado) as usado FROM tbl_viaticos WHERE YEAR(fecha_aprobacion) = ? AND estatus = 1";
        $requestUsado = $this->select($sqlUsado, [$year]);
        $usado = $requestUsado && $requestUsado['usado'] ? floatval($requestUsado['usado']) : 0;
        // Calcular disponible
        $capitalDisponible = $capitalTotal - $usado;
        if ($capitalDisponible < 0) $capitalDisponible = 0;
        return $capitalDisponible;
    }

    // Obtener información completa del presupuesto
    public function getPresupuestoInfo($year)
    {
        $sql = "SELECT anio, capital_total FROM tbl_capital_viaticos WHERE anio = ?";
        $request = $this->select($sql, [$year]);
        if (!$request) {
            // Si no hay presupuesto para ese año, devolvemos valores por defecto
            return [
                'anio' => $year,
                'capital_total' => 0,
                'capital_disponible' => 0
            ];
        }
        // Calcular capital_disponible en tiempo real
        $capitalTotal = floatval($request['capital_total']);
        $sqlUsado = "SELECT SUM(total_liquidado) as usado FROM tbl_viaticos WHERE YEAR(fecha_aprobacion) = ? AND estatus = 1";
        $requestUsado = $this->select($sqlUsado, [$year]);
        $usado = $requestUsado && $requestUsado['usado'] ? floatval($requestUsado['usado']) : 0;
        $capitalDisponible = $capitalTotal - $usado;
        if ($capitalDisponible < 0) $capitalDisponible = 0;
        return [
            'anio' => $year,
            'capital_total' => $capitalTotal,
            'capital_disponible' => $capitalDisponible
        ];
    }

    // Actualizar capital disponible después de asignar un viático (ya no es necesario, ahora es dummy)
    public function actualizarCapitalDisponible($year, $nuevoCapital)
    {
        // Ya no se actualiza manualmente, el capital disponible se calcula en tiempo real
        return true;
    }

    // Insertar o actualizar presupuesto anual
    public function setPresupuestoAnual($year, $capitalTotal)
    {
        $sqlCheck = "SELECT idCapital, capital_disponible, capital_total FROM tbl_capital_viaticos WHERE anio = ?";
        $requestCheck = $this->select($sqlCheck, [$year]);
        
        if ($requestCheck) {
            // Si ya existe un presupuesto, calculamos la diferencia para ajustar el disponible
            $capitalAnterior = $requestCheck['capital_total'];
            $disponibleAnterior = $requestCheck['capital_disponible'];
            
            // Calculamos cuánto se ha gastado
            $gastado = $capitalAnterior - $disponibleAnterior;
            
            // El nuevo disponible será el nuevo total menos lo gastado
            $nuevoDisponible = $capitalTotal - $gastado;
            
            // Si el nuevo disponible es negativo, lo ajustamos a 0
            if ($nuevoDisponible < 0) {
                $nuevoDisponible = 0;
            }
            
            $sqlUpdate = "UPDATE tbl_capital_viaticos SET capital_total = ?, capital_disponible = ? WHERE anio = ?";
            $arrData = [$capitalTotal, $nuevoDisponible, $year];
            $request = $this->update($sqlUpdate, $arrData);
        } else {
            $sqlInsert = "INSERT INTO tbl_capital_viaticos (anio, capital_total, capital_disponible) VALUES (?, ?, ?)";
            $arrData = [$year, $capitalTotal, $capitalTotal];
            $request = $this->insert($sqlInsert, $arrData);
        }
        return $request; 
    }
    
   public function selectFuncionariosPlanta() {
    $sql = "SELECT 
                idefuncionario, 
                nombre_completo, 
                contrato_fk 
            FROM tbl_funcionarios_planta";
    
    $request = $this->select_all($sql);
    return $request;
}

    // Viáticos entregados por mes (evolución anual)
    public function getViaticosPorMes($year) {
        $sql = "SELECT MONTH(fecha_aprobacion) as mes, SUM(total_liquidado) as total
                FROM tbl_viaticos
                WHERE YEAR(fecha_aprobacion) = ? AND estatus = 1
                GROUP BY mes
                ORDER BY mes";
        return $this->select_all($sql, [$year]);
    }

    // Capital total y disponible por mes (evolución mensual)
    public function getCapitalPorMes($year) {
        $sql = "SELECT anio, capital_total, capital_disponible
                FROM tbl_capital_viaticos
                WHERE anio = ?";
        return $this->select($sql, [$year]);
    }

    // Top ciudades de comisión por frecuencia
    public function getTopCiudadesComision($year, $limit = 10) {
        $limit = intval($limit);
        $sql = "SELECT lugar_comision_ciudad, COUNT(*) as frecuencia
                FROM tbl_viaticos
                WHERE YEAR(fecha_aprobacion) = ? AND estatus = 1
                  AND lugar_comision_ciudad IS NOT NULL
                  AND lugar_comision_ciudad != ''
                GROUP BY lugar_comision_ciudad
                ORDER BY frecuencia DESC
                LIMIT " . $limit;
        return $this->select_all($sql, [$year]);
    }

}