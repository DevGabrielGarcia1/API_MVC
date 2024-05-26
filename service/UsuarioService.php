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

    public function verificaPermissao($id)
    {
        return parent::verificaPermissao($id);
    }

    public function cadastrarUsuario($username, $senha)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão e ADMIN
        if (!parent::verificaPermissao($jwtSession['id']) || !parent::isAdmin($jwtSession['id'])) {
            return MsgRetorno::defaultMessage_AcessoRestrito();
        }

        //Verifica campos
        if ($username == "" || $senha == "") {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
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

        return MsgRetorno::defaultMessage_Success("Cadastrado");
    }

    public function editarUsuarioAtual($senha_atual, $senha_nova)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão
        $usuario = new UsuarioService();
        if (!$usuario->verificaPermissao($jwtSession['id'])) {
            return MsgRetorno::defaultMessage_AcessoRestrito();
        }

        //Verifica campos
        if ($senha_atual == "" || $senha_nova == "") {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Validar usuario
        $rows = parent::verificaLogin($jwtSession['username'], $senha_atual);
        if (!($rows)) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_USER_OR_PASS;
            $retorno->message = "Senha atual incorreta";
            http_response_code(401);
            return $retorno;
        }

        //Editar e reporta a situação
        $result = parent::editarUsuario($jwtSession['id'], $senha_atual, $senha_nova);
        if ($result !== true) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_PROBLEMAS_BANCO;
            $retorno->message = $result;
            http_response_code(406);
            return $retorno;
        }

        return MsgRetorno::defaultMessage_Success("Editado");
    }

    public function removerUsuario($id)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão e ADMIN
        $usuario = new UsuarioService();
        if (!$usuario->verificaPermissao($jwtSession['id']) || !parent::isAdmin($jwtSession['id'])) {
            return MsgRetorno::defaultMessage_AcessoRestrito();
        }

        //Verifica campos
        if ($id == "") {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Remover e reporta a situação
        $result = parent::removerUsuario($id);
        if ($result !== true) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_PROBLEMAS_BANCO;
            $retorno->message = $result;
            http_response_code(406);
            return $retorno;
        }

        return MsgRetorno::defaultMessage_Success("Removido");
    }

    public function listarUsuarios()
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão e ADMIN
        if (!parent::verificaPermissao($jwtSession['id']) || !parent::isAdmin($jwtSession['id'])) {
            return MsgRetorno::defaultMessage_AcessoRestrito();
        }
        
        //Listar
        $result = parent::listarUsuarios();
        if (is_string($result)) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_PROBLEMAS_BANCO;
            $retorno->message = $result;
            http_response_code(406);
            return $retorno;
        }

        return $result;
    }
}
