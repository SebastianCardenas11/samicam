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

    // Obtener capital disponible para el año actual
    public function getCapitalDisponible($year)
    {
        $sql = "SELECT capital_disponible as total FROM tbl_capital_viaticos WHERE anio = ?";
        $request = $this->select($sql, [$year]);
        return $request['total'] ?? 0;
    }

    // Insertar o actualizar presupuesto anual
    public function setPresupuestoAnual($year, $capitalTotal)
    {
        $sqlCheck = "SELECT idCapital FROM tbl_capital_viaticos WHERE anio = ?";
        $requestCheck = $this->select($sqlCheck, [$year]);
        if ($requestCheck) {
            $sqlUpdate = "UPDATE tbl_capital_viaticos SET capital_total = ?, capital_disponible = ? WHERE anio = ?";
            $arrData = [$capitalTotal, $capitalTotal, $year];
            $request = $this->update($sqlUpdate, $arrData);
        } else {
            $sqlInsert = "INSERT INTO tbl_capital_viaticos (anio, capital_total, capital_disponible) VALUES (?, ?, ?)";
            $arrData = [$year, $capitalTotal, $capitalTotal];
            $request = $this->insert($sqlInsert, $arrData);
        }
        return $request;
    }

    // Obtener histórico de viáticos otorgados por funcionario para el año
    public function getHistoricoViaticos($year)
    {
        $sql = "SELECT f.idFuncionario, f.nombre, SUM(v.monto) as total_viaticos
                FROM tbl_viaticos v
                INNER JOIN tbl_funcionarios f ON v.funci_fk = f.idFuncionario
                WHERE YEAR(v.fecha) = ? AND v.estatus = 1
                GROUP BY f.idFuncionario, f.nombre";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Obtener detalle de viáticos otorgados a funcionarios con descripción y uso
    public function getDetalleViaticos($year)
    {
        $sql = "SELECT v.idViatico, f.nombre, v.descripcion, v.monto, v.fecha, v.uso
                FROM tbl_viaticos v
                INNER JOIN tbl_funcionarios f ON v.funci_fk = f.idFuncionario
                WHERE YEAR(v.fecha) = ? AND v.estatus = 1
                ORDER BY v.fecha DESC";
        $request = $this->select_all($sql, [$year]);
        return $request;
    }

    // Insertar nuevo viático
    public function insertViatico(int $idFuncionario, string $descripcion, float $monto, string $fecha, string $uso)
    {
        $this->intIdFuncionario = $idFuncionario;
        $this->strDescripcion = $descripcion;
        $this->floatMonto = $monto;
        $this->strFechaUso = $fecha;
        $this->strUso = $uso;
        $this->intEstatus = 1;

        $sql = "INSERT INTO tbl_viaticos (idFuncionario, descripcion, monto, fecha, uso, estatus) VALUES (?, ?, ?, ?, ?, ?)";
        $arrData = array($this->intIdFuncionario, $this->strDescripcion, $this->floatMonto, $this->strFechaUso, $this->strUso, $this->intEstatus);
        $request = $this->insert($sql, $arrData);
        return $request;
    }

    // Obtener funcionarios con tipo de contrato Carrera o Libre nombramiento
    public function getFuncionariosValidos()
    {
        $sql = "SELECT idFuncionario, nombre FROM tbl_funcionarios WHERE tipoContrato IN ('Carrera', 'Libre nombramiento') AND estatus = 1";
        $request = $this->select_all($sql);
        return $request;
    }
}
