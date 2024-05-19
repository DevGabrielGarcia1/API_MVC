<?php

namespace generic;

class Chamadas
{
    private $arrChamadas = [];
    public function __construct()
    {
        $this->arrChamadas = [
            "usuario/autenticar" => new Acao("service\UsuariosService", "autenticar", [Acao::POST], false),
            "cadastrar/usuario" => new Acao("service\UsuariosService", "cadastrarUsuario",[Acao::POST]),
            "professores/inserir" => new Acao("service\ProfessorService", "inserir",[Acao::POST]),
            "usuarios/autenticar" => new Acao("service\UsuariosService", "autenticar",[Acao::POST],false),
            "alunos/autenticar" => new Acao("service\AlunosService", "autenticar",[Acao::POST],false),
           
        ];
    }

    public function buscarRotas($endpoint)
    {
       
        if (isset($this->arrChamadas[$endpoint])) {
          
            return   $this->arrChamadas[$endpoint];
        }

        return null;
    }
}
