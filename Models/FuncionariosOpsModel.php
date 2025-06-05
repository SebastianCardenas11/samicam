<?php
class FuncionariosOpsModel extends Mysql
{
    private $id;
    private $anio;
    private $nit;
    private $nombre_entidad;
    private $numero_contrato;
    private $fecha_firma_contrato;
    private $numero_proceso;
    private $forma_contratacion;
    private $codigo_banco_proyecto;
    private $linea_estrategia;
    private $fuente_recurso;
    private $objeto;
    private $fecha_inicio;
    private $plazo_contrato;
    private $valor_contrato;
    private $clase_contrato;
    private $nombre_contratista;
    private $identificacion_contratista;
    private $sexo;
    private $direccion_domicilio;
    private $telefono_contacto;
    private $correo_electronico;
    private $edad;
    private $entidad_bancaria;
    private $tipo_cuenta;
    private $numero_cuenta_bancaria;
    private $numero_disp_presupuestal;
    private $fecha_disp_presupuestal;
    private $valor_disp_presupuestal;
    private $numero_registro_presupuestal;
    private $fecha_registro_presupuestal;
    private $valor_registro_presupuestal;
    private $cod_rubro;
    private $rubro;
    private $fuente_financiacion;
    private $asignado_interventor;
    private $unidad_ejecucion;
    private $nombre_interventor;
    private $identificacion_interventor;
    private $tipo_vinculacion_interventor;
    private $fecha_aprobacion_garantia;
    private $anticipo_contrato;
    private $valor_pagado_anticipo;
    private $fecha_pago_anticipo;
    private $numero_adiciones;
    private $valor_total_adiciones;
    private $numero_prorrogas;
    private $tiempo_prorrogas;
    private $numero_suspensiones;
    private $tiempo_suspensiones;
    private $valor_total_pagos;
    private $fecha_terminacion;
    private $fecha_acta_liquidacion;
    private $estado_contrato;
    private $observaciones;
    private $proviene_recurso_reactivacion;
    private $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertFuncionario(
        $anio,
        $nit,
        $nombre_entidad,
        $numero_contrato,
        $fecha_firma_contrato,
        $numero_proceso,
        $forma_contratacion,
        $codigo_banco_proyecto,
        $linea_estrategia,
        $fuente_recurso,
        $objeto,
        $fecha_inicio,
        $plazo_contrato,
        $valor_contrato,
        $clase_contrato,
        $nombre_contratista,
        $identificacion_contratista,
        $sexo,
        $direccion_domicilio,
        $telefono_contacto,
        $correo_electronico,
        $edad,
        $entidad_bancaria,
        $tipo_cuenta,
        $numero_cuenta_bancaria,
        $numero_disp_presupuestal,
        $fecha_disp_presupuestal,
        $valor_disp_presupuestal,
        $numero_registro_presupuestal,
        $fecha_registro_presupuestal,
        $valor_registro_presupuestal,
        $cod_rubro,
        $rubro,
        $fuente_financiacion,
        $asignado_interventor,
        $unidad_ejecucion,
        $nombre_interventor,
        $identificacion_interventor,
        $tipo_vinculacion_interventor,
        $fecha_aprobacion_garantia,
        $anticipo_contrato,
        $valor_pagado_anticipo,
        $fecha_pago_anticipo,
        $numero_adiciones,
        $valor_total_adiciones,
        $numero_prorrogas,
        $tiempo_prorrogas,
        $numero_suspensiones,
        $tiempo_suspensiones,
        $valor_total_pagos,
        $fecha_terminacion,
        $fecha_acta_liquidacion,
        $estado_contrato,
        $observaciones,
        $proviene_recurso_reactivacion
    ) {
        $this->anio = $anio;
        $this->nit = $nit;
        $this->nombre_entidad = $nombre_entidad;
        $this->numero_contrato = $numero_contrato;
        $this->fecha_firma_contrato = $fecha_firma_contrato;
        $this->numero_proceso = $numero_proceso;
        $this->forma_contratacion = $forma_contratacion;
        $this->codigo_banco_proyecto = $codigo_banco_proyecto;
        $this->linea_estrategia = $linea_estrategia;
        $this->fuente_recurso = $fuente_recurso;
        $this->objeto = $objeto;
        $this->fecha_inicio = $fecha_inicio;
        $this->plazo_contrato = $plazo_contrato;
        $this->valor_contrato = $valor_contrato;
        $this->clase_contrato = $clase_contrato;
        $this->nombre_contratista = $nombre_contratista;
        $this->identificacion_contratista = $identificacion_contratista;
        $this->sexo = $sexo;
        $this->direccion_domicilio = $direccion_domicilio;
        $this->telefono_contacto = $telefono_contacto;
        $this->correo_electronico = $correo_electronico;
        $this->edad = $edad;
        $this->entidad_bancaria = $entidad_bancaria;
        $this->tipo_cuenta = $tipo_cuenta;
        $this->numero_cuenta_bancaria = $numero_cuenta_bancaria;
        $this->numero_disp_presupuestal = $numero_disp_presupuestal;
        $this->fecha_disp_presupuestal = $fecha_disp_presupuestal;
        $this->valor_disp_presupuestal = $valor_disp_presupuestal;
        $this->numero_registro_presupuestal = $numero_registro_presupuestal;
        $this->fecha_registro_presupuestal = $fecha_registro_presupuestal;
        $this->valor_registro_presupuestal = $valor_registro_presupuestal;
        $this->cod_rubro = $cod_rubro;
        $this->rubro = $rubro;
        $this->fuente_financiacion = $fuente_financiacion;
        $this->asignado_interventor = $asignado_interventor;
        $this->unidad_ejecucion = $unidad_ejecucion;
        $this->nombre_interventor = $nombre_interventor;
        $this->identificacion_interventor = $identificacion_interventor;
        $this->tipo_vinculacion_interventor = $tipo_vinculacion_interventor;
        $this->fecha_aprobacion_garantia = $fecha_aprobacion_garantia;
        $this->anticipo_contrato = $anticipo_contrato;
        $this->valor_pagado_anticipo = $valor_pagado_anticipo;
        $this->fecha_pago_anticipo = $fecha_pago_anticipo;
        $this->numero_adiciones = $numero_adiciones;
        $this->valor_total_adiciones = $valor_total_adiciones;
        $this->numero_prorrogas = $numero_prorrogas;
        $this->tiempo_prorrogas = $tiempo_prorrogas;
        $this->numero_suspensiones = $numero_suspensiones;
        $this->tiempo_suspensiones = $tiempo_suspensiones;
        $this->valor_total_pagos = $valor_total_pagos;
        $this->fecha_terminacion = $fecha_terminacion;
        $this->fecha_acta_liquidacion = $fecha_acta_liquidacion;
        $this->estado_contrato = $estado_contrato;
        $this->observaciones = $observaciones;
        $this->proviene_recurso_reactivacion = $proviene_recurso_reactivacion;
        $this->status = 1;

        $sql = "INSERT INTO tbl_funcionarios_ops(
            anio, nit, nombre_entidad, numero_contrato, fecha_firma_contrato,
            numero_proceso, forma_contratacion, codigo_banco_proyecto,
            linea_estrategia, fuente_recurso, objeto, fecha_inicio,
            plazo_contrato, valor_contrato, clase_contrato, nombre_contratista,
            identificacion_contratista, sexo, direccion_domicilio,
            telefono_contacto, correo_electronico, edad, entidad_bancaria,
            tipo_cuenta, numero_cuenta_bancaria, numero_disp_presupuestal,
            fecha_disp_presupuestal, valor_disp_presupuestal,
            numero_registro_presupuestal, fecha_registro_presupuestal,
            valor_registro_presupuestal, cod_rubro, rubro, fuente_financiacion,
            asignado_interventor, unidad_ejecucion, nombre_interventor,
            identificacion_interventor, tipo_vinculacion_interventor,
            fecha_aprobacion_garantia, anticipo_contrato, valor_pagado_anticipo,
            fecha_pago_anticipo, numero_adiciones, valor_total_adiciones,
            numero_prorrogas, tiempo_prorrogas, numero_suspensiones,
            tiempo_suspensiones, valor_total_pagos, fecha_terminacion,
            fecha_acta_liquidacion, estado_contrato, observaciones,
            proviene_recurso_reactivacion, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";

        $arrData = array(
            $this->anio, $this->nit, $this->nombre_entidad, $this->numero_contrato,
            $this->fecha_firma_contrato, $this->numero_proceso, $this->forma_contratacion,
            $this->codigo_banco_proyecto, $this->linea_estrategia, $this->fuente_recurso,
            $this->objeto, $this->fecha_inicio, $this->plazo_contrato, $this->valor_contrato,
            $this->clase_contrato, $this->nombre_contratista, $this->identificacion_contratista,
            $this->sexo, $this->direccion_domicilio, $this->telefono_contacto,
            $this->correo_electronico, $this->edad, $this->entidad_bancaria,
            $this->tipo_cuenta, $this->numero_cuenta_bancaria, $this->numero_disp_presupuestal,
            $this->fecha_disp_presupuestal, $this->valor_disp_presupuestal,
            $this->numero_registro_presupuestal, $this->fecha_registro_presupuestal,
            $this->valor_registro_presupuestal, $this->cod_rubro, $this->rubro,
            $this->fuente_financiacion, $this->asignado_interventor, $this->unidad_ejecucion,
            $this->nombre_interventor, $this->identificacion_interventor,
            $this->tipo_vinculacion_interventor, $this->fecha_aprobacion_garantia,
            $this->anticipo_contrato, $this->valor_pagado_anticipo, $this->fecha_pago_anticipo,
            $this->numero_adiciones, $this->valor_total_adiciones, $this->numero_prorrogas,
            $this->tiempo_prorrogas, $this->numero_suspensiones, $this->tiempo_suspensiones,
            $this->valor_total_pagos, $this->fecha_terminacion, $this->fecha_acta_liquidacion,
            $this->estado_contrato, $this->observaciones, $this->proviene_recurso_reactivacion,
            $this->status
        );

        $request_insert = $this->insert($sql, $arrData);
        return $request_insert;
    }

    public function selectFuncionarios()
    {
        $sql = "SELECT * FROM tbl_funcionarios_ops WHERE status = 1";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectFuncionario(int $id)
    {
        $this->id = $id;
        $sql = "SELECT * FROM tbl_funcionarios_ops WHERE id = $this->id AND status = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function updateFuncionario(
        $id,
        $anio,
        $nit,
        $nombre_entidad,
        $numero_contrato,
        $fecha_firma_contrato,
        $numero_proceso,
        $forma_contratacion,
        $codigo_banco_proyecto,
        $linea_estrategia,
        $fuente_recurso,
        $objeto,
        $fecha_inicio,
        $plazo_contrato,
        $valor_contrato,
        $clase_contrato,
        $nombre_contratista,
        $identificacion_contratista,
        $sexo,
        $direccion_domicilio,
        $telefono_contacto,
        $correo_electronico,
        $edad,
        $entidad_bancaria,
        $tipo_cuenta,
        $numero_cuenta_bancaria,
        $numero_disp_presupuestal,
        $fecha_disp_presupuestal,
        $valor_disp_presupuestal,
        $numero_registro_presupuestal,
        $fecha_registro_presupuestal,
        $valor_registro_presupuestal,
        $cod_rubro,
        $rubro,
        $fuente_financiacion,
        $asignado_interventor,
        $unidad_ejecucion,
        $nombre_interventor,
        $identificacion_interventor,
        $tipo_vinculacion_interventor,
        $fecha_aprobacion_garantia,
        $anticipo_contrato,
        $valor_pagado_anticipo,
        $fecha_pago_anticipo,
        $numero_adiciones,
        $valor_total_adiciones,
        $numero_prorrogas,
        $tiempo_prorrogas,
        $numero_suspensiones,
        $tiempo_suspensiones,
        $valor_total_pagos,
        $fecha_terminacion,
        $fecha_acta_liquidacion,
        $estado_contrato,
        $observaciones,
        $proviene_recurso_reactivacion
    ) {
        $this->id = $id;
        $this->anio = $anio;
        $this->nit = $nit;
        $this->nombre_entidad = $nombre_entidad;
        $this->numero_contrato = $numero_contrato;
        $this->fecha_firma_contrato = $fecha_firma_contrato;
        $this->numero_proceso = $numero_proceso;
        $this->forma_contratacion = $forma_contratacion;
        $this->codigo_banco_proyecto = $codigo_banco_proyecto;
        $this->linea_estrategia = $linea_estrategia;
        $this->fuente_recurso = $fuente_recurso;
        $this->objeto = $objeto;
        $this->fecha_inicio = $fecha_inicio;
        $this->plazo_contrato = $plazo_contrato;
        $this->valor_contrato = $valor_contrato;
        $this->clase_contrato = $clase_contrato;
        $this->nombre_contratista = $nombre_contratista;
        $this->identificacion_contratista = $identificacion_contratista;
        $this->sexo = $sexo;
        $this->direccion_domicilio = $direccion_domicilio;
        $this->telefono_contacto = $telefono_contacto;
        $this->correo_electronico = $correo_electronico;
        $this->edad = $edad;
        $this->entidad_bancaria = $entidad_bancaria;
        $this->tipo_cuenta = $tipo_cuenta;
        $this->numero_cuenta_bancaria = $numero_cuenta_bancaria;
        $this->numero_disp_presupuestal = $numero_disp_presupuestal;
        $this->fecha_disp_presupuestal = $fecha_disp_presupuestal;
        $this->valor_disp_presupuestal = $valor_disp_presupuestal;
        $this->numero_registro_presupuestal = $numero_registro_presupuestal;
        $this->fecha_registro_presupuestal = $fecha_registro_presupuestal;
        $this->valor_registro_presupuestal = $valor_registro_presupuestal;
        $this->cod_rubro = $cod_rubro;
        $this->rubro = $rubro;
        $this->fuente_financiacion = $fuente_financiacion;
        $this->asignado_interventor = $asignado_interventor;
        $this->unidad_ejecucion = $unidad_ejecucion;
        $this->nombre_interventor = $nombre_interventor;
        $this->identificacion_interventor = $identificacion_interventor;
        $this->tipo_vinculacion_interventor = $tipo_vinculacion_interventor;
        $this->fecha_aprobacion_garantia = $fecha_aprobacion_garantia;
        $this->anticipo_contrato = $anticipo_contrato;
        $this->valor_pagado_anticipo = $valor_pagado_anticipo;
        $this->fecha_pago_anticipo = $fecha_pago_anticipo;
        $this->numero_adiciones = $numero_adiciones;
        $this->valor_total_adiciones = $valor_total_adiciones;
        $this->numero_prorrogas = $numero_prorrogas;
        $this->tiempo_prorrogas = $tiempo_prorrogas;
        $this->numero_suspensiones = $numero_suspensiones;
        $this->tiempo_suspensiones = $tiempo_suspensiones;
        $this->valor_total_pagos = $valor_total_pagos;
        $this->fecha_terminacion = $fecha_terminacion;
        $this->fecha_acta_liquidacion = $fecha_acta_liquidacion;
        $this->estado_contrato = $estado_contrato;
        $this->observaciones = $observaciones;
        $this->proviene_recurso_reactivacion = $proviene_recurso_reactivacion;

        $sql = "UPDATE tbl_funcionarios_ops SET 
            anio = ?, nit = ?, nombre_entidad = ?, numero_contrato = ?,
            fecha_firma_contrato = ?, numero_proceso = ?, forma_contratacion = ?,
            codigo_banco_proyecto = ?, linea_estrategia = ?, fuente_recurso = ?,
            objeto = ?, fecha_inicio = ?, plazo_contrato = ?, valor_contrato = ?,
            clase_contrato = ?, nombre_contratista = ?, identificacion_contratista = ?,
            sexo = ?, direccion_domicilio = ?, telefono_contacto = ?,
            correo_electronico = ?, edad = ?, entidad_bancaria = ?,
            tipo_cuenta = ?, numero_cuenta_bancaria = ?, numero_disp_presupuestal = ?,
            fecha_disp_presupuestal = ?, valor_disp_presupuestal = ?,
            numero_registro_presupuestal = ?, fecha_registro_presupuestal = ?,
            valor_registro_presupuestal = ?, cod_rubro = ?, rubro = ?,
            fuente_financiacion = ?, asignado_interventor = ?, unidad_ejecucion = ?,
            nombre_interventor = ?, identificacion_interventor = ?,
            tipo_vinculacion_interventor = ?, fecha_aprobacion_garantia = ?,
            anticipo_contrato = ?, valor_pagado_anticipo = ?, fecha_pago_anticipo = ?,
            numero_adiciones = ?, valor_total_adiciones = ?, numero_prorrogas = ?,
            tiempo_prorrogas = ?, numero_suspensiones = ?, tiempo_suspensiones = ?,
            valor_total_pagos = ?, fecha_terminacion = ?, fecha_acta_liquidacion = ?,
            estado_contrato = ?, observaciones = ?, proviene_recurso_reactivacion = ?
            WHERE id = $this->id";

        $arrData = array(
            $this->anio, $this->nit, $this->nombre_entidad, $this->numero_contrato,
            $this->fecha_firma_contrato, $this->numero_proceso, $this->forma_contratacion,
            $this->codigo_banco_proyecto, $this->linea_estrategia, $this->fuente_recurso,
            $this->objeto, $this->fecha_inicio, $this->plazo_contrato, $this->valor_contrato,
            $this->clase_contrato, $this->nombre_contratista, $this->identificacion_contratista,
            $this->sexo, $this->direccion_domicilio, $this->telefono_contacto,
            $this->correo_electronico, $this->edad, $this->entidad_bancaria,
            $this->tipo_cuenta, $this->numero_cuenta_bancaria, $this->numero_disp_presupuestal,
            $this->fecha_disp_presupuestal, $this->valor_disp_presupuestal,
            $this->numero_registro_presupuestal, $this->fecha_registro_presupuestal,
            $this->valor_registro_presupuestal, $this->cod_rubro, $this->rubro,
            $this->fuente_financiacion, $this->asignado_interventor, $this->unidad_ejecucion,
            $this->nombre_interventor, $this->identificacion_interventor,
            $this->tipo_vinculacion_interventor, $this->fecha_aprobacion_garantia,
            $this->anticipo_contrato, $this->valor_pagado_anticipo, $this->fecha_pago_anticipo,
            $this->numero_adiciones, $this->valor_total_adiciones, $this->numero_prorrogas,
            $this->tiempo_prorrogas, $this->numero_suspensiones, $this->tiempo_suspensiones,
            $this->valor_total_pagos, $this->fecha_terminacion, $this->fecha_acta_liquidacion,
            $this->estado_contrato, $this->observaciones, $this->proviene_recurso_reactivacion
        );

        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteFuncionario(int $id)
    {
        $this->id = $id;
        $sql = "UPDATE tbl_funcionarios_ops SET status = 0 WHERE id = {$this->id}";
        $request = $this->update($sql, []);
        return $request;
    }

    public function selectDependencias(){
        $sql = "SELECT dependencia_pk, nombre FROM tbl_dependencia";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCargos() {
        $sql = "SELECT idecargos, nombre, nivel, salario FROM tbl_cargos WHERE estatus = 1";
        $request = $this->select_all($sql);
        return $request;
    }
   public function selectContratoOps() {
    $sql = "SELECT id_contrato, tipo_cont FROM tbl_contrato WHERE tipo_cont IN ('Ops', 'Otros')";
    $request = $this->select_all($sql);
    return $request;
}

}