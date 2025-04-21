<?php
class LoginModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserByEmail(string $correo)
    {
        $query = "SELECT * FROM usuarios WHERE correo = ? AND status = 1";
        $data = $this->select($query, [$correo]);
        return $data;
    }
}
?>
