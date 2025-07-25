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
    private $intDependenciaId;
    private $strTipoInforme;
    private $intCantidadInformes;

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
        int $dependencia_id,
        int $plazo,
        string $tipo_plazo,
        string $tipo_informe,
        int $cantidad_informes,
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
        $this->intDependenciaId = $dependencia_id;
        $this->strTipoInforme = $tipo_informe;
        $this->intCantidadInformes = $cantidad_informes;

        $query_insert = "INSERT INTO seguimiento_contrato(numero_contrato, dependencia_id, objeto_contrato, fecha_inicio, fecha_terminacion, fecha_aprobacion_entidad, plazo, tipo_plazo, tipo_informe, cantidad_informes, valor_total_contrato, dia_corte_informe, observaciones_ejecucion, evidenciado_secop, fecha_verificacion, liquidacion, estado) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array(
            $this->strNumeroContrato,
            $this->intDependenciaId,
            $this->strObjetoContrato,
            $this->strFechaInicio,
            $this->strFechaTerminacion,
            $this->strFechaAprobacionEntidad,
            $this->intPlazo,
            $this->strTipoPlazo,
            $this->strTipoInforme,
            $this->intCantidadInformes,
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
        $sql = "SELECT sc.*, d.nombre as dependencia_nombre FROM seguimiento_contrato sc LEFT JOIN tbl_dependencia d ON sc.dependencia_id = d.dependencia_pk WHERE sc.estado != 0";
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
        int $dependencia_id,
        int $plazo,
        string $tipo_plazo,
        string $tipo_informe,
        int $cantidad_informes,
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
        $this->intDependenciaId = $dependencia_id;
        $this->strTipoInforme = $tipo_informe;
        $this->intCantidadInformes = $cantidad_informes;

        $sql = "UPDATE seguimiento_contrato SET numero_contrato=?, dependencia_id=?, objeto_contrato=?, fecha_inicio=?, fecha_terminacion=?, fecha_aprobacion_entidad=?, plazo=?, tipo_plazo=?, tipo_informe=?, cantidad_informes=?, valor_total_contrato=?, dia_corte_informe=?, observaciones_ejecucion=?, evidenciado_secop=?, fecha_verificacion=?, liquidacion=?, estado=? WHERE id = ?";
        $arrData = array(
            $this->strNumeroContrato,
            $this->intDependenciaId,
            $this->strObjetoContrato,
            $this->strFechaInicio,
            $this->strFechaTerminacion,
            $this->strFechaAprobacionEntidad,
            $this->intPlazo,
            $this->strTipoPlazo,
            $this->strTipoInforme,
            $this->intCantidadInformes,
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

    // Guardar adición y actualizar valor del contrato si no supera el 50%
    public function saveAdicionContrato($id_contrato, $valor_adicion, $motivo) {
        // 1. Obtener valor inicial del contrato
        $sqlValor = "SELECT valor_total_contrato FROM seguimiento_contrato WHERE id = ?";
        $valorContrato = $this->select($sqlValor, [$id_contrato]);
        if (!$valorContrato) return ['status'=>false, 'msg'=>'Contrato no encontrado'];
        $valorInicial = floatval($valorContrato['valor_total_contrato']);
        
        // 2. Sumar adiciones existentes
        $sqlSuma = "SELECT COALESCE(SUM(valor_adicion), 0) as suma_adiciones FROM adiciones_contrato WHERE id_contrato = ?";
        $suma = $this->select($sqlSuma, [$id_contrato]);
        $totalAdicionesExistentes = floatval($suma['suma_adiciones']);
        
        // 3. Calcular el límite del 50%
        $limiteMaximo = floatval($valorInicial) * 0.5;
        $nuevoTotalAdiciones = $totalAdicionesExistentes + floatval($valor_adicion);
        
        // 4. Validar que no supere el 50%
        $disponible = $limiteMaximo - $totalAdicionesExistentes;
        if ($nuevoTotalAdiciones > $limiteMaximo) {
            return [
                'status' => false, 
                'msg' => sprintf(
                    'La adición supera el límite del 50%%. Valor máximo disponible: $%s. Valor solicitado: $%s',
                    number_format($disponible, 0, ',', '.'),
                    number_format(floatval($valor_adicion), 0, ',', '.')
                )
            ];
        }
        
        // 5. Insertar adición
        $sqlAdicion = "INSERT INTO adiciones_contrato (id_contrato, valor_adicion, motivo) VALUES (?, ?, ?)";
        $insertResult = $this->insert($sqlAdicion, [$id_contrato, $valor_adicion, $motivo]);
        
        if ($insertResult) {
            $disponibleDespues = $limiteMaximo - $nuevoTotalAdiciones;
            return [
                'status' => true, 
                'msg' => sprintf(
                    'Adición registrada. Total adiciones: $%s / Máximo: $%s. Disponible: $%s',
                    number_format($nuevoTotalAdiciones, 0, ',', '.'),
                    number_format($limiteMaximo, 0, ',', '.'),
                    number_format($disponibleDespues, 0, ',', '.')
                )
            ];
        } else {
            return ['status' => false, 'msg' => 'Error al registrar la adición'];
        }
    }

    // Obtener historial de adiciones de un contrato
    public function getAdicionesContrato($id_contrato) {
        $sql = "SELECT * FROM adiciones_contrato WHERE id_contrato = ? ORDER BY fecha_adicion DESC";
        return $this->select_all($sql, [$id_contrato]);
    }

    // Obtener todas las adiciones (historial general)
    public function getAllAdiciones() {
        $sql = "SELECT a.*, c.numero_contrato, d.nombre as dependencia, c.objeto_contrato FROM adiciones_contrato a INNER JOIN seguimiento_contrato c ON a.id_contrato = c.id LEFT JOIN tbl_dependencia d ON c.dependencia_id = d.dependencia_pk ORDER BY a.fecha_adicion DESC";
        return $this->select_all($sql);
    }

    public function updateEstadoContrato($id, $estado)
    {
        $sql = "UPDATE seguimiento_contrato SET estado = ? WHERE id = ?";
        $arrData = array($estado, $id);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function cantContratos() {
        $sql = "SELECT COUNT(*) as total FROM seguimiento_contrato WHERE estado != 0";
        $request = $this->select($sql);
        return isset($request['total']) ? (int)$request['total'] : 0;
    }
} 