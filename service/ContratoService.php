<?php

namespace service;

use dao\mysql\ContratoDAO;
use generic\JWTAuth;
use generic\MsgRetorno;

class ContratoService extends ContratoDAO{

    public function cadastrarContrato($id_imovel, $id_cliente, $data_inicio, $forma_pagamento)
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
        if ($id_imovel == "" || $id_cliente == "" || $data_inicio == "" || $forma_pagamento == "") {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Verifica se imovel e cliente existe
        $imovel = new ImovelService();
        if(!$imovel->imovelExists($id_imovel)){
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_IMOVEL_NOTEXIST;
            $retorno->message = "Imóvel não existe";
            http_response_code(412);
            return $retorno;
        }
        $cliente = new ClienteService();
        if(!$cliente->clienteExists($id_cliente)){
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_IMOVEL_NOTEXIST;
            $retorno->message = "Cliente não existe";
            http_response_code(412);
            return $retorno;
        }

        //Verifica se imovel está ativo
        if(!$imovel->imovelIsActive($id_imovel)){
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_IMOVEL_DESATIVADO;
            $retorno->message = "Imóvel está desativado.";
            http_response_code(412);
            return $retorno;
        }

        //Verifica se imovel ou cliente já possui contrato ativo
        if(parent::imovelTemContratoAtivo($id_imovel)){
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_IMOVEL_CONTRATOATIVO;
            $retorno->message = "Imóvel já está alugado.";
            http_response_code(406);
            return $retorno;
        }
        if(parent::clienteTemContratoAtivo($id_cliente)){
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CLIENTE_CONTRATOATIVO;
            $retorno->message = "Cliente já possui um contrato ativo";
            http_response_code(406);
            return $retorno;
        }

        //Cadastra usuario e reporta a situação
        $result = parent::cadastrarContrato($id_imovel, $id_cliente, $data_inicio, $forma_pagamento);
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

    public function editarContrato($id, $forma_pagamento)
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
        if ($id == "" || $forma_pagamento == "") {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Editar e reporta a situação
        $result = parent::editarContrato($id, $forma_pagamento);
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

    public function finalizarContrato($id, $data_fim)
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
        if ($id == "" || $data_fim == "") {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Finalizar contrato e reporta a situação
        $result = parent::finalizarContrato($id, $data_fim);
        if ($result !== true) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_PROBLEMAS_BANCO;
            $retorno->message = $result;
            http_response_code(406);
            return $retorno;
        }

        return MsgRetorno::defaultMessage_Success("Contrato finalizado");
    }

    public function listarContratos($id, $id_imovel, $id_cliente, $data_inicio, $data_fim, $forma_pagamento, $contrato_ativo)
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
        $args = func_get_args();
        $valid = false;
        foreach ($args as $k => $v) {
            if($k==0){
                $valid = ($v == "");
                continue;
            }
            $valid = $valid && ($v == "");
        }
        if ($valid) {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Listar os usuarios
        $result = parent::listarContratos($id, $id_imovel, $id_cliente, $data_inicio, $data_fim, $forma_pagamento, $contrato_ativo);
        if (is_string($result)) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_PROBLEMAS_BANCO;
            $retorno->message = $result;
            http_response_code(406);
            return $retorno;
        }
        if(isset($result->error)){
            if($result->error)
                return $result->pack;
        }

        return $result;
    }

    public function listarContratosAtivos()
    {
        return $this->listarContratos(null,null,null,null,null,null,1);
    }

    public function listarContratosAll()
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
        $result = parent::listarContratosAll();
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