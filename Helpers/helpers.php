<?php

// Retorna la url del proyecto
function base_url()
{
    return BASE_URL;
}

// Retorna la url de Assets
function media()
{
    return BASE_URL . "/Assets";
}

function headerAdmin($data = "")
{
    $view_header = "Views/Template/header_admin.php";
    require_once($view_header);
}

function footerAdmin($data = "")
{
    $view_footer = "Views/Template/footer_admin.php";
    require_once($view_footer);
}

// Muestra información formateada
function dep($data)
{
    $format = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

function getModal(string $nameModal, $data)
{
    $view_modal = "Views/Template/Modals/{$nameModal}.php";
    require_once $view_modal;
}

// Envio de correos
function sendEmail($data, $template)
{
    $asunto = $data['asunto'];
    $emailDestino = $data['email'];
    $empresa = NOMBRE_REMITENTE;
    $remitente = EMAIL_REMITENTE;
    //ENVIO DE CORREO
    $de = "MIME-Version: 1.0\r\n";
    $de .= "Content-type: text/html; charset=UTF-8\r\n";
    $de .= "From: {$empresa} <{$remitente}>\r\n";
    ob_start();
    require_once("Views/Template/Email/" . $template . ".php");
    $mensaje = ob_get_clean();
    $send = mail($emailDestino, $asunto, $mensaje, $de);
    return $send;
}

function getPermisos(int $idmodulo)
{
    require_once("Models/PermisosModel.php");
    require_once("Models/UsuariosModel.php");
    $objPermisos = new PermisosModel();
    $objUsuarios = new UsuariosModel();
    
    if (!empty($_SESSION['userData'])) {
        $ideusuario = $_SESSION['userData']['ideusuario'];
        $idrol = $_SESSION['userData']['idrol'];
        
        // Obtener TODOS los permisos del usuario (rol principal + roles adicionales)
        $permisosCombinados = array();
        
        // 1. Obtener permisos del rol principal
        $arrPermisos = $objPermisos->permisosModulo($idrol);
        if (count($arrPermisos) > 0) {
            foreach ($arrPermisos as $moduloId => $permiso) {
                $permisosCombinados[$moduloId] = $permiso;
            }
        }
        
        // 2. Obtener y combinar permisos de roles adicionales
        $permisosAdicionales = $objUsuarios->getPermisosUsuario($ideusuario);
        if (count($permisosAdicionales) > 0) {
            foreach ($permisosAdicionales as $moduloId => $permiso) {
                if (!isset($permisosCombinados[$moduloId])) {
                    $permisosCombinados[$moduloId] = array(
                        'rolid' => $idrol,
                        'moduloid' => $moduloId,
                        'modulo' => 'Módulo ' . $moduloId,
                        'r' => $permiso['r'],
                        'w' => $permiso['w'],
                        'u' => $permiso['u'],
                        'd' => $permiso['d']
                    );
                } else {
                    // Combinar permisos (usar el máximo)
                    $permisosCombinados[$moduloId]['r'] = max($permisosCombinados[$moduloId]['r'], $permiso['r']);
                    $permisosCombinados[$moduloId]['w'] = max($permisosCombinados[$moduloId]['w'], $permiso['w']);
                    $permisosCombinados[$moduloId]['u'] = max($permisosCombinados[$moduloId]['u'], $permiso['u']);
                    $permisosCombinados[$moduloId]['d'] = max($permisosCombinados[$moduloId]['d'], $permiso['d']);
                }
            }
        }
        
        // 3. Obtener permisos específicos del módulo solicitado
        $permisosMod = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
        if (isset($permisosCombinados[$idmodulo])) {
            $permisosMod = $permisosCombinados[$idmodulo];
        }
        
        $_SESSION['permisos'] = $permisosCombinados;
        $_SESSION['permisosMod'] = $permisosMod;
    }
}

function sessionUser(int $idpersona)
{
    require_once("Models/LoginModel.php");
    $objLogin = new LoginModel();
    $request = $objLogin->sessionLogin($idpersona);
    return $request;
}

function uploadImage(array $data, string $name)
{
    $url_temp = $data['tmp_name'];
    $destino = 'Assets/images/uploads/' . $name;
    $move = move_uploaded_file($url_temp, $destino);
    return $move;
}

function deleteFile(string $name)
{
    unlink('Assets/images/uploads/' . $name);
}

//Elimina exceso de espacios entre palabras
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); //Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \\ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}

function clear_cadena(string $cadena)
{
    //Reemplazamos la A y a
    $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena
    );

    //Reemplazamos la I y i
    $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena
    );

    //Reemplazamos la O y o
    $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena
    );

    //Reemplazamos la U y u
    $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena
    );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç', ',', '.', ';', ':'),
        array('N', 'n', 'C', 'c', '', '', '', ''),
        $cadena
    );
    return $cadena;
}

//Genera una contraseña de 10 caracteres
function passGenerator($length = 10)
{
    $pass = "";
    $longitudPass = $length;
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena = strlen($cadena);

    for ($i = 1; $i <= $longitudPass; $i++) {
        $pos = rand(0, $longitudCadena - 1);
        $pass .= substr($cadena, $pos, 1);
    }
    return $pass;
}

//Genera un token
function token()
{
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    return $token;
}

//Formato para valores monetarios
function formatMoney($cantidad)
{
    $cantidad = number_format($cantidad, 2, SPD, SPM);
    return $cantidad;
}

function getFile(string $url, $data)
{
    ob_start();
    require_once("Views/{$url}.php");
    $file = ob_get_clean();
    return $file;
}

function getPermisosModulo(int $idmodulo)
{
    // Usar la función getPermisos actualizada que maneja múltiples roles
    getPermisos($idmodulo);
}

function isVisible($idmodulo)
{
    // Since 'v' column doesn't exist, we'll assume all modules are visible
    return true;
}