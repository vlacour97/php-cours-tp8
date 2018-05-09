<?php
/**
 * Created by PhpStorm.
 * User: valentinlacour
 * Date: 08/05/2018
 * Time: 14:17
 */

include_once 'functions.php';

// Generate file article.json if not exist
createArticleFile();

define('DEFAULT_CONTROLLER', 'home');

$title = 'Mon blog';

$controllers = array(
    'home' => 'home.php',
    'create' => 'create.php',
    'edit' => 'edit.php',
    'delete' => 'delete.php',
    'view' => 'view.php'
);

// Generate controller path and use default controller the get value nav isn't exist
if (isset($controllers[$_GET['nav']]) || is_null($_GET['nav'])) {
    $controllerPath = 'controllers/' . (is_null($_GET['nav'])
        ? $controllers[DEFAULT_CONTROLLER] : $controllers[$_GET['nav']]);
}

// If controller not found we return an error page
if (!isset($controllerPath)) {
    http_response_code(404);
    $controllerPath = 'controllers/404.php';
}

// Get the controller's generated content for modifying headers
ob_start();
include $controllerPath;
$controllerContent = ob_get_clean();


include 'elements/_head.php';
echo $controllerContent;
include 'elements/_footer.php';