<?php
namespace generic;

class Controller{
    private static $instancia;
    private $chamadas;
    
    private function __construct(){
       $this->chamadas=new Chamadas();
    }

    public static function getInstance(){
        if(self::$instancia==null){
            self::$instancia = new Controller();

        }
        return self::$instancia;
    }

    public function executarRotas($endpoint){
        $rota=$this->chamadas->buscarRotas($endpoint);
        if(!$rota){
            http_response_code(404);
            return;
        }
       
        $rota->executar();

        

         

        
    }




}