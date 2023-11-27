<?php

require_once 'app/controllers/item.controller.php';
require_once 'app/controllers/auth.controller.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'home';
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);


switch($params[0]) {

    //Muestra el home con el listado de items
    case 'home':
        $controller = new itemController();
        $controller->showItems();
        break;

    //Muestra un item en especifico con toda su info
    case 'modelo':
        if (isset($params[1])) {
            $controller = new itemController();
            $id = $params[1];
            $controller->showItem($id);
        }
        break;

    //Muesta el form para que ingrese el usuario
    case 'login':
        $controller = new authController();
        $controller->showLogin();
        break;

    //Procesa los datos ingresado por el usuario en el form de ingreso
    case 'auth':
        $controller = new authController();
        $controller->auth();
        break;

    case 'agregar':
        //Muestra el form para agregar un nuevo item
        $controller = new itemController();
        $controller->ShowNewItemForm();
        break;

    //Procesa los datos ingresados al form para agregar items.
    case 'procesar_agregar':
        $controller = new itemController();
        $controller->procesarAgregar();
        break;

    case 'editar': 
        if (isset($params[1])) {
            $controller = new itemController();
            $controller->showUpdateItemForm($params[1]);
        }
        break;
    case 'eliminar':
        if (isset($params[1])) {
            $controller = new itemController();
            $controller->deleteItem($params[1]);
        }
        break;
    case 'procesar_editar':
        if (isset($params[1])) {
            $controller = new itemController();
            $controller->editItem($params[1]);
        }
        break;

    case 'logout':
        $controller = new authController();
        $controller->logout();
        break;

    default: 
        $controller = new itemController();
        $controller->showErrorPage();
        break;

}