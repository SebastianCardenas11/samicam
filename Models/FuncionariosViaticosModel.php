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
    
    // Insertar nuevo viático
    public function insertViatico(
        int $funci_fk,
        string $descripcion,
        float $monto,
        string $fecha_aprobacion,
        string $fecha_salida,
        string $fecha_regreso,
        string $uso
    ){
        $this->intIdFuncionario = $funci_fk;
        $this->strDescripcion = $descripcion;
        $this->floatMonto = $monto;
        $this->strFechaAprobacion = $fecha_aprobacion;
        $this->strFechaSalida = $fecha_salida;
        $this->strFechaRegreso = $fecha_regreso;
        $this->strUso = $uso;
        $this->intEstatus = 1; // Por defecto activo

        $return = 0;
        
        // Verificar si hay suficiente capital disponible
        $year = date('Y', strtotime($this->strFechaAprobacion));
        $capitalDisponible = $this->getCapitalDisponible($year);
        
        if ($this->floatMonto > $capitalDisponible) {
            return "nocapital"; // No hay suficiente capital disponible
        }
        
        $sql = "INSERT INTO tbl_viaticos (funci_fk, descripcion, monto, fecha_aprobacion, fecha_salida, fecha_regreso, uso, estatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $arrData = array(
            $this->intIdFuncionario, 
            $this->strDescripcion, 
            $this->floatMonto, 
            $this->strFechaAprobacion,
            $this->strFechaSalida,
            $this->strFechaRegreso,
            $this->strUso, 
            $this->intEstatus
        );

        $request = $this->insert($sql, $arrData);
        
        if ($request > 0) {
            // Actualizar el capital disponible
            $nuevoCapital = $capitalDisponible - $this->floatMonto;
            $this->actualizarCapitalDisponible($year, $nuevoCapital);
        }
        
        return $request;
    }

    // Eliminar un viático
    public function deleteViatico(int $idViatico)
    {
        // Primero obtenemos el monto y la fecha del viático para actualizar el capital disponible
        $sql = "SELECT monto, fecha_aprobacion FROM tbl_viaticos WHERE idViatico = ? AND estatus = 1";
        $request = $this->select($sql, [$idViatico]);
        
        if (empty($request)) {
            return false;
        }
        
        $monto = $request['monto'];
        $year = date('Y', strtotime($request['fecha_aprobacion']));
        
        // Actualizamos el estatus del viático a 0 (eliminado)
        $sql = "UPDATE tbl_viaticos SET estatus = 0 WHERE idViatico = ?";
        $request = $this->update($sql, [$idViatico]);
        
        if ($request) {
            // Devolvemos el monto al capital disponible
            $sqlCapital = "SELECT capital_disponible FROM tbl_capital_viaticos WHERE anio = ?";
            $requestCapital = $this->select($sqlCapital, [$year]);
            
            if ($requestCapital) {
                $capitalDisponible = $requestCapital['capital_disponible'];
                $nuevoCapital = $capitalDisponible + $monto;
                
                $sqlUpdate = "UPDATE tbl_capital_viaticos SET capital_disponible = ? WHERE anio = ?";
                $this->update($sqlUpdate, [$nuevoCapital, $year]);
            }
            
            return true;
        }
        
        return false;
    }

    // Obtener histórico de viáticos otorgados por funcionario para el año
    public function getHistoricoViaticos($year)
    {
        $sql = "SELECT v.funci_fk as idefuncionario, 
                CONCAT('Funcionario ID: ', v.funci_fk) as nombre_completo, 
                SUM(v.monto) as total_viaticos
                FROM tbl_viaticos v
                WHERE YEAR(v.fecha_aprobacion) = ? AND v.estatus = 1
                GROUP BY v.funci_fk";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Obtener detalle de viáticos otorgados a funcionarios con descripción y uso
    public function getDetalleViaticos($year)
    {
        $sql = "SELECT v.idViatico, 
                CONCAT('Funcionario ID: ', v.funci_fk) as nombre_completo, 
                v.descripcion, v.monto, 
                v.fecha_aprobacion, v.fecha_salida, v.fecha_regreso, v.uso, v.estatus
                FROM tbl_viaticos v
                WHERE YEAR(v.fecha_aprobacion) = ? AND v.estatus = 1
                ORDER BY v.fecha_aprobacion DESC";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Obtener un viático específico por ID
    public function getViatico(int $idViatico)
    {
        $sql = "SELECT v.*, CONCAT('Funcionario ID: ', v.funci_fk) as nombre_completo
                FROM tbl_viaticos v
                WHERE v.idViatico = ?";
        $request = $this->select($sql, [$idViatico]);
        return $request;
    }

    // Obtener todos los viáticos del año (activos y eliminados)
    public function getAllViaticos($year)
    {
        $sql = "SELECT v.*, CONCAT('Funcionario ID: ', v.funci_fk) as nombre_completo
                FROM tbl_viaticos v
                WHERE YEAR(v.fecha_aprobacion) = ?
                ORDER BY v.fecha_aprobacion DESC";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Obtener funcionarios con tipo de contrato Carrera o Libre nombramiento
    public function getFuncionariosValidos()
    {
        // Devolver los IDs de funcionarios que ya tienen viáticos
        $sql = "SELECT DISTINCT funci_fk as idefuncionario, 
                CONCAT('Funcionario ID: ', funci_fk) as nombre_completo, 
                'N/A' as tipo_cont
                FROM tbl_viaticos 
                WHERE estatus = 1";
        
        $request = $this->select_all($sql);
        return $request;
    }

    // Obtener capital disponible para el año actual
    public function getCapitalDisponible($year)
    {
        $sql = "SELECT capital_disponible FROM tbl_capital_viaticos WHERE anio = ?";
        $request = $this->select($sql, [$year]);
        if ($request) {
            return $request['capital_disponible'];
        }
        return 0;
    }

    // Obtener información completa del presupuesto
    public function getPresupuestoInfo($year)
    {
        $sql = "SELECT anio, capital_total, capital_disponible FROM tbl_capital_viaticos WHERE anio = ?";
        $request = $this->select($sql, [$year]);
        if (!$request) {
            // Si no hay presupuesto para ese año, devolvemos valores por defecto
            return [
                'anio' => $year,
                'capital_total' => 0,
                'capital_disponible' => 0
            ];
        }
        return $request;
    }

    // Actualizar capital disponible después de asignar un viático
    public function actualizarCapitalDisponible($year, $nuevoCapital)
    {
        $sql = "UPDATE tbl_capital_viaticos SET capital_disponible = ? WHERE anio = ?";
        $arrData = [$nuevoCapital, $year];
        $request = $this->update($sql, $arrData);
        return $request;
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

}