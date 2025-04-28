<?php
$appConfig= require 'appConfig.php';
$url = explode('?',$_SERVER['REQUEST_URI'])[0];
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



// Rotte per le visite
$routerClass->addRoute('GET','home/visite','VisiteController','index');  // Visualizza tutte le visite
$routerClass->addRoute('GET','visite/dettaglio','VisiteController','show'); // Visualizza dettagli di una visita
$routerClass->addRoute('GET','visite/prenota','VisiteController','prenota'); // Prenotazione visita
$routerClass->addRoute('GET','visite/cancella-prenotazione','VisiteController','cancellaPrenotazione'); // Cancella prenotazione
$routerClass->addRoute('GET','visite/mie-prenotazioni','VisiteController','miePrenotazioni'); // Visualizza le proprie prenotazioni

$routerClass->addRoute('POST','home/login','LoginController','processLogin');
$routerClass->addRoute('GET', 'home/profilo', 'LoginController', 'profilo');
$routerClass->addRoute('GET', 'profilo/edit-email', 'ProfileController', 'editEmailForm');
$routerClass->addRoute('POST', 'profilo/updateEmail', 'ProfileController', 'updateEmail');
$routerClass->addRoute('GET', 'profilo/edit-password', 'ProfileController', 'editPasswordForm');
$routerClass->addRoute('POST', 'profilo/updatePassword', 'ProfileController', 'updatePassword');


$reValue=$routerClass->match($url,$method);
if(empty($reValue)) {
    http_response_code(404);
    die('Pagina non trova');
}
$controller= 'App\Controller\\'.$reValue['controller'];
$action = $reValue['action'];

require $controller.'.php';

// Passa il database al controller se accetta un parametro nel costruttore
$controllerReflection = new ReflectionClass($controller);
$constructor = $controllerReflection->getConstructor();

if ($constructor && $constructor->getNumberOfParameters() > 0) {
    $controllerObj = new $controller($db);
} else {
    $controllerObj = new $controller();
}

// Gestisci i parametri della rotta (come l'ID della visita)
$params = [];
if (isset($reValue['params'])) {
    $params = $reValue['params'];
}

$methodReflection = new ReflectionMethod($controllerObj, $action);
$methodParams = $methodReflection->getParameters();

$callParams = [];
foreach ($methodParams as $index => $param) {
    if ($index === 0 && $param->getType() && $param->getType()->getName() === PDO::class) {
        // Il primo parametro è di tipo PDO, quindi passiamo $db
        $callParams[] = $db;
    }
}

$callParams = array_merge($callParams, $params);

call_user_func_array([$controllerObj, $action], $callParams);
