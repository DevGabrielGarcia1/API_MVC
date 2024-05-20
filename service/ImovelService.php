<?php

namespace service;

use dao\mysql\ImovelDAO;
use generic\JWTAuth;
use generic\MsgRetorno;

class ImovelService extends ImovelDAO {
    
    public function cadastrarImovel($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao)
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
        if ($tipo_imovel == "" || $endereco == "" || $cidade == "" || $estado == "" || $CEP == "" || $valor_aluguel == "" || $area == "" || $quartos == "" || $banheiros == "" || $vagas_garagem == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
        }

        //Cadastra usuario e reporta a situação
        $result = parent::cadastrarImovel($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao);
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


    public function imovelExists($id)
    {
        return parent::imovelExists($id);
    }
}