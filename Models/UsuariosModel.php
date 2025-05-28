<?php
class UsuariosModel extends Mysql
{
    private $intIdeUsuario;
    private $strCorreoUsuario;
    private $strNombresUsuario;
    private $strPassword;
    private $strRolUsuario;
    private $strStatusUsuario;

    public function __construct()
    {
        parent::__construct();
    }

    public function insertUsuario(
        string $correo,
        string $nombres,
        string $password,
        string $rol,
        string $status
    ) {
        $this->strCorreoUsuario = $correo;
        $this->strNombresUsuario = $nombres;
        $this->strPassword = $password;
        $this->strRolUsuario = $rol;
        $this->strStatusUsuario = $status;

        $return = 0;
        $sql = "SELECT * FROM tbl_usuarios WHERE
				correo = '{$this->strCorreoUsuario}'";
        $request = $this->select_all($sql);

        if (empty($request)) {

            // $rs = 1;
            $query_insert = "INSERT INTO tbl_usuarios(correo,nombres,password,rolid,status)
            VALUES(?,?,?,?,?)";

            $arrData = array(
                $this->strCorreoUsuario,
                $this->strNombresUsuario,
                $this->strPassword,
                $this->strRolUsuario,
                $this->strStatusUsuario
            );

            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    // LISTADO DE LA TABLA
    public function selectUsuarios()
    {
        $whereAdmin = "";
        if($_SESSION['idUser'] != 1 ){
            $whereAdmin = " and u.ideusuario != 1 ";
        }
        $sql = "SELECT u.ideusuario,u.correo,u.nombres,u.rolid,u.status,r.idrol,r.nombrerol 
                FROM tbl_usuarios u 
                INNER JOIN rol r
                ON u.rolid = r.idrol 
                WHERE u.status != 0 ".$whereAdmin;
                $request = $this->select_all($sql);
                return $request;
                // -- ON u.rolid = r.idrol ".$whereAdmin
    }

    public function selectUsuario(int $ideusuario){
        $this->intIdeUsuario = $ideusuario;
        $sql = "SELECT u.ideusuario,u.correo,u.nombres,u.rolid,u.status,r.idrol,r.nombrerol,u.password
                FROM tbl_usuarios u
                INNER JOIN rol r
                ON u.rolid = r.idrol
                WHERE u.ideusuario = $this->intIdeUsuario ";
        $request = $this->select($sql);
        return $request;
    }

    //ACTUALIZAR USUARIO
    public function updateUsuario(
        int $ideusuario,
        string $correo,
        string $nombres,
        string $rol,
        string $status
    ) {

        $this->intIdeUsuario = $ideusuario;
        $this->strCorreoUsuario = $correo;
        $this->strNombresUsuario = $nombres;
        $this->strRolUsuario = $rol;
        $this->strStatusUsuario = $status;

        $sql = "SELECT * FROM tbl_usuarios WHERE (correo = '{$this->strCorreoUsuario}' AND ideusuario != $this->intIdeUsuario)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE tbl_usuarios SET correo=?, nombres=?, rolid=?, status=?
                    WHERE ideusuario = $this->intIdeUsuario ";

            $arrData = array(
                $this->strCorreoUsuario,
                $this->strNombresUsuario,
                $this->strRolUsuario,
                $this->strStatusUsuario
            );
            
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    //ACTUALIZAR USUARIO CON CONTRASEÑA
    public function updateUsuarioConPassword(
        int $ideusuario,
        string $correo,
        string $nombres,
        string $password,
        string $rol,
        string $status
    ) {

        $this->intIdeUsuario = $ideusuario;
        $this->strCorreoUsuario = $correo;
        $this->strNombresUsuario = $nombres;
        $this->strPassword = $password;
        $this->strRolUsuario = $rol;
        $this->strStatusUsuario = $status;

        $sql = "SELECT * FROM tbl_usuarios WHERE (correo = '{$this->strCorreoUsuario}' AND ideusuario != $this->intIdeUsuario)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE tbl_usuarios SET correo=?, nombres=?, password=?, rolid=?, status=?
                    WHERE ideusuario = $this->intIdeUsuario ";

            $arrData = array(
                $this->strCorreoUsuario,
                $this->strNombresUsuario,
                $this->strPassword,
                $this->strRolUsuario,
                $this->strStatusUsuario
            );
            
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteUsuario(int $intIdeUsuario)
    {
        $this->intIdeUsuario = $intIdeUsuario;
        $sql = "UPDATE tbl_usuarios SET status = ? WHERE ideusuario = $this->intIdeUsuario ";
        $arrData = array(0);
        $request = $this->update($sql, $arrData);
        return $request;
    }

}