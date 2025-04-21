<?php
require_once "Config/Config.php";
require_once "Libraries/Core/Autoload.php";
require_once "Helpers/helpers.php"; // Incluye el archivo de helpers


$url = !empty($_GET['url']) ? $_GET['url'] : 'login';
$arrUrl = explode("/", filter_var($url, FILTER_SANITIZE_URL));

$controller = ucfirst($arrUrl[0]) . "Controller";
$method = isset($arrUrl[1]) && $arrUrl[1] !== '' ? $arrUrl[1] : "index";
$params = array_slice($arrUrl, 2);

$controllerFile = "Controllers/" . $controller . ".php";
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controller();

    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
    } else {
        echo "Error: Método <b>$method</b> no encontrado en el controlador <b>" . get_class($controller) . "</b>";
    }
} else {
    echo "Error: Controlador <b>$controller</b> no encontrado en la ruta <b>$controllerFile</b>";
    die();
}
?>