<?php

class LoginModel extends Mysql
{
    private $intIdUsuario;
    private $strCorreo;
    private $strPassword;

    public function __construct()
    {
        parent::__construct();
    }

    public function loginUser(string $correo, string $password)
    {
        $this->strCorreo = $correo;
        $this->strPassword = $password;
        $sql = "SELECT ideusuario,status FROM tbl_usuarios WHERE
					correo = '$this->strCorreo' and
					password = '$this->strPassword' and
					status != 0 ";
        $request = $this->select($sql);
        return $request;
    }

    public function sessionLogin(int $iduser)
    {
        $this->intIdUsuario = $iduser;
        //BUSCAR ROL
        $sql = "SELECT tu.ideusuario,
							tu.correo,
							tu.nombres,
							tu.imgperfil,
							r.idrol,
                            r.nombrerol,
							tu.status
					FROM tbl_usuarios tu
					INNER JOIN rol r
					ON tu.rolid = r.idrol
					WHERE tu.ideusuario = $this->intIdUsuario";
        $request = $this->select($sql);
        $_SESSION['userData'] = $request;
        return $request;
    }


}