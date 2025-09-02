<?php
    // Verificar que los archivos necesarios existen
    if (!file_exists("Config/Config.php")) {
        die("Error: Config/Config.php no encontrado");
    }
    
    require_once "Config/Config.php";
    
    if (file_exists("vendor/autoload.php")) {
        require_once "vendor/autoload.php";
    }
    
    if (!file_exists("Helpers/Helpers.php")) {
        die("Error: Helpers/Helpers.php no encontrado");
    }
    require_once "Helpers/Helpers.php";
    
    // Obtener la URL y procesarla
    $url = !empty($_GET['url']) ? $_GET['url'] : 'login';
    $arrUrl = explode("/", $url);
    $controller = $arrUrl[0];
    $method = $arrUrl[0]; // Por defecto, el método es igual al controlador
    $params = "";

    // Si hay un segundo parámetro, es el método
    if (!empty($arrUrl[1]) && $arrUrl[1] != "") {
        $method = $arrUrl[1];
    }

    // Si hay más parámetros, son los argumentos
    if (!empty($arrUrl[2])) {
        for ($i = 2; $i < count($arrUrl); $i++) {
            if ($arrUrl[$i] != "") {
                $params .= $arrUrl[$i] . ',';
            }
        }   
        $params = trim($params, ',');
    }
    
    // Cargar el sistema
    if (!file_exists("Libraries/Core/Autoload.php")) {
        die("Error: Libraries/Core/Autoload.php no encontrado");
    }
    require_once "Libraries/Core/Autoload.php";
    
    if (!file_exists("Libraries/Core/Load.php")) {
        die("Error: Libraries/Core/Load.php no encontrado");
    }
    require_once "Libraries/Core/Load.php";