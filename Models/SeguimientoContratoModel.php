<?php
class SeguimientoContratoModel extends Mysql
{
    private $intId;
    private $strObjetoContrato;
    private $strFechaInicio;
    private $strFechaTerminacion;
    private $intPlazoMeses;
    private $decValorTotalContrato;
    private $strDiaCorteInforme;
    private $strObservacionesEjecucion;
    private $strEvidenciadoSecop;
    private $strFechaVerificacion;
    private $decLiquidacion;
    private $intEstado;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertContrato(
        string $objeto_contrato,
        string $fecha_inicio,
        string $fecha_terminacion,
        int $plazo_meses,
        float $valor_total_contrato,
        string $dia_corte_informe,
        string $observaciones_ejecucion,
        string $evidenciado_secop,
        string $fecha_verificacion,
        float $liquidacion,
        int $estado
    ) {
        $this->strObjetoContrato = $objeto_contrato;
        $this->strFechaInicio = $fecha_inicio;
        $this->strFechaTerminacion = $fecha_terminacion;
        $this->intPlazoMeses = $plazo_meses;
        $this->decValorTotalContrato = $valor_total_contrato;
        $this->strDiaCorteInforme = $dia_corte_informe;
        $this->strObservacionesEjecucion = $observaciones_ejecucion;
        $this->strEvidenciadoSecop = $evidenciado_secop;
        $this->strFechaVerificacion = $fecha_verificacion;
        $this->decLiquidacion = $liquidacion;
        $this->intEstado = $estado;

        $return = 0;
        $sql = "SELECT * FROM seguimiento_contrato WHERE objeto_contrato = '{$this->strObjetoContrato}'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT INTO seguimiento_contrato(objeto_contrato, fecha_inicio, fecha_terminacion, plazo_meses, valor_total_contrato, dia_corte_informe, observaciones_ejecucion, evidenciado_secop, fecha_verificacion, liquidacion, estado) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
            $arrData = array(
                $this->strObjetoContrato,
                $this->strFechaInicio,
                $this->strFechaTerminacion,
                $this->intPlazoMeses,
                $this->decValorTotalContrato,
                $this->strDiaCorteInforme,
                $this->strObservacionesEjecucion,
                $this->strEvidenciadoSecop,
                $this->strFechaVerificacion,
                $this->decLiquidacion,
                $this->intEstado
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function selectContratos()
    {
        $sql = "SELECT * FROM seguimiento_contrato WHERE estado != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectContrato(int $id)
    {
        $this->intId = $id;
        $sql = "SELECT * FROM seguimiento_contrato WHERE id = $this->intId";
        $request = $this->select($sql);
        return $request;
    }
    
    public function updateContrato(
        int $id,
        string $objeto_contrato,
        string $fecha_inicio,
        string $fecha_terminacion,
        int $plazo_meses,
        float $valor_total_contrato,
        string $dia_corte_informe,
        string $observaciones_ejecucion,
        string $evidenciado_secop,
        string $fecha_verificacion,
        float $liquidacion,
        int $estado
    ) {
        $this->intId = $id;
        $this->strObjetoContrato = $objeto_contrato;
        $this->strFechaInicio = $fecha_inicio;
        $this->strFechaTerminacion = $fecha_terminacion;
        $this->intPlazoMeses = $plazo_meses;
        $this->decValorTotalContrato = $valor_total_contrato;
        $this->strDiaCorteInforme = $dia_corte_informe;
        $this->strObservacionesEjecucion = $observaciones_ejecucion;
        $this->strEvidenciadoSecop = $evidenciado_secop;
        $this->strFechaVerificacion = $fecha_verificacion;
        $this->decLiquidacion = $liquidacion;
        $this->intEstado = $estado;

        $sql = "SELECT * FROM seguimiento_contrato WHERE (objeto_contrato = '{$this->strObjetoContrato}' AND id != $this->intId)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE seguimiento_contrato SET objeto_contrato=?, fecha_inicio=?, fecha_terminacion=?, plazo_meses=?, valor_total_contrato=?, dia_corte_informe=?, observaciones_ejecucion=?, evidenciado_secop=?, fecha_verificacion=?, liquidacion=?, estado=? WHERE id = ?";
            $arrData = array(
                $this->strObjetoContrato,
                $this->strFechaInicio,
                $this->strFechaTerminacion,
                $this->intPlazoMeses,
                $this->decValorTotalContrato,
                $this->strDiaCorteInforme,
                $this->strObservacionesEjecucion,
                $this->strEvidenciadoSecop,
                $this->strFechaVerificacion,
                $this->decLiquidacion,
                $this->intEstado,
                $this->intId
            );
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteContrato(int $id)
    {
        $this->intId = $id;
        $sql = "UPDATE seguimiento_contrato SET estado = ? WHERE id = $this->intId ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }
} 