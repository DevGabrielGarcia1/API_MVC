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
            "cadastrar/cliente" => new Acao("service\UsuariosService", "cadastrarCliente",[Acao::POST]),
            "cadastrar/imovel" => new Acao("service\UsuariosService", "cadastrarImovel",[Acao::POST]),
            "cadastrar/contrato" => new Acao("service\UsuariosService", "cadastrarContrato",[Acao::POST]),
           
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
