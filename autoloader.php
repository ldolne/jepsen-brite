<?php

// Requires of other functions
require_once('./require/functions.php');
require_once('./require/configs.php');

// uncomment for Heroku
//require 'vendor/autoload.php';




// TESTS
//require_once ("SplClassLoader.php");

/*$classLoaderModel = new SplClassLoader('model', '/model');
$classLoaderModel->register();

$classLoaderController = new SplClassLoader('\controller', '/controller');
$classLoaderController->register();*/

// Autoload of classes


/*function loadModel($class)
{
    $parts = explode('\\', $class);
    $path = 'model/';
    require_once $path . end($parts) . '.php';
}

function loadController($class)
{
    $parts = explode('\\', $class);
    $path = 'controller/';
    require_once $path . end($parts) . '.php';
}

/*function loadController($class) {
    $path = 'controller/';
    require_once $path . $class .'.php';
}*/

//spl_autoload_register('loadModel');




//spl_autoload_register();