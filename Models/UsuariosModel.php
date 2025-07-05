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

    // NUEVO MÉTODO: Obtener usuarios con todos sus roles
    public function selectUsuariosConRoles()
    {
        $whereAdmin = "";
        if($_SESSION['idUser'] != 1 ){
            $whereAdmin = " and u.ideusuario != 1 ";
        }
        
        $sql = "SELECT 
                    u.ideusuario,
                    u.correo,
                    u.nombres,
                    u.rolid as rol_principal,
                    r_principal.nombrerol,
                    u.status,
                    GROUP_CONCAT(r.nombrerol SEPARATOR ', ') as roles_asignados,
                    COUNT(ur.id_rol) as total_roles
                FROM tbl_usuarios u 
                INNER JOIN rol r_principal ON u.rolid = r_principal.idrol
                LEFT JOIN tbl_usuarios_roles ur ON u.ideusuario = ur.id_usuario
                LEFT JOIN rol r ON ur.id_rol = r.idrol
                WHERE u.status != 0 ".$whereAdmin."
                GROUP BY u.ideusuario, u.correo, u.nombres, u.rolid, r_principal.nombrerol, u.status
                ORDER BY u.nombres";
        
        $request = $this->select_all($sql);
        return $request;
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

    // NUEVO MÉTODO: Obtener usuario con todos sus roles
    public function selectUsuarioConRoles(int $ideusuario){
        $this->intIdeUsuario = $ideusuario;
        
        // Obtener datos básicos del usuario con el nombre del rol principal
        $sql = "SELECT u.ideusuario,u.correo,u.nombres,u.rolid,u.status,u.password,r.nombrerol
                FROM tbl_usuarios u
                INNER JOIN rol r ON u.rolid = r.idrol
                WHERE u.ideusuario = $this->intIdeUsuario ";
        $usuario = $this->select($sql);
        
        if($usuario) {
            // Obtener todos los roles asignados
            $sql_roles = "SELECT ur.id_rol, r.nombrerol, r.descripcion
                         FROM tbl_usuarios_roles ur
                         INNER JOIN rol r ON ur.id_rol = r.idrol
                         WHERE ur.id_usuario = $this->intIdeUsuario
                         ORDER BY r.nombrerol";
            $roles = $this->select_all($sql_roles);
            
            $usuario['roles'] = $roles;
            $usuario['roles_ids'] = array_column($roles, 'id_rol');
        }
        
        return $usuario;
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

    // NUEVO MÉTODO: Actualizar usuario con múltiples roles
    public function updateUsuarioConRoles(
        int $ideusuario,
        string $correo,
        string $nombres,
        string $rol_principal,
        string $status,
        array $roles_adicionales = []
    ) {
        $this->intIdeUsuario = $ideusuario;
        $this->strCorreoUsuario = $correo;
        $this->strNombresUsuario = $nombres;
        $this->strRolUsuario = $rol_principal;
        $this->strStatusUsuario = $status;

        $sql = "SELECT * FROM tbl_usuarios WHERE (correo = '{$this->strCorreoUsuario}' AND ideusuario != $this->intIdeUsuario)";
        $request = $this->select_all($sql);

        if (empty($request)) {
            // Actualizar datos básicos del usuario
            $sql = "UPDATE tbl_usuarios SET correo=?, nombres=?, rolid=?, status=?
                    WHERE ideusuario = $this->intIdeUsuario ";

            $arrData = array(
                $this->strCorreoUsuario,
                $this->strNombresUsuario,
                $this->strRolUsuario,
                $this->strStatusUsuario
            );
            
            $request = $this->update($sql, $arrData);
            
            if($request) {
                // Actualizar roles adicionales
                $this->updateRolesUsuario($ideusuario, $roles_adicionales);
            }
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

    // =====================================================
    // NUEVOS MÉTODOS PARA MANEJAR MÚLTIPLES ROLES
    // =====================================================

    // Obtener todos los roles de un usuario
    public function getRolesUsuario(int $ideusuario)
    {
        $sql = "SELECT ur.id_rol, r.nombrerol, r.descripcion
                FROM tbl_usuarios_roles ur
                INNER JOIN rol r ON ur.id_rol = r.idrol
                WHERE ur.id_usuario = $ideusuario
                ORDER BY r.nombrerol";
        return $this->select_all($sql);
    }

    // Asignar roles a un usuario
    public function asignarRolesUsuario(int $ideusuario, array $roles)
    {
        // Primero eliminar roles existentes
        $this->eliminarRolesUsuario($ideusuario);
        
        // Luego insertar los nuevos roles
        foreach($roles as $rol) {
            $sql = "INSERT INTO tbl_usuarios_roles (id_usuario, id_rol) VALUES (?, ?)";
            $this->insert($sql, array($ideusuario, $rol));
        }
        
        return true;
    }

    // Actualizar roles de un usuario
    public function updateRolesUsuario(int $ideusuario, array $roles)
    {
        // Eliminar roles existentes
        $this->eliminarRolesUsuario($ideusuario);
        
        // Insertar nuevos roles
        if(!empty($roles)) {
            foreach($roles as $rol) {
                $sql = "INSERT INTO tbl_usuarios_roles (id_usuario, id_rol) VALUES (?, ?)";
                $this->insert($sql, array($ideusuario, $rol));
            }
        }
        
        return true;
    }

    // Eliminar todos los roles de un usuario
    public function eliminarRolesUsuario(int $ideusuario)
    {
        $sql = "DELETE FROM tbl_usuarios_roles WHERE id_usuario = ?";
        return $this->delete($sql, array($ideusuario));
    }

    // Verificar si un usuario tiene un rol específico
    public function usuarioTieneRol(int $ideusuario, int $idrol)
    {
        $sql = "SELECT COUNT(*) as total FROM tbl_usuarios_roles 
                WHERE id_usuario = ? AND id_rol = ?";
        $result = $this->select($sql, array($ideusuario, $idrol));
        return $result['total'] > 0;
    }

    // Obtener todos los permisos de un usuario (combinando todos sus roles)
    public function getPermisosUsuario(int $ideusuario)
    {
        $sql = "SELECT DISTINCT p.moduloid, p.r, p.w, p.u, p.d
                FROM permisos p
                INNER JOIN tbl_usuarios_roles ur ON p.rolid = ur.id_rol
                WHERE ur.id_usuario = ?";
        
        $permisos = $this->select_all($sql, array($ideusuario));
        
        // Combinar permisos de múltiples roles
        $permisos_combinados = array();
        foreach($permisos as $permiso) {
            $modulo = $permiso['moduloid'];
            if(!isset($permisos_combinados[$modulo])) {
                $permisos_combinados[$modulo] = array(
                    'r' => 0, 'w' => 0, 'u' => 0, 'd' => 0
                );
            }
            
            // Si cualquier rol tiene el permiso, el usuario lo tiene
            $permisos_combinados[$modulo]['r'] = max($permisos_combinados[$modulo]['r'], $permiso['r']);
            $permisos_combinados[$modulo]['w'] = max($permisos_combinados[$modulo]['w'], $permiso['w']);
            $permisos_combinados[$modulo]['u'] = max($permisos_combinados[$modulo]['u'], $permiso['u']);
            $permisos_combinados[$modulo]['d'] = max($permisos_combinados[$modulo]['d'], $permiso['d']);
        }
        
        return $permisos_combinados;
    }

}