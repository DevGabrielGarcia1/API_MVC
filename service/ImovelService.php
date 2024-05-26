<?php

namespace service;

use dao\mysql\ImovelDAO;
use generic\JWTAuth;
use generic\MsgRetorno;

class ImovelService extends ImovelDAO
{

    public function cadastrarImovel($tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao)
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
        if ($tipo_imovel == "" || $id_proprietario == "" || $endereco == "" || $cidade == "" || $estado == "" || $CEP == "" || $valor_aluguel == "" || $area == "" || $quartos == "" || $banheiros == "" || $vagas_garagem == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
        }

        //Cadastra imóvels e reporta a situação
        $result = parent::cadastrarImovel($tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao);
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

    public function editarImovel($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao)
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
            if ($k == 1) {
                $valid = ($v == "");
                continue;
            }
            $valid = $valid && ($v == "");
        }
        if ($id == "" || ($valid)) {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Edita imóvel e reporta a situação
        $result = parent::editarImovel($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao);
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

    public function listarImoveis($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem, $active)
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
            if ($k == 0) {
                $valid = ($v == "");
                continue;
            }
            $valid = $valid && ($v == "");
        }
        if ($valid || (($max_valor_aluguel != "" && $valor_aluguel == "") || ($max_area != "" && $area == "") || ($max_quartos != "" && $quartos == "") || ($max_banheiros != "" && $banheiros == "") || ($max_vagas_garagem != "" && $vagas_garagem == ""))) {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Listar os imóveis
        $result = parent::listarImoveis($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem, $active);
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

    public function listarImoveisAll()
    {
        //Recupera o id e username
        $jwt = new JWTAuth();
        $jwtSession = json_decode($jwt->verificar()->uid, true, 512, JSON_THROW_ON_ERROR);

        //Verifica a permissão
        $usuario = new UsuarioService();
        if (!$usuario->verificaPermissao($jwtSession['id'])) {
            return MsgRetorno::defaultMessage_AcessoRestrito();
        }

        //Listar todos os imóveis
        $result = parent::listarImoveisAll();
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

    public function listarImoveisPublic($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem)
    {
        //Verifica campos
        $args = func_get_args();
        $valid = false;
        foreach ($args as $k => $v) {
            if ($k == 0) {
                $valid = ($v == "");
                continue;
            }
            $valid = $valid && ($v == "");
        }
        if ($valid || (($max_valor_aluguel != "" && $valor_aluguel == "") || ($max_area != "" && $area == "") || ($max_quartos != "" && $quartos == "") || ($max_banheiros != "" && $banheiros == "") || ($max_vagas_garagem != "" && $vagas_garagem == ""))) {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Listar os imóveis
        $result = parent::listarImoveisPublic($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem);
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

    public function listarImoveisAllPublic()
    {
        //Listar todos os imóveis
        $result = parent::listarImoveisAllPublic();
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


    public function desativarImovel($id)
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
        if ($id == "") {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
            $retorno->message = "Campos obrigatórios não preenchidos.";
            http_response_code(406);
            return $retorno;
        }

        //Verifica se possui contratos ativos
        $contatos = new ContratoService();
        if ($contatos->imovelTemContratoAtivo($id)) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_ACAO_NAO_PERMITIDA;
            $retorno->message = "Não é possivel desativar imovel com contrato ativo.";
            http_response_code(406);
            return $retorno;
        }

        //Edita imóvel e reporta a situação
        $result = parent::desativarImovel($id);
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
        $retorno->message = "Imóvel desativado";
        return $retorno;
    }

    public function ativarImovel($id)
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
        if ($id == "") {
            return MsgRetorno::defaultMessage_CamposObrigatorios();
        }

        //Edita imóvel e reporta a situação
        $result = parent::ativarImovel($id);
        if ($result !== true) {
            $retorno = new MsgRetorno;
            $retorno->result = MsgRetorno::ERROR;
            $retorno->code = MsgRetorno::CODE_ERROR_PROBLEMAS_BANCO;
            $retorno->message = $result;
            http_response_code(406);
            return $retorno;
        }

        return MsgRetorno::defaultMessage_Success("Imóvel ativado");
    }

    public function imovelExists($id)
    {
        return parent::imovelExists($id);
    }

    public function imovelIsActive($id)
    {
        return parent::imovelIsActive($id);
    }
}
