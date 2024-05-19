<?php

namespace service;

use dao\mysql\UsuarioDAO;
use Firebase\JWT\JWT;
use generic\JWTAuth;
use generic\MsgRetorno;
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

    public function cadastrarUsuario($username, $senha, $nomeCompleto){

        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);
        
        if(!parent::verificaPermissao($jwtSession['id'])){
            //..
        }

        if($username == "" && $senha == ""){
            //..
        }

        $result = parent::cadastrarUsuario($username, $senha, $nomeCompleto);
        if($result !== true){
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = 23000;
            $retorno->message = $result;
            return $retorno;
        }

        $retorno = new MsgRetorno();
        $retorno->result = MsgRetorno::SUCCESS;
        $retorno->code = 1;
        $retorno->message = "Cadastrado";
        return $retorno;
    }

}