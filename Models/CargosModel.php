<?php
class CargosModel extends Mysql
{
    private $intIdeCargos;
    private $strNombresCargos;
    private $intNivel;
    private $intSalario;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertCargos(
        string $nombre,
        string $nivel,
        string $salario,
     
    ) {
        $this->strNombresCargos = $nombre;
        $this->intNivel = $nivel;
        $this->intSalario = $salario;
       
        $return = 0;
        $sql = "SELECT * FROM tbl_cargos WHERE
				nombre = '{$this->strNombresCargos}'";
        $request = $this->select_all($sql);

        if (empty($request)) {

            // $rs = 1;
            $query_insert = "INSERT INTO tbl_cargos(nombre,nivel,salario)
            VALUES(?,?,?)";

            $arrData = array(
                $this->strNombresCargos,
                $this->intNivel,
                $this->intSalario
            );

            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // // LISTADO DE LA TABLA
    // public function selectCargos()
    // {
    //     $whereAdmin = "";
    //     if($_SESSION['idUser'] != 1 ){
    //         $whereAdmin = " and u.ideusuario != 1 ";
    //     }
    //     $sql = "SELECT u.ideusuario,u.correo,u.nombres,u.rolid,u.status,r.idrol,r.nombrerol 
    //             FROM tbl_usuarios u 
    //             INNER JOIN rol r
    //             ON u.rolid = r.idrol 
    //             WHERE u.status != 0 ".$whereAdmin;
    //             $request = $this->select_all($sql);
    //             return $request;
    //             // -- ON u.rolid = r.idrol ".$whereAdmin
    // }

    // public function selectCargos(int $ideusuario){
    //     $this->intIdeUsuario = $ideusuario;
    //     $sql = "SELECT u.ideusuario,u.correo,u.nombres,u.rolid,u.status,r.idrol,r.nombrerol
    //             FROM tbl_usuarios u
    //             INNER JOIN rol r
    //             ON u.rolid = r.idrol
    //             WHERE u.ideusuario = $this->intIdeUsuario ";
    //     $request = $tbhis->select($sql);
    //     return $request;
    // }

    // //ACTUALIZAR USUARIO
    // public function updateUsuario(
    //     int $ideusuario,
    //     string $correo,
    //     string $nombres,
    //     string $rol,
    //     string $status
    // ) {

    //     $this->intIdeUsuario = $ideusuario;
    //     $this->strCorreoUsuario = $correo;
    //     $this->strNombresUsuario = $nombres;
    //     $this->strRolUsuario = $rol;
    //     $this->strStatus = $status;

    //     $sql = "SELECT * FROM tbl_usuarios WHERE (correo = '{$this->strCorreoUsuario}' AND ideusuario != $this->intIdeUsuario)";
    //     $request = $this->select_all($sql);

    //     if (empty($request)) {
    //         // TODO PENDIENTE LA VALIDACIÓN SI EL CODIGO ES IGUAL QUE EL CODIGO DE OTRO USUARIO
    //         if ($this->strCorreoUsuario != "" ) {

    //             $sql = "UPDATE tbl_usuarios SET correo=?, nombres=?, rolid=?, status=?
	// 					WHERE ideusuario = $this->intIdeUsuario ";

    //             $arrData = array(
    //                 $this->strCorreoUsuario,
    //                 $this->strNombresUsuario,
    //                 $this->strRolUsuario,
    //                 $this->strStatus
    //             );
    //         } 
    //         $request = $this->update($sql, $arrData);
    //     } else {
    //         $request = "exist";
    //     }
    //     return $request;
    // }

    // public function deleteUsuario(int $intIdeUsuario)
    // {
    //     $this->intIdeUsuario = $intIdeUsuario;
    //     $sql = "UPDATE tbl_usuarios SET status = ? WHERE ideusuario = $this->intIdeUsuario ";
    //     $arrData = array(0);
    //     $request = $this->update($sql, $arrData);
    //     return $request;
    // }

}