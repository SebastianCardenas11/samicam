<?php

class Permisos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPermisosRol(int $idrol)
    {
        $rolid = intval($idrol);
        if ($rolid > 0) {
            // No permitir modificar permisos del superadministrador (ID 1)
            if ($rolid == 1) {
                $arrResponse = array('status' => false, 'msg' => 'No se pueden modificar los permisos del Superadministrador.');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }
            
            $arrModulos = $this->model->selectModulos();
            $arrPermisosRol = $this->model->selectPermisosRol($rolid);
            $arrRol = $this->model->getRol($rolid);
            $arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0, 'v' => 0);
            $arrPermisoRol = array('idrol' => $rolid, 'rol' => $arrRol['nombrerol']);

            // Crear array asociativo de permisos por módulo ID
            $permisosIndexados = array();
            foreach ($arrPermisosRol as $permiso) {
                $permisosIndexados[$permiso['moduloid']] = $permiso;
            }
            
            // Asignar permisos a cada módulo
            for ($i = 0; $i < count($arrModulos); $i++) {
                $moduloId = $arrModulos[$i]['idmodulo'];
                if (isset($permisosIndexados[$moduloId])) {
                    $arrModulos[$i]['permisos'] = array(
                        'r' => $permisosIndexados[$moduloId]['r'],
                        'w' => $permisosIndexados[$moduloId]['w'],
                        'u' => $permisosIndexados[$moduloId]['u'],
                        'd' => $permisosIndexados[$moduloId]['d'],
                        'v' => 1
                    );
                } else {
                    $arrModulos[$i]['permisos'] = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0, 'v' => 1);
                }
            }
            $arrPermisoRol['modulos'] = $arrModulos;
            $html = getModal("modalPermisos", $arrPermisoRol);
        }
        die();
    }

    public function setPermisos()
    {
        if ($_POST) {
            $intIdrol = intval($_POST['idrol']);
            
            if ($intIdrol == 1) {
                $arrResponse = array('status' => false, 'msg' => 'No se pueden modificar los permisos del Superadministrador.');
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                die();
            }
            
            $modulos = $_POST['modulos'];

            $this->model->deletePermisos($intIdrol);
            $requestPermiso = 0;
            foreach ($modulos as $modulo) {
                $idModulo = intval($modulo['idmodulo']);
                $r = isset($modulo['r']) ? 1 : 0;
                $w = isset($modulo['w']) ? 1 : 0;
                $u = isset($modulo['u']) ? 1 : 0;
                $d = isset($modulo['d']) ? 1 : 0;
                $v = 1; // Siempre visible
                $requestPermiso = $this->model->insertPermisos($intIdrol, $idModulo, $r, $w, $u, $d, $v);
            }
            if ($requestPermiso > 0) {
                $arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente.');
            } else {
                $arrResponse = array("status" => false, "msg" => 'No es posible asignar los permisos.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}