<?php
namespace dao\mysql;

use dao\interface\IProfessorDAO;
use generic\MysqlFactory;

class ProfessorDAO extends MysqlFactory implements IProfessorDAO{

    public function listar(){
       
        $sql="select idprofessor, nome from professores";
       $retorno= $this->banco->executar($sql);
       return $retorno;
    }

    public function inserir($nome){
        $sql="insert into professores (nome) values (:nome)";
        $retorno= $this->banco->executar($sql,["nome"=>$nome]);
        return $retorno;
    }

    

}

?>