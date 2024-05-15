<?php

namespace service;


use dao\mysql\AlunosDAO;
use generic\JWTAuth;
use stdClass;

class AlunosService extends AlunosDAO
{
    public function autenticar($ra, $senha)
    {

        $rows = parent::verificaLogin($ra, $senha);
        if ($rows) {
            $jwt = new JWTAuth();
            $objeto=new stdClass();
            $objeto->nome=$rows[0]["nome"];
            $objeto->ra=$rows[0]["ra"];

            return $jwt->criarChave(json_encode($objeto));
        }

        http_response_code(401);
    }
}
