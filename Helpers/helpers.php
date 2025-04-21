<?php

use PHPMailer\PHPMailer\Exception; // Importa la excepción de PHPMailer
use PHPMailer\PHPMailer\PHPMailer; // Importa la clase PHPMailer

//Retorna la URL base del proyecto definida en Config/Config.php
function base_url()
{
    return BASE_URL; // Retorna la constante BASE_URL
}

//Retorna la URL base de la carpeta de Assets definida en Config/Config.php
function media()
{
    return BASE_URL . "/Assets"; // Concatena BASE_URL con la ruta a la carpeta Assets
}

//Incluye el archivo de encabezado para la interfaz de administración
function headerAdmin($data = "")
{
    $view_header = "Views/Template/header_admin.php"; // Define la ruta al archivo del encabezado
    require_once $view_header; // Incluye el archivo del encabezado
}

//Incluye el archivo de pie de página para la interfaz de administración
function footerAdmin($data = "")
{
    $view_footer = "Views/Template/footer_admin.php"; // Define la ruta al archivo del pie de página
    require_once $view_footer; // Incluye el archivo del pie de página
}

//Muestra información de una variable de forma formateada para depuración
function dep($data)
{
    $format = print_r('<pre>', true); // Inicia la etiqueta <pre> para formato
    $format .= print_r($data, true); // Imprime la variable dentro de <pre>, el 'true' es para retornar la salida
    $format .= print_r('</pre>', true); // Cierra la etiqueta <pre>
    return $format; // Retorna la cadena formateada
}

//Incluye un archivo de modal específico desde la carpeta Modals
function getModal(string $nameModal, $data)
{
    $view_modal = "Views/Template/Modals/{$nameModal}.php"; // Define la ruta al archivo del modal
    require_once $view_modal; // Incluye el archivo del modal
}

//Obtiene el contenido de un archivo de vista y lo retorna como una cadena
function getFile(string $url, $data)
{
    ob_start(); // Inicia el almacenamiento en búfer de salida
    require_once "Views/{$url}.php"; // Incluye el archivo de la vista
    $file = ob_get_clean(); // Obtiene el contenido del búfer y lo limpia
    return $file; // Retorna el contenido del archivo como una cadena
}

//Obtiene los permisos de un rol para un módulo específico
function getPermisos(int $idmodulo)
{
    require_once "Models/PermisosModel.php"; // Incluye el modelo de permisos
    $objPermisos = new PermisosModel(); // Crea una instancia del modelo de permisos
    if (!empty($_SESSION['userData'])) { // Verifica si la información del usuario en sesión no está vacía
        $idrol = $_SESSION['userData']['idrol']; // Obtiene el ID del rol del usuario desde la sesión
        $arrPermisos = $objPermisos->permisosModulo($idrol); // Obtiene los permisos del rol para todos los módulos
        $permisos = ''; // Inicializa la variable de permisos
        $permisosMod = ''; // Inicializa la variable de permisos del módulo actual
        if (count($arrPermisos) > 0) { // Verifica si se encontraron permisos
            $permisos = $arrPermisos; // Asigna todos los permisos a la variable $permisos
            $permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : ""; // Obtiene los permisos del módulo actual o un valor vacío si no existen
        }
        $_SESSION['permisos'] = $permisos; // Guarda todos los permisos en la sesión
        $_SESSION['permisosMod'] = $permisosMod; // Guarda los permisos del módulo actual en la sesión
    }
}

//Obtiene la información del usuario para la sesión
function sessionUser(int $idpersona)
{
    require_once "Models/LoginModel.php"; // Incluye el modelo de login
    $objLogin = new LoginModel(); // Crea una instancia del modelo de login
    $request = $objLogin->sessionLogin($idpersona); // Llama al método para obtener la información del usuario
    return $request; // Retorna la información del usuario
}

