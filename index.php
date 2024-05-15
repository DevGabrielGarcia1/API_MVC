<?php

use generic\Controller;

include_once "generic/AutoLoad.php";
include_once "import/php-jwt/vendor/autoload.php";


if(isset($_GET['param'])){
    $controller = Controller::getInstance();

    $controller->executarRotas($_GET['param']);

}