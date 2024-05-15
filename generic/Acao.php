<?php

namespace generic;

use Exception;
use ReflectionMethod;

class Acao
{
    //constants
    const POST = "POST";
    const GET = "GET";
    const PUT = "PUT";
    const DELETE = "DELETE";

    private $classe;
    private $metodo;
    //post, get, delete, patch, put
    private $action;
    private $autenticar;

    public function __construct($classe, $metodo, $action = [Acao::GET],$autenticar = true)
    {
        $this->classe = $classe;
        $this->metodo = $metodo;
        $this->action = $action;
        $this->autenticar = $autenticar;
    }

    public function executar()
    {
        try {
            $decode=null;
            
            if (!$this->verificarMetodo()) {
                http_response_code(405);
                return;
            }

            if($this->autenticar){
                $jwt= new JWTAuth();
                $decode=$jwt->verificar();
                if(!$decode){
                    http_response_code(401);
                    return;
                }
            }

            $return = null;
            $obj = new $this->classe();

            $reflectM = new ReflectionMethod($obj::class, $this->metodo);
            $param = $this->verificaParametros($reflectM, $this->getInput());

            if ($param) {
                $return = $this->invocarMetodos($reflectM, $obj, $param);
                header("Content-Type: application/json");
                $r = new Retorno();
                $r->retorno = $return;
                echo json_encode($r);
            }
        } catch (Exception $e) {
            http_response_code(500);
            return "error";
        }
    }

    private function invocarMetodos($reflect, $obj, $param)
    {
        if ($param === true) {
            return  $reflect->invoke($obj);
        }
        
        return  $reflect->invokeArgs($obj, $param);
    }
    private function verificarMetodo()
    {
        return in_array($_SERVER['REQUEST_METHOD'], $this->action);
    }

    // só recebe json
    private function getInput()
    {
        $input = file_get_contents("php://input");
        if ($input) {
            return json_decode($input, true, 512, JSON_THROW_ON_ERROR);
        }

        return null;
    }
    private function verificaParametros(ReflectionMethod $reflectM, $parametros)
    {

        $param = [];
        $reflecP = $reflectM->getParameters();
        if (sizeof($reflecP)) {
            foreach ($reflecP as $v) {
                $name = $v->getName();

                if (!isset($parametros[$name])) {
                    http_response_code(406);
                    return false;
                }
                $param[$name] = $parametros[$name];
            }


            return $param;
        }

        return true;
    }
}
