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
        INNER JOIN tbl_contrato c ON f.contrato_fk = c.id_contrato 
        WHERE f.status != 0";

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
        $sql = "SELECT c.nombre as nombre_cargo, COUNT(f.idefuncionario) as cantidad 
               FROM tbl_funcionarios_planta f 
               INNER JOIN tbl_cargos c ON f.cargo_fk = c.idecargos 
               WHERE f.status != 0 
               GROUP BY c.nombre";
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
}