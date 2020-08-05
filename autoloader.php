<?php

// Autoload of classes
/*function loadModel($class) {
    $path = 'model/';
    require_once $path . $class .'.php';
}

function loadController($class) {
    $path = 'controller/';
    require_once $path . $class .'.php';
}*/

//spl_autoload_register('loadModel');
//spl_autoload_register('loadController');

spl_autoload_register();

// Requires of other functions
require_once('./require/functions.php');
require_once('./require/configs.php');

// uncomment for Heroku
//require 'vendor/autoload.php';