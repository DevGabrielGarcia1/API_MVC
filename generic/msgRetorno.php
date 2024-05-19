<?php
namespace generic;

use LDAP\Result;

class MsgRetorno {
    const SUCCESS = "Success";
    const ERROR = "Error";

    public $result;
    public $code;
    public $message;
}