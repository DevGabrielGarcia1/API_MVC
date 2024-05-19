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
            "editar/usuario" => new Acao("service\UsuariosService", "",[Acao::POST]),
            "editar/cliente" => new Acao("service\UsuariosService", "",[Acao::POST]),
            "editar/imovel" => new Acao("service\UsuariosService", "",[Acao::POST]),
            "contrato/cancelar" => new Acao("service\UsuariosService", "",[Acao::POST]),
            "remover/usuario" => new Acao("service\UsuariosService", "",[Acao::DELETE]),
            "remover/cliente" => new Acao("service\UsuariosService", "",[Acao::DELETE]),
            "remover/imovel" => new Acao("service\UsuariosService", "",[Acao::DELETE]),
            "imoveis/listar" => new Acao("service\UsuariosService", "",[Acao::GET, Acao::POST], false),
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
