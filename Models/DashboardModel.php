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
    public function cantProgramas()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_programas WHERE status != 0 ";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }
    public function cantFichas()
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_fichas WHERE status != 0 ";
        $request = $this->select($sql);
        $total = $request['total'];
        return $total;
    }

    public function getHorasPorMesModel() {
        $sql = "SELECT tf.ideficha,tf.numeroficha,tdtc.avancehorascompetencia,tdtc.fichaide
        FROM tbl_fichas tf
        INNER JOIN tbl_detalle_temp_competencias tdtc
        ON tdtc.fichaide = tf.ideficha
        WHERE tdtc.status != 0 ";
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

}