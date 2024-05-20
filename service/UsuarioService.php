<?php

namespace service;

use dao\mysql\UsuarioDAO;
use Firebase\JWT\JWT;
use generic\JWTAuth;
use generic\MsgRetorno;
use stdClass;

class UsuarioService extends UsuarioDAO
{

    public function autenticar($username, $senha)
    {
        //Validar usuario
        $rows = parent::verificaLogin($username, $senha);

        //Criar token
        if ($rows) {
            $jwt = new JWTAuth();
            $objeto = new stdClass();
            $objeto->username = $rows[0]["username"];
            $objeto->id = $rows[0]["id"];

            return $jwt->criarChave(json_encode($objeto));
        }

        $retorno = new MsgRetorno;
        $retorno->result = MsgRetorno::ERROR;
        $retorno->code = MsgRetorno::CODE_ERROR_USER_OR_PASS;
        $retorno->message = "Usuario ou senha estão incorretos.";
        http_response_code(401);
        return $retorno;
    }

    public function verificaPermissao($id){
        return parent::verificaPermissao($id);
    }

    public function cadastrarUsuario($username, $senha)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão
        if (!parent::verificaPermissao($jwtSession['id'])) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_ACESSO_RESTRITO;
            $retorno->message = "Acesso restrito";
            http_response_code(401);
            return $retorno;
        }

        //Verifica campos
        if ($username == "" || $senha == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
        }

        //Cadastra usuario e reporta a situação
        $result = parent::cadastrarUsuario($username, $senha);
        if ($result !== true) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_PROBLEMAS_BANCO;
            $retorno->message = $result;
            http_response_code(406);
            return $retorno;
        }

        $retorno = new MsgRetorno();
        $retorno->result = MsgRetorno::SUCCESS;
        $retorno->code = MsgRetorno::CODE_SUCCESS_OPERATION;
        $retorno->message = "Cadastrado";
        return $retorno;
    }

}
