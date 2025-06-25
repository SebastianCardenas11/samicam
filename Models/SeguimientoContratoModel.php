<?php
class SeguimientoContratoModel extends Mysql
{
    private $intId;
    private $strObjetoContrato;
    private $strFechaInicio;
    private $strFechaTerminacion;
    private $intPlazo;
    private $strTipoPlazo;
    private $decValorTotalContrato;
    private $strDiaCorteInforme;
    private $strObservacionesEjecucion;
    private $strEvidenciadoSecop;
    private $strFechaVerificacion;
    private $decLiquidacion;
    private $intEstado;
    private $strNumeroContrato;
    private $strFechaAprobacionEntidad;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertContrato(
        string $objeto_contrato,
        string $fecha_inicio,
        string $fecha_terminacion,
        string $fecha_aprobacion_entidad,
        string $numero_contrato,
        int $plazo,
        string $tipo_plazo,
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
        $this->intPlazo = $plazo;
        $this->strTipoPlazo = $tipo_plazo;
        $this->decValorTotalContrato = $valor_total_contrato;
        $this->strDiaCorteInforme = $dia_corte_informe;
        $this->strObservacionesEjecucion = $observaciones_ejecucion;
        $this->strEvidenciadoSecop = $evidenciado_secop;
        $this->strFechaVerificacion = $fecha_verificacion;
        $this->decLiquidacion = $liquidacion;
        $this->intEstado = $estado;
        $this->strNumeroContrato = $numero_contrato;
        $this->strFechaAprobacionEntidad = $fecha_aprobacion_entidad;

        $query_insert = "INSERT INTO seguimiento_contrato(numero_contrato, objeto_contrato, fecha_inicio, fecha_terminacion, fecha_aprobacion_entidad, plazo, tipo_plazo, valor_total_contrato, dia_corte_informe, observaciones_ejecucion, evidenciado_secop, fecha_verificacion, liquidacion, estado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array(
            $this->strNumeroContrato,
            $this->strObjetoContrato,
            $this->strFechaInicio,
            $this->strFechaTerminacion,
            $this->strFechaAprobacionEntidad,
            $this->intPlazo,
            $this->strTipoPlazo,
            $this->decValorTotalContrato,
            $this->strDiaCorteInforme,
            $this->strObservacionesEjecucion,
            $this->strEvidenciadoSecop,
            $this->strFechaVerificacion,
            $this->decLiquidacion,
            $this->intEstado
        );
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
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
        string $fecha_aprobacion_entidad,
        string $numero_contrato,
        int $plazo,
        string $tipo_plazo,
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
        $this->intPlazo = $plazo;
        $this->strTipoPlazo = $tipo_plazo;
        $this->decValorTotalContrato = $valor_total_contrato;
        $this->strDiaCorteInforme = $dia_corte_informe;
        $this->strObservacionesEjecucion = $observaciones_ejecucion;
        $this->strEvidenciadoSecop = $evidenciado_secop;
        $this->strFechaVerificacion = $fecha_verificacion;
        $this->decLiquidacion = $liquidacion;
        $this->intEstado = $estado;
        $this->strNumeroContrato = $numero_contrato;
        $this->strFechaAprobacionEntidad = $fecha_aprobacion_entidad;

        $sql = "UPDATE seguimiento_contrato SET numero_contrato=?, objeto_contrato=?, fecha_inicio=?, fecha_terminacion=?, fecha_aprobacion_entidad=?, plazo=?, tipo_plazo=?, valor_total_contrato=?, dia_corte_informe=?, observaciones_ejecucion=?, evidenciado_secop=?, fecha_verificacion=?, liquidacion=?, estado=? WHERE id = ?";
        $arrData = array(
            $this->strNumeroContrato,
            $this->strObjetoContrato,
            $this->strFechaInicio,
            $this->strFechaTerminacion,
            $this->strFechaAprobacionEntidad,
            $this->intPlazo,
            $this->strTipoPlazo,
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

    public function selectContratosPorVencer(int $dias)
    {
        $sql = "SELECT id, numero_contrato, objeto_contrato, fecha_terminacion, DATEDIFF(fecha_terminacion, CURDATE()) as dias_restantes
                FROM seguimiento_contrato 
                WHERE estado = 1 AND fecha_terminacion BETWEEN DATE_SUB(CURDATE(), INTERVAL 15 DAY) AND DATE_ADD(CURDATE(), INTERVAL $dias DAY)
                ORDER BY dias_restantes ASC";
        $request = $this->select_all($sql);
        return $request;
    }

    // Guardar prórroga y actualizar fecha de terminación
    public function saveProrrogaContrato($id_contrato, $fecha_anterior, $nueva_fecha, $dias_prorroga, $motivo) {
        // 1. Insertar prórroga
        $sqlProrroga = "INSERT INTO prorrogas_contrato (id_contrato, fecha_anterior, nueva_fecha, dias_prorroga, motivo) VALUES (?, ?, ?, ?, ?)";
        $arrDataProrroga = array($id_contrato, $fecha_anterior, $nueva_fecha, $dias_prorroga, $motivo);
        $requestProrroga = $this->insert($sqlProrroga, $arrDataProrroga);
        // 2. Actualizar fecha de terminación en el contrato principal
        $sqlUpdate = "UPDATE seguimiento_contrato SET fecha_terminacion = ? WHERE id = ?";
        $arrDataUpdate = array($nueva_fecha, $id_contrato);
        $requestUpdate = $this->update($sqlUpdate, $arrDataUpdate);
        return ($requestProrroga && $requestUpdate);
    }

    // Obtener historial de prórrogas de un contrato
    public function getProrrogasContrato($id_contrato) {
        $sql = "SELECT * FROM prorrogas_contrato WHERE id_contrato = ? ORDER BY fecha_registro DESC";
        $arrData = array($id_contrato);
        return $this->select_all($sql, $arrData);
    }
} 