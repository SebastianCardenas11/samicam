<?php
class FuncionariosViaticosModel extends Mysql
{
    private $intIdViatico;
    private $intIdFuncionario;
    private $strDescripcion;
    private $floatMonto;
    private $strFechaUso;
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
        string $fecha,
        string $uso
    ){
        $this->intIdFuncionario = $funci_fk;
        $this->strDescripcion = $descripcion;
        $this->floatMonto = $monto;
        $this->strFechaUso = $fecha;
        $this->strUso = $uso;
        $this->intEstatus = 1; // Por defecto activo

        $return = 0;
        
        // Verificar que el funcionario existe
        $sqlFunc = "SELECT idefuncionario FROM tbl_funcionarios WHERE idefuncionario = ? AND status = 1";
        $requestFunc = $this->select($sqlFunc, [$this->intIdFuncionario]);
        
        if (empty($requestFunc)) {
            return "nofunc"; // Funcionario no existe o no está activo
        }
        
        // Verificamos si ya existe un viático con la misma fecha y funcionario
        $sql = "SELECT * FROM tbl_viaticos WHERE funci_fk = ? AND fecha = ?";
        $request = $this->select_all($sql, [$this->intIdFuncionario, $this->strFechaUso]);    

        if (empty($request)) {
            $sql = "INSERT INTO tbl_viaticos (funci_fk, descripcion, monto, fecha, uso, estatus) VALUES (?, ?, ?, ?, ?, ?)";

            $arrData = array(
                $this->intIdFuncionario, 
                $this->strDescripcion, 
                $this->floatMonto, 
                $this->strFechaUso, 
                $this->strUso, 
                $this->intEstatus
            );

            $request = $this->insert($sql, $arrData);
            return $request;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // Eliminar un viático
    public function deleteViatico(int $idViatico)
    {
        // Primero obtenemos el monto y la fecha del viático para actualizar el capital disponible
        $sql = "SELECT monto, fecha FROM tbl_viaticos WHERE idViatico = ? AND estatus = 1";
        $request = $this->select($sql, [$idViatico]);
        
        if (empty($request)) {
            return false;
        }
        
        $monto = $request['monto'];
        $year = date('Y', strtotime($request['fecha']));
        
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
        $sql = "SELECT f.idefuncionario, f.nombre_completo, SUM(v.monto) as total_viaticos
                FROM tbl_viaticos v
                INNER JOIN tbl_funcionarios f ON v.funci_fk = f.idefuncionario
                WHERE YEAR(v.fecha) = ? AND v.estatus = 1
                GROUP BY f.idefuncionario, f.nombre_completo";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Obtener detalle de viáticos otorgados a funcionarios con descripción y uso
    public function getDetalleViaticos($year)
    {
        $sql = "SELECT v.idViatico, f.nombre_completo, v.descripcion, v.monto, v.fecha, v.uso
                FROM tbl_viaticos v
                INNER JOIN tbl_funcionarios f ON v.funci_fk = f.idefuncionario
                WHERE YEAR(v.fecha) = ? AND v.estatus = 1
                ORDER BY v.fecha DESC";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Obtener funcionarios con tipo de contrato Carrera o Libre nombramiento
    public function getFuncionariosValidos()
    {
        // Consulta directa para obtener funcionarios con contrato de tipo 1 (Carrera) o 2 (Libre Nombramiento)
        $sql = "SELECT f.idefuncionario, f.nombre_completo, c.tipo_cont 
                FROM tbl_funcionarios f 
                INNER JOIN tbl_contrato c ON f.contrato_fk = c.id_contrato 
                WHERE f.contrato_fk IN (1, 2) AND f.status = 1";
        
        $request = $this->select_all($sql);
        return $request;
    }

    // Obtener capital disponible para el año actual
    public function getCapitalDisponible($year)
    {
        $sql = "SELECT capital_total, capital_disponible FROM tbl_capital_viaticos WHERE anio = ?";
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
        $sql = "SELECT idefuncionario, nombre_completo, contrato_fk 
                FROM tbl_funcionarios 
                WHERE contrato_fk IN (1, 2)";
        $request = $this->select_all($sql);
        return $request;
    }

}