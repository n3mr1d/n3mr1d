<?php

/**
 * Autoload function to include PHP files from the resource/function directory
 * 
 * @param string $fun The name of the function file to load (without .php extension)
 * @return void
 */
include_once __DIR__ . '/public/apigithub.php';
 function autoload(string $fun) {
    global $db, $error;
    $path = __DIR__ . '/resource/function/' . $fun . '.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        trigger_error("Function file '$fun.php' not found", E_USER_WARNING);
    }
}
autoload('navbar');
autoload('database');
autoload('route');
autoload('form');
autoload('validate');
