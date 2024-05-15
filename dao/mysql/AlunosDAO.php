<?php

namespace dao\mysql;

use dao\interface\IAlunosDAO;
use generic\MysqlFactory;

class AlunosDAO extends MysqlFactory implements IAlunosDAO
{

    public function verificaLogin($ra, $senha)
    {

        $sql = "select nome,ra from alunos where ra=:ra and senha=:senha";
        $retorno = $this->banco->executar($sql, ["ra" => $ra, "senha" => $senha]);
        return $retorno;
    }
}
