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
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_ACESSO_RESTRITO;
            $retorno->message = "Acesso restrito";
            http_response_code(401);
            return $retorno;
        }

        //Verifica campos
        if ($id_imovel == "" || $id_cliente == "" || $data_inicio == "" || $forma_pagamento == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
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

        //Verifica se imovel ou cliente já possui contrato ativo
        if(parent::imovelTemContrato($id_imovel)){
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_IMOVEL_CONTRATOATIVO;
            $retorno->message = "Imóvel já está alugado.";
            http_response_code(406);
            return $retorno;
        }
        if(parent::clienteTemContrato($id_cliente)){
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

        $retorno = new MsgRetorno();
        $retorno->result = MsgRetorno::SUCCESS;
        $retorno->code = MsgRetorno::CODE_SUCCESS_OPERATION;
        $retorno->message = "Cadastrado";
        return $retorno;
    }

    public function editarContrato($id, $forma_pagamento)
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
        if ($id == "" || $forma_pagamento == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
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

        $retorno = new MsgRetorno();
        $retorno->result = MsgRetorno::SUCCESS;
        $retorno->code = MsgRetorno::CODE_SUCCESS_OPERATION;
        $retorno->message = "Editado";
        return $retorno;
    }

    public function finalizarContrato($id, $data_fim)
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
        if ($id == "" || $data_fim == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
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

        $retorno = new MsgRetorno();
        $retorno->result = MsgRetorno::SUCCESS;
        $retorno->code = MsgRetorno::CODE_SUCCESS_OPERATION;
        $retorno->message = "Contrato finalizado";
        return $retorno;
    }

}