//Sube una imagen al servidor
function uploadImage(array $data, string $name)
{
    $url_temp = $data['tmp_name']; // Obtiene la ruta temporal del archivo subido
    $destino = 'Assets/images/uploads/perfiles/' . $name; // Define la ruta de destino para la imagen
    $move = move_uploaded_file($url_temp, $destino); // Mueve el archivo subido a la ubicación de destino
    return $move; // Retorna true si la carga fue exitosa, false en caso contrario
}

//Elimina un archivo del servidor
function deleteFile(string $name)
{
    unlink('Assets/images/uploads/perfiles/' . $name); // Intenta eliminar el archivo en la ruta especificada
}

//Elimina exceso de espacios entre palabras y previene inyecciones básicas
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena); // Reemplaza múltiples espacios por uno y elimina espacios al inicio/final
    $string = trim($string); // Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string); // Elimina la etiqueta <script> (ignorando mayúsculas/minúsculas)
    $string = str_ireplace("</script>", "", $string); // Elimina la etiqueta </script> (ignorando mayúsculas/minúsculas)
    $string = str_ireplace("<script src>", "", $string); // Elimina la parte de la etiqueta <script src>
    $string = str_ireplace("<script type=>", "", $string); // Elimina la parte de la etiqueta <script type=>
    $string = str_ireplace("SELECT * FROM", "", $string); // Elimina la instrucción SELECT * FROM (ignorando mayúsculas/minúsculas)
    $string = str_ireplace("DELETE FROM", "", $string); // Elimina la instrucción DELETE FROM (ignorando mayúsculas/minúsculas)
    $string = str_ireplace("INSERT INTO", "", $string); // Elimina la instrucción INSERT INTO (ignorando mayúsculas/minúsculas)
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string); // Elimina la instrucción SELECT COUNT(*) FROM (ignorando mayúsculas/minúsculas)
    $string = str_ireplace("DROP TABLE", "", $string); // Elimina la instrucción DROP TABLE (ignorando mayúsculas/minúsculas)
    $string = str_ireplace("OR '1'='1", "", $string); // Elimina la condición OR '1'='1
    $string = str_ireplace('OR "1"="1"', "", $string); // Elimina la condición OR "1"="1"
    $string = str_ireplace('OR ´1´=´1´', "", $string); // Elimina la condición OR ´1´=´1´
    $string = str_ireplace("is NULL; --", "", $string); // Elimina la condición is NULL; --
    $string = str_ireplace("is NULL; --", "", $string); // Elimina la condición is NULL; -- (duplicado, se puede eliminar uno)
    $string = str_ireplace("LIKE '", "", $string); // Elimina la parte de la condición LIKE '
    $string = str_ireplace('LIKE "', "", $string); // Elimina la parte de la condición LIKE "
    $string = str_ireplace("LIKE ´", "", $string); // Elimina la parte de la condición LIKE ´
    $string = str_ireplace("OR 'a'='a", "", $string); // Elimina la condición OR 'a'='a
    $string = str_ireplace('OR "a"="a', "", $string); // Elimina la condición OR "a"="a
    $string = str_ireplace("OR ´a´=´a", "", $string); // Elimina la condición OR ´a´=´a
    $string = str_ireplace("OR ´a´=´a", "", $string); // Elimina la condición OR ´a´=´a (duplicado, se puede eliminar uno)
    $string = str_ireplace("--", "", $string); // Elimina los comentarios --
    $string = str_ireplace("^", "", $string); // Elimina el carácter ^
    $string = str_ireplace("[", "", $string); // Elimina el carácter [
    $string = str_ireplace("]", "", $string); // Elimina el carácter ]
    $string = str_ireplace("==", "", $string); // Elimina la comparación ==
    return $string; // Retorna la cadena limpia
}

//Elimina caracteres especiales y acentos de una cadena
function clear_cadena(string $cadena)
{
    //Reemplazamos la A y a con sus equivalentes sin acento
    $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
    );

    //Reemplazamos la E y e con sus equivalentes sin acento
    $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena
    );

    //Reemplazamos la I y i con sus equivalentes sin acento
    $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena
    );

    //Reemplazamos la O y o con sus equivalentes sin acento
    $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena
    );

    //Reemplazamos la U y u con sus equivalentes sin acento
    $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena
    );

    //Reemplazamos la N, n, C y c con sus equivalentes
    $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç', ',', '.', ';', ':'),
        array('N', 'n', 'C', 'c', '', '', '', ''),
        $cadena
    );
    return $cadena; // Retorna la cadena sin caracteres especiales ni acentos
}

//Genera una contraseña aleatoria de la longitud especificada (por defecto 10 caracteres)
function passGenerator($length = 10)
{
    $pass = ""; // Inicializa la variable para la contraseña
    $longitudPass = $length; // Obtiene la longitud deseada de la contraseña
    $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"; // Define los caracteres posibles para la contraseña
    $longitudCadena = strlen($cadena); // Obtiene la longitud de la cadena de caracteres

    for ($i = 1; $i <= $longitudPass; $i++) { // Itera hasta la longitud deseada
        $pos = rand(0, $longitudCadena - 1); // Genera una posición aleatoria dentro de la cadena de caracteres
        $pass .= substr($cadena, $pos, 1); // Agrega el carácter en la posición aleatoria a la contraseña
    }
    return $pass; // Retorna la contraseña generada
}

//Genera un token único utilizando bytes aleatorios convertidos a hexadecimal
function token()
{
    $r1 = bin2hex(random_bytes(10)); // Genera 10 bytes aleatorios y los convierte a hexadecimal
    $r2 = bin2hex(random_bytes(10)); // Genera 10 bytes aleatorios y los convierte a hexadecimal
    $r3 = bin2hex(random_bytes(10)); // Genera 10 bytes aleatorios y los convierte a hexadecimal
    $r4 = bin2hex(random_bytes(10)); // Genera 10 bytes aleatorios y los convierte a hexadecimal
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4; // Concatena los valores hexadecimales con guiones
    return $token; // Retorna el token generado
}

//Realiza una conexión GET a una URL externa utilizando cURL
function CurlConnectionGet(string $ruta, string $contentType = null, string $token)
{
    $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded"; // Define el tipo de contenido o usa el predeterminado
    if ($token != null) { // Verifica si se proporcionó un token
        $arrHeader = array( // Define los encabezados con el token de autorización
            'Content-Type:' . $content_type,
            'Authorization: Bearer ' . $token,
        );
    } else { // Si no hay token
        $arrHeader = array('Content-Type:' . $content_type); // Define los encabezados sin autorización
    }
    $ch = curl_init(); // Inicializa una nueva sesión cURL
    curl_setopt($ch, CURLOPT_URL, $ruta); // Establece la URL para la solicitud
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Omite la verificación del certificado SSL (no recomendado para producción)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la transferencia como una cadena del valor de retorno de curl_exec()
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader); // Establece los encabezados HTTP
    $result = curl_exec($ch); // Ejecuta la sesión cURL
    $err = curl_error($ch); // Devuelve el último error
    curl_close($ch); // Cierra la sesión cURL
    if ($err) { // Si hubo un error
        $request = "CURL Error #:" . $err; // Asigna el mensaje de error a la variable de resultado
    } else { // Si no hubo error
        $request = json_decode($result); // Decodifica la respuesta JSON
    }
    return $request; // Retorna la respuesta de la conexión cURL
}

