<?php

namespace service;

use dao\mysql\ClienteDAO;
use generic\JWTAuth;
use generic\MsgRetorno;

class ClienteService extends ClienteDAO {
    
    public function cadastrarCliente($nome, $CPF, $data_nascimento, $telefone, $email)
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
        if ($nome == "" || $CPF == "" || $data_nascimento == "" || $telefone == "" || $email == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
        }

        //Cadastra cliente e reporta a situação
        $result = parent::cadastrarCliente($nome, $CPF, $data_nascimento, $telefone, $email);
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

    public function editarCliente($id, $nome, $CPF, $data_nascimento, $telefone, $email)
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
        if ($id == "" || ($nome == "" && $CPF == "" && $data_nascimento == "" && $telefone == "" && $email == "")) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
        }

        //Edita cliente e reporta a situação
        $result = parent::editarCliente($id, $nome, $CPF, $data_nascimento, $telefone, $email);
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

    public function listarCliente($id = null, $nome = null, $CPF = null, $contrato_ativo = null)
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
        if ($id == "" && $nome == "" && $CPF == "" && $contrato_ativo == "") {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Listar os usuarios
        $result = parent::listarCliente($id, $nome, $CPF, $contrato_ativo);
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

    public function listarClienteAll()
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão
        $usuario = new UsuarioService();
        if (!$usuario->verificaPermissao($jwtSession['id'])) {
            return MsgRetorno::defaultMessage_AcessoRestrito();
        }

        //Listar todos usuarios
        $result = parent::listarClienteAll();
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
    
    public function clienteExists($id)
    {
        return parent::clienteExists($id);
    }
}