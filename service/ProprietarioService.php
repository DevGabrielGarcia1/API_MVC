<?php

namespace service;

use dao\mysql\ProprietarioDAO;
use generic\JWTAuth;
use generic\MsgRetorno;

class ProprietarioService extends ProprietarioDAO {
    
    public function cadastrarProprietario($nome, $CPF, $data_nascimento, $telefone, $email)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão
        $usuario = new UsuarioService();
        $usuario = $usuario->verificaPermissao($jwtSession['id']);
        if (!$usuario) {
            return $usuario;
        }

        //Verifica campos
        if ($nome == "" || $CPF == "" || $data_nascimento == "" || $telefone == "" || $email == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
        }

        //Cadastra cliente e reporta a situação
        $result = parent::cadastrarProprietario($nome, $CPF, $data_nascimento, $telefone, $email);
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

    public function editarProprietario($id, $nome, $CPF, $data_nascimento, $telefone, $email)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão
        $usuario = new UsuarioService();
        $usuario = $usuario->verificaPermissao($jwtSession['id']);
        if (!$usuario) {
            return $usuario;
        }

        //Verifica campos
        if ($id == "" || ($nome == "" && $CPF == "" && $data_nascimento == "" && $telefone == "" && $email == "")) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
        }

        //Edita cliente e reporta a situação
        $result = parent::editarProprietario($id, $nome, $CPF, $data_nascimento, $telefone, $email);
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

    public function listarProprietario($id = null, $nome = null, $CPF = null)
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão
        $usuario = new UsuarioService();
        $usuario = $usuario->verificaPermissao($jwtSession['id']);
        if (!$usuario) {
            return $usuario;
        }
        
        //Verifica campos
        if ($id == "" && $nome == "" && $CPF == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
        }

        //Listar os usuarios
        $result = parent::listarProprietario($id, $nome, $CPF);
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

    public function listarProprietarioAll()
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão
        $usuario = new UsuarioService();
        $usuario = $usuario->verificaPermissao($jwtSession['id']);
        if (!$usuario) {
            return $usuario;
        }

        //Listar todos usuarios
        $result = parent::listarProprietarioAll();
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
    
    public function proprietarioExists($id)
    {
        return parent::proprietarioExists($id);
    }
}