//Realiza una conexión POST a una URL externa utilizando cURL
function CurlConnectionPost(string $ruta, string $contentType = null, string $token)
{
    $content_type = $contentType != null ? $contentType : "application/x-www-form-urlencoded"; // Define el tipo de contenido o usa el predeterminado
    if ($token != null) { // Verifica si se proporcionó un token
        $arrHeader = array( // Define los encabezados con el token de autorización
            'Content-Type:' . $content_type,
            'Authorization: Bearer ' . $token,
        );
    } else { // Si no hay token
        $arrHeader = array('Content-Type:' . $content_type); // Define los encabezados sin autorización
    }
    $ch = curl_init(); // Inicializa una nueva sesión cURL
    curl_setopt($ch, CURLOPT_URL, $ruta); // Establece la URL para la solicitud
    curl_setopt($ch, CURLOPT_POST, true); // Establece la solicitud como POST
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Omite la verificación del certificado SSL (no recomendado para producción)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la transferencia como una cadena del valor de retorno de curl_exec()
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader); // Establece los encabezados HTTP
    $result = curl_exec($ch); // Ejecuta la sesión cURL
    $err = curl_error($ch); // Devuelve el último error
    curl_close($ch); // Cierra la sesión cURL
    if ($err) { // Si hubo un error
        $request = "CURL Error #:" . $err; // Asigna el mensaje de error a la variable de resultado
    } else { // Si no hubo error
        $request = json_decode($result); // Decodifica la respuesta JSON
    }
    return $request; // Retorna la respuesta de la conexión cURL
}

//Retorna un array con los nombres de los meses del año
function Meses()
{
    $meses = array( // Define un array con los nombres de los meses
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
    );
    return $meses; // Retorna el array de los meses
}

//Obtiene las categorías para el pie de página
function getCatFooter()
{
    require_once "Models/CategoriasModel.php"; // Incluye el modelo de categorías
    $objCategoria = new CategoriasModel(); // Crea una instancia del modelo de categorías
    $request = $objCategoria->getCategoriasFooter(); // Llama al método para obtener las categorías del footer
    return $request; // Retorna los resultados de la consulta
}

//Obtiene la información de una página específica por su ID
function getInfoPage(int $idpagina)
{
    require_once "Libraries/Core/Mysql.php"; // Incluye la clase para la conexión a la base de datos
    $con = new Mysql(); // Crea una instancia de la clase Mysql
    $sql = "SELECT * FROM post WHERE idpost = $idpagina"; // Define la consulta SQL para obtener la página por su ID
    $request = $con->select($sql); // Ejecuta la consulta y obtiene el resultado
    return $request; // Retorna la información de la página
}

//Obtiene la información de una página por su ruta (URL amigable)
function getPageRout(string $ruta)
{
    require_once "Libraries/Core/Mysql.php"; // Incluye la clase para la conexión a la base de datos
    $con = new Mysql(); // Crea una instancia de la clase Mysql
    $sql = "SELECT * FROM post WHERE ruta = '$ruta' AND status != 0 "; // Define la consulta SQL para obtener la página por su ruta y que no esté inactiva
    $request = $con->select($sql); // Ejecuta la consulta y obtiene el resultado
    if (!empty($request)) { // Verifica si se encontró la página
        $request['portada'] = $request['portada'] != "" ? media() . "/images/uploads/" . $request['portada'] : ""; // Construye la URL completa de la portada si existe
    }
    return $request; // Retorna la información de la página
}

//Verifica si una página debe mostrarse al usuario según su estado y permisos
function viewPage(int $idpagina)
{
    require_once "Libraries/Core/Mysql.php"; // Incluye la clase para la conexión a la base de datos
    $con = new Mysql(); // Crea una instancia de la clase Mysql
    $sql = "SELECT * FROM post WHERE idpost = $idpagina "; // Define la consulta SQL para obtener la página por su ID
    $request = $con->select($sql); // Ejecuta la consulta y obtiene el resultado
    if (($request['status'] == 2 and isset($_SESSION['permisosMod']) and $_SESSION['permisosMod']['u'] == true) or $request['status'] == 1) { // Verifica si la página está en revisión (status 2) y el usuario tiene permiso de actualización (u) o si la página está activa (status 1)
        return true; // Retorna true si la página debe mostrarse
    } else {
        return false; // Retorna false si la página no debe mostrarse
    }
}