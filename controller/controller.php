<?php

ini_set('display errors', 1);
error_reporting(E_ALL);

require_once ("vendor/autoload.php");
require_once("model/Database.php");

/**
 * The Advise-It controller
 */
class AdviseItController {
    private  $_f3;
    private  $_adviseItDB;

    function  __construct($f3){
        $this->_adviseItDB = new Database();
        $this->_f3 = $f3;
    }

    function home(): void
    {
        $token = $this->generateToken();
        $_SESSION["token"] = $token;

        $route = "schedule/" . $token;
        $this->_f3->set('token', $route);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->_f3->reroute($route);
        }

        $view = new Template();
        echo $view->render('views/home.html');
    }

    function generateToken(): string {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $randomStr = "";
        for($i = 0; $i < 6; $i++){
            $randomStr .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomStr;
    }

    function schedule(): void {

        $token = $_SESSION["token"];
        $this->_f3->set('textToken', $token);

        if(!empty($token)){
            $this->_adviseItDB->addToken($token);
        } else {
//            make get request to db using URL token
            $this->_adviseItDB->getPlan($GLOBALS['manualToken']);
//            display data in quarter box
        }

        $view = new Template();
        echo $view->render('views/schedule.html');
    }
}
