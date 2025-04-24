<?php
$appConfig= require 'appConfig.php';
$url = $_SERVER['REQUEST_URI'];
$method =$_SERVER['REQUEST_METHOD'];

$url=strtolower($url);
$url=trim(str_replace($appConfig['prjName'],'',$url),'/');

require "Database\DBconn.php";
$dataBaseConfig= require "Database/databaseConfig.php";
$db =Database\DBconn::getDB($dataBaseConfig);

require 'Router/Router.php';
$routerClass = new \Router\Router();
$routerClass->addRoute('GET','home/index','HomeController','presentation1');
$routerClass->addRoute('GET','home/login','LoginController','loginAction');

$reValue=$routerClass->match($url,$method);
if(empty($reValue)) {
    http_response_code(404);
    die('Pagina non trova');
}
$controller= 'App\Controller\\'.$reValue['controller'];
$action = $reValue['action'];

require $controller.'.php';
$controllerObj = new $controller($db);
$controllerObj->$action();