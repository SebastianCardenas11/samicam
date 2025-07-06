<?php
class DashboardModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cantUsuarios()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_usuarios WHERE status != 0 AND rolid !=0";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }

    public function cantFuncionariosOps()
    {
        $sql = "SELECT COUNT(*) as total 
        FROM tbl_funcionarios_ops f 
        WHERE f.estado_contrato != 'Terminado'";

        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }

    public function cantFuncionariosPlanta()
    {
        $sql = "SELECT COUNT(*) as total 
        FROM tbl_funcionarios_planta f 
        INNER JOIN tbl_contrato c ON f.contrato_fk = c.id_contrato 
        WHERE f.status != 0";

        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }

    public function cantProgramas()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_programas WHERE status != 0";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }

    public function cantFichas()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_fichas WHERE status != 0";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }

    public function getEstadisticasGenerales()
    {
        $estadisticas = [
            'funcionariosTotal' => $this->cantFuncionariosOps() + $this->cantFuncionariosPlanta(),
            'vacacionesActivas' => $this->cantVacacionesActivas(),
            'cargosTotal' => $this->cantCargos()
        ];
        return $estadisticas;
    }

    public function cantVacacionesActivas()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_vacaciones WHERE estado = 'Aprobado'";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }

    public function cantCargos()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_cargos WHERE estatus = 1";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }

    public function getHorasPorMesModel() {
        $sql = "SELECT tf.ideficha,tf.numeroficha,tdtc.avancehorascompetencia,tdtc.fichaide
        FROM tbl_fichas tf
        INNER JOIN tbl_detalle_temp_competencias tdtc
        ON tdtc.fichaide = tf.ideficha
        WHERE tdtc.status != 0";
        $request = $this->select_all($sql); 
        return $request;
    }

    public function getHorasPorInstructorModel() {
        $sql = "SELECT tu.ideusuario,tu.nombres,SUM(cantidadhorasasignadas) AS instructor,tdc.usuarioide
        FROM tbl_usuarios tu
        INNER JOIN tbl_detalle_competencias tdc
        ON tdc.usuarioide = tu.ideusuario
        WHERE tdc.status != 0 AND tu.rolid=3";
        $request = $this->select_all($sql); 
        return $request;
    }

    public function getUsuariosPorRolModel() {
        $sql = "SELECT r.nombrerol, COUNT(u.ideusuario) as cantidad 
               FROM tbl_usuarios u 
               INNER JOIN tbl_roles r ON u.rolid = r.idrol 
               WHERE u.status != 0 
               GROUP BY r.nombrerol";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getFuncionariosPorCargoModel() {
        $sql = "SELECT 
                    COALESCE(c.nombre, 'Sin Cargo') as nombre_cargo, 
                    COUNT(*) as cantidad 
                FROM (
                    SELECT cargo_fk FROM tbl_funcionarios_planta WHERE status != 0
                    UNION ALL
                    SELECT NULL as cargo_fk FROM tbl_funcionarios_ops WHERE estado_contrato != 'Terminado'
                ) as funcionarios
                LEFT JOIN tbl_cargos c ON funcionarios.cargo_fk = c.idecargos
                GROUP BY c.nombre
                ORDER BY cantidad DESC";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function getFuncionariosPorTipoContratoModel() {
        $sql = "SELECT ct.tipo_cont as tipo_contrato, COUNT(f.idefuncionario) as cantidad 
               FROM tbl_funcionarios_planta f 
               INNER JOIN tbl_contrato ct ON f.contrato_fk = ct.id_contrato 
               WHERE f.status != 0 
               GROUP BY ct.tipo_cont";
        $request = $this->select_all($sql);
        return $request;
    }

    public function getPracticantesPorMesModel() {
        $sql = "SELECT MONTH(fecha_ingreso) as mes, COUNT(*) as cantidad
                FROM tbl_practicantes
                WHERE YEAR(fecha_ingreso) = YEAR(CURDATE())
                GROUP BY mes";
        return $this->select_all($sql);
    }

    public function getFuncionariosPorMesModel() {
        $sql = "SELECT MONTH(fecha_ingreso) as mes, COUNT(*) as cantidad
                FROM (
                    SELECT fecha_ingreso FROM tbl_funcionarios_planta WHERE status != 0
                    UNION ALL
                    SELECT fecha_inicio as fecha_ingreso FROM tbl_funcionarios_ops WHERE estado_contrato != 'Terminado'
                ) as funcionarios
                WHERE YEAR(fecha_ingreso) = YEAR(CURDATE())
                GROUP BY mes";
        return $this->select_all($sql);
    }

    public function getEstadisticasViaticos($year = null) {
        if ($year === null) {
            $year = date('Y');
        }
        // Obtener presupuesto
        require_once("Models/FuncionariosViaticosModel.php");
        $viaticosModel = new FuncionariosViaticosModel();
        $presupuesto = $viaticosModel->getPresupuestoInfo($year);
        $capitalTotal = isset($presupuesto['capital_total']) ? floatval($presupuesto['capital_total']) : 0;
        $capitalDisponible = isset($presupuesto['capital_disponible']) ? floatval($presupuesto['capital_disponible']) : 0;
        $capitalGastado = $capitalTotal - $capitalDisponible;
        $porcentajeGastado = $capitalTotal > 0 ? round(($capitalGastado / $capitalTotal) * 100, 2) : 0;
        if ($porcentajeGastado < 0) $porcentajeGastado = 0;
        if ($porcentajeGastado > 100) $porcentajeGastado = 100;
        $porcentajeDisponible = 100 - $porcentajeGastado;
        if ($porcentajeDisponible < 0) $porcentajeDisponible = 0;
        if ($porcentajeDisponible > 100) $porcentajeDisponible = 100;
        return [
            'capital_total' => $capitalTotal,
            'capital_disponible' => $capitalDisponible,
            'capital_gastado' => $capitalGastado,
            'porcentaje_gastado' => $porcentajeGastado,
            'porcentaje_disponible' => $porcentajeDisponible
        ];
    }

    public function cantPracticantes() {
        require_once("Models/PracticantesModel.php");
        $practicantesModel = new PracticantesModel();
        return $practicantesModel->cantPracticantes();
    }

    public function cantContratos() {
        require_once("Models/SeguimientoContratoModel.php");
        $contratoModel = new SeguimientoContratoModel();
        return $contratoModel->cantContratos();
    }

    public function getUltimosPermisosModel() {
        // Consulta que obtiene los nombres reales de los funcionarios
        $sql = "SELECT 
                    p.motivo, 
                    p.fecha_permiso, 
                    p.estado,
                    CASE 
                        WHEN p.tipo_funcionario = 'planta' THEN 
                            COALESCE((SELECT nombre_completo FROM tbl_funcionarios_planta WHERE idefuncionario = p.id_funcionario LIMIT 1), 'Funcionario no encontrado')
                        WHEN p.tipo_funcionario = 'ops' THEN 
                            COALESCE((SELECT nombre_contratista FROM tbl_funcionarios_ops WHERE id = p.id_funcionario LIMIT 1), 'Funcionario no encontrado')
                        ELSE 'Tipo no especificado'
                    END as funcionario_cargo
                FROM tbl_permisos p
                WHERE p.estado IN ('Aprobado', 'Pendiente', 'Rechazado')
                ORDER BY p.fecha_permiso DESC 
                LIMIT 5";
        
        $result = $this->select_all($sql);
        
        // Debug: imprimir la consulta y resultados para verificar
        error_log("SQL Query: " . $sql);
        error_log("Resultados: " . print_r($result, true));
        
        return $result;
    }
    
    private function diagnosticarPermisos() {
        $diagnostico = [];
        
        // Verificar permisos totales
        $sql_total = "SELECT COUNT(*) as total FROM tbl_permisos";
        $total = $this->select($sql_total);
        $diagnostico['total_permisos'] = $total['total'] ?? 0;
        
        // Verificar permisos por tipo
        $sql_tipos = "SELECT tipo_funcionario, COUNT(*) as cantidad FROM tbl_permisos GROUP BY tipo_funcionario";
        $tipos = $this->select_all($sql_tipos);
        $diagnostico['por_tipo'] = $tipos;
        
        // Verificar permisos por estado
        $sql_estados = "SELECT estado, COUNT(*) as cantidad FROM tbl_permisos GROUP BY estado";
        $estados = $this->select_all($sql_estados);
        $diagnostico['por_estado'] = $estados;
        
        // Verificar algunos permisos de ejemplo
        $sql_ejemplo = "SELECT id, motivo, fecha_permiso, estado, tipo_funcionario, id_funcionario FROM tbl_permisos LIMIT 5";
        $ejemplos = $this->select_all($sql_ejemplo);
        $diagnostico['ejemplos'] = $ejemplos;
        
        return $diagnostico;
    }
}