<?php

namespace service;

use dao\mysql\UsuarioDAO;
use generic\JWTAuth;
use stdClass;

class UsuariosService extends UsuarioDAO{

    public function autenticar($user, $senha){
        
        //Validar usuario
        $rows = parent::verificaLogin($user, $senha);

        //Criar token
        if($rows){
            $jwt = new JWTAuth();
            $objeto=new stdClass();
            $objeto->username=$rows[0]["username"];
            $objeto->id=$rows[0]["id"];

            return $jwt->criarChave(json_encode($objeto));
        }

        http_response_code(401);
    }

}