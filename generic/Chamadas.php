<?php

namespace generic;

class Chamadas
{
    private $arrChamadas = [];
    public function __construct()
    {
        $this->arrChamadas = [
            "usuario/autenticar" => new Acao("service\UsuarioService", "autenticar", [Acao::POST], false),
            
            "cadastrar/usuario" => new Acao("service\UsuarioService", "cadastrarUsuario",[Acao::POST]),
            "cadastrar/cliente" => new Acao("service\ClienteService", "cadastrarCliente",[Acao::POST]),
            "cadastrar/imovel" => new Acao("service\ImovelService", "cadastrarImovel",[Acao::POST]),
            "cadastrar/contrato" => new Acao("service\ContratoService", "cadastrarContrato",[Acao::POST]),

            "editar/usuario" => new Acao("service\UsuarioService", "",[Acao::POST]),
            "editar/cliente" => new Acao("service\ClienteService", "",[Acao::POST]),
            "editar/imovel" => new Acao("service\ImovelService", "",[Acao::POST]),

            "contrato/cancelar" => new Acao("service\ContratoService", "",[Acao::POST]),
            "remover/usuario" => new Acao("service\UsuarioService", "",[Acao::DELETE]),
            "remover/cliente" => new Acao("service\ClienteService", "",[Acao::DELETE]),
            "remover/imovel" => new Acao("service\ImovelService", "",[Acao::DELETE]),

            "imoveis/listar" => new Acao("service\...Service", "",[Acao::GET, Acao::POST], false),
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
