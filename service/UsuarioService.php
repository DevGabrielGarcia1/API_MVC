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

    public function verificaPermissao($id, $message = "Acesso restrito")
    {
        if (!parent::verificaPermissao($id)) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_ACESSO_RESTRITO;
            $retorno->message = $message;
            http_response_code(401);
            return $retorno;
        }
        return true;
    }

    public function cadastrarUsuario($username, $senha)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão e ADMIN
        if (!parent::verificaPermissao($jwtSession['id']) || !parent::isAdmin($jwtSession['id'])) {
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

    public function editarUsuarioAtual($senha_atual, $senha_nova)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão
        $usuario = new UsuarioService();
        if (!$usuario->verificaPermissao($jwtSession['id'])) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_ACESSO_RESTRITO;
            $retorno->message = "Acesso restrito";
            http_response_code(401);
            return $retorno;
        }

        //Verifica campos
        if ($senha_atual == "" || $senha_nova == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
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

        $retorno = new MsgRetorno();
        $retorno->result = MsgRetorno::SUCCESS;
        $retorno->code = MsgRetorno::CODE_SUCCESS_OPERATION;
        $retorno->message = "Editado";
        return $retorno;
    }

    public function removerUsuario($id)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão e ADMIN
        $usuario = new UsuarioService();
        if (!$usuario->verificaPermissao($jwtSession['id']) || !parent::isAdmin($jwtSession['id'])) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_ACESSO_RESTRITO;
            $retorno->message = "Acesso restrito";
            http_response_code(401);
            return $retorno;
        }

        //Verifica campos
        if ($id == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
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

        $retorno = new MsgRetorno();
        $retorno->result = MsgRetorno::SUCCESS;
        $retorno->code = MsgRetorno::CODE_SUCCESS_OPERATION;
        $retorno->message = "Removido";
        return $retorno;
    }

    public function listarUsuarios()
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão e ADMIN
        if (!parent::verificaPermissao($jwtSession['id']) || !parent::isAdmin($jwtSession['id'])) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_ACESSO_RESTRITO;
            $retorno->message = "Acesso restrito";
            http_response_code(401);
            return $retorno;
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
