<?php
spl_autoload_register(function ($class){
    $raiz = "/API_MVC/";
    
    if(!file_exists($_SERVER["DOCUMENT_ROOT"].$raiz.$class.".php")){;
        //Resolve o problema se a pasta do projeto não estiver na raiz do xampp (htdocs)
        $raiz = strtok($_SERVER["REQUEST_URI"],"?");
        $raiz= substr($raiz, 0, (strlen($raiz) - strlen($_GET["param"]) ));
    }
    
    //Normal se tiver na raiz (htdocs)
    include $_SERVER["DOCUMENT_ROOT"].$raiz.$class.".php";

    //include $_SERVER["DOCUMENT_ROOT"]."/API_MVC/".$class.".php";
});