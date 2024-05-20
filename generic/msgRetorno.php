<?php
namespace generic;

use LDAP\Result;

class MsgRetorno {
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

    public $result;
    public $code;
    public $message;
}