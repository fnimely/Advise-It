<?php

ini_set('display errors', 1);
error_reporting(E_ALL);

require ("vendor/autoload.php");

/**
 * The Advise-It controller
 */
class AdviseItController {
    private  $_f3;
    private  $_adviseItDB;

    function  __construct($f3){
        $this->_adviseItDB = new Database();
        $_SESSION['studentPlan'] = new Plan();
        $this->_f3 = $f3;
    }

    function home(): void
    {
        $_SESSION['studentPlan']->setToken($this->generateToken());
        $route = "schedule/" .  $_SESSION['studentPlan']->getToken();

//        add token to f3 hive
        $this->_f3->set('token', $route);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->_adviseItDB->addTokenId( $_SESSION['studentPlan']->getToken());
            $this->_f3->reroute("schedule/" . $_SESSION['studentPlan']->getToken());
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

        // attempt request to db using URL token
        $studentPlan = $this->_adviseItDB->getPlan($GLOBALS['studentToken']);

        if($studentPlan){
            $_SESSION['studentPlan']->setToken($studentPlan['token']);
            $_SESSION['studentPlan']->setFall($studentPlan['fall']);
            $_SESSION['studentPlan']->setWinter($studentPlan['winter']);
            $_SESSION['studentPlan']->setSpring($studentPlan['spring']);
            $_SESSION['studentPlan']->setSummer($studentPlan['summer']);
        } else {
            $this->_f3->set("error", "Invalid token");
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            try {
                $this->_adviseItDB->addPlan($_SESSION['studentPlan']);
            } catch (Exception $e) {
                echo "Fail to add to DB: " . $e->getMessage();
            }
        }

//        add plans to fat-free hive
        $this->_f3->set("fall", $_SESSION['studentPlan']->getFall());
        $this->_f3->set("winter", $_SESSION['studentPlan']->getWinter());
        $this->_f3->set("spring", $_SESSION['studentPlan']->getSpring());
        $this->_f3->set("summer", $_SESSION['studentPlan']->getSummer());

        $view = new Template();
        echo $view->render('views/schedule.html');
    }
}
