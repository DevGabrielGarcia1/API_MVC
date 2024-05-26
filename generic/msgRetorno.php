<?php

namespace generic;

use LDAP\Result;

class MsgRetorno
{
    const SUCCESS = "Success";
    const ERROR = "Error";

    //Codes Success
    const CODE_SUCCESS_OPERATION = 1;

    //Codes Error
    const CODE_ERROR_GENERIC = 100;
    const CODE_ERROR_USER_OR_PASS = 101;
    const CODE_ERROR_ACESSO_RESTRITO = 102;
    const CODE_ERROR_CAMPOS_OBRIGATORIOS = 103;
    const CODE_ERROR_PROBLEMAS_BANCO = 104;
    const CODE_ERROR_PARAMETROS_INCORRETOS = 105;
    const CODE_ERROR_CLIENTE_CONTRATOATIVO = 106;
    const CODE_ERROR_IMOVEL_CONTRATOATIVO = 107;
    const CODE_ERROR_IMOVEL_NOTEXIST = 108;
    const CODE_ERROR_CLIENTE_NOTEXIST = 109;
    const CODE_ERROR_NOT_ACCEPT = 110;
    const CODE_ERROR_ACAO_NAO_PERMITIDA = 111;
    const CODE_ERROR_IMOVEL_DESATIVADO = 112;

    public $result;
    public $code;
    public $message;

    public static function defaultMessage_Success($msg = "Operação bem sucedida.")
    {
        $retorno = new MsgRetorno();
        $retorno->result = MsgRetorno::SUCCESS;
        $retorno->code = MsgRetorno::CODE_SUCCESS_OPERATION;
        $retorno->message = $msg;
        return $retorno;
    }

    public static function defaultMessage_AcessoRestrito()
    {
        $retorno = new MsgRetorno;
        $retorno->result = MsgRetorno::ERROR;
        $retorno->code = MsgRetorno::CODE_ERROR_ACESSO_RESTRITO;
        $retorno->message = "Acesso restrito";
        http_response_code(401);
        return $retorno;
    }

    public static function defaultMessage_CamposObrigatorios()
    {
        $retorno = new MsgRetorno;
        $retorno->result = MsgRetorno::ERROR;
        $retorno->code = MsgRetorno::CODE_ERROR_CAMPOS_OBRIGATORIOS;
        $retorno->message = "Campos obrigatórios não preenchidos.";
        http_response_code(406);
        return $retorno;
    }
}
