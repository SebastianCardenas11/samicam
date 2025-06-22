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

    // MÉTODOS PARA LIQUIDACIONES
    public function selectLiquidaciones(string $estado = '', string $fechaDesde = '', string $fechaHasta = '')
    {
        $sql = "SELECT l.*, c.numero_contrato, c.objeto_contrato 
                FROM liquidaciones l 
                INNER JOIN seguimiento_contrato c ON l.id_contrato = c.id 
                WHERE l.id_liquidacion > 0";
        
        if (!empty($estado)) {
            $sql .= " AND l.estado = '$estado'";
        }
        if (!empty($fechaDesde)) {
            $sql .= " AND l.fecha_liquidacion >= '$fechaDesde'";
        }
        if (!empty($fechaHasta)) {
            $sql .= " AND l.fecha_liquidacion <= '$fechaHasta'";
        }
        
        $sql .= " ORDER BY l.fecha_liquidacion DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectLiquidacion(int $id)
    {
        $sql = "SELECT l.*, c.numero_contrato, c.objeto_contrato 
                FROM liquidaciones l 
                INNER JOIN seguimiento_contrato c ON l.id_contrato = c.id 
                WHERE l.id_liquidacion = $id";
        $request = $this->select($sql);
        return $request;
    }

    public function insertLiquidacion(
        int $id_contrato,
        string $tipo_liquidacion,
        string $fecha_liquidacion,
        float $valor_liquidado,
        string $estado,
        string $responsable,
        string $numero_acta,
        float $valor_ejecutado,
        float $saldo_por_ejecutar,
        float $multas,
        float $descuentos,
        string $observaciones
    ) {
        $query_insert = "INSERT INTO liquidaciones(
            id_contrato, tipo_liquidacion, fecha_liquidacion, valor_liquidado, 
            estado, responsable, numero_acta, valor_ejecutado, saldo_por_ejecutar, 
            multas, descuentos, observaciones, fecha_creacion
        ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        
        $arrData = array(
            $id_contrato,
            $tipo_liquidacion,
            $fecha_liquidacion,
            $valor_liquidado,
            $estado,
            $responsable,
            $numero_acta,
            $valor_ejecutado,
            $saldo_por_ejecutar,
            $multas,
            $descuentos,
            $observaciones
        );
        
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function updateLiquidacion(
        int $id,
        int $id_contrato,
        string $tipo_liquidacion,
        string $fecha_liquidacion,
        float $valor_liquidado,
        string $estado,
        string $responsable,
        string $numero_acta,
        float $valor_ejecutado,
        float $saldo_por_ejecutar,
        float $multas,
        float $descuentos,
        string $observaciones
    ) {
        $sql = "UPDATE liquidaciones SET 
                id_contrato=?, tipo_liquidacion=?, fecha_liquidacion=?, valor_liquidado=?, 
                estado=?, responsable=?, numero_acta=?, valor_ejecutado=?, saldo_por_ejecutar=?, 
                multas=?, descuentos=?, observaciones=?, fecha_actualizacion=NOW() 
                WHERE id_liquidacion = ?";
        
        $arrData = array(
            $id_contrato,
            $tipo_liquidacion,
            $fecha_liquidacion,
            $valor_liquidado,
            $estado,
            $responsable,
            $numero_acta,
            $valor_ejecutado,
            $saldo_por_ejecutar,
            $multas,
            $descuentos,
            $observaciones,
            $id
        );
        
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteLiquidacion(int $id)
    {
        $sql = "DELETE FROM liquidaciones WHERE id_liquidacion = ?";
        $arrData = array($id);
        $request = $this->delete($sql, $arrData);
        return $request;
    }

    public function selectContratosActivos()
    {
        $sql = "SELECT id, numero_contrato, objeto_contrato FROM seguimiento_contrato WHERE estado IN (1,2) ORDER BY numero_contrato";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectLiquidacionesMetrics()
    {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN estado = 'Pendiente' THEN 1 ELSE 0 END) as pendientes,
                SUM(CASE WHEN estado = 'Completada' THEN 1 ELSE 0 END) as completadas,
                SUM(valor_liquidado) as valor_total
                FROM liquidaciones";
        $request = $this->select($sql);
        return $request;
    }
} 