<?php

//Turn on output buffering
ob_start();

// Turn on error reporting
ini_set('display errors', 1);
error_reporting(E_ALL);

// require autoload file
require_once ("vendor/autoload.php");
require_once ("controller/controller.php");

//Start the session
session_start();

// create instance of base file
$f3 = Base::instance();

$adviseItCon = new AdviseItController($f3);
$f3->route('GET /', 'AdviseItController->home');

$f3->route('GET|POST /schedule/@token', function () {
    global $f3;
    $GLOBALS['manualToken'] = $f3->get('PARAMS.token');
    $GLOBALS['adviseItCon']->schedule();
});

$f3->run();

//Send output to the browser
ob_flush();
