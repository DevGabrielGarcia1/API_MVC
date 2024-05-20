<?php

namespace generic;

class Chamadas
{
    private $arrChamadas = [];
    public function __construct()
    {
        $this->arrChamadas = [
            "usuario/autenticar" => new Acao("service\UsuarioService", "autenticar", [Acao::POST], false),
            
            "usuario/cadastrar" => new Acao("service\UsuarioService", "cadastrarUsuario",[Acao::POST]),
            "usuario/editar" => new Acao("service\UsuarioService", "editarUsuarioAtual",[Acao::POST]),
            "usuario/remover" => new Acao("service\UsuarioService", "removerUsuario",[Acao::DELETE]),
            "usuario/listar" => new Acao("service\UsuarioService", "listarUsuarios",[Acao::POST]),

            "cliente/cadastrar" => new Acao("service\ClienteService", "cadastrarCliente",[Acao::POST]),
            "cliente/editar" => new Acao("service\ClienteService", "",[Acao::POST]),
            "cliente/listar" => new Acao("service\ClienteService", "",[Acao::GET, Acao::POST]),

            "proprietario/cadastrar" => new Acao("service\ProprietarioService", "cadastrarProprietario",[Acao::POST]),
            "proprietario/editar" => new Acao("service\ProprietarioService", "editarProprietario",[Acao::POST]),
            "proprietario/listar" => new Acao("service\ProprietarioService", "listarProprietario",[Acao::GET, Acao::POST]),

            "imovel/cadastrar" => new Acao("service\ImovelService", "cadastrarImovel",[Acao::POST]),
            "imovel/editar" => new Acao("service\ImovelService", "",[Acao::POST]),
            "imovel/desativar" => new Acao("service\ImovelService", "",[Acao::POST]),
            "imovel/ativar" => new Acao("service\ImovelService", "",[Acao::POST]),

            "contrato/cadastrar" => new Acao("service\ContratoService", "cadastrarContrato",[Acao::POST]),
            "contrato/editar" => new Acao("service\ContratoService", "editarContrato",[Acao::POST]),
            "contrato/finalizar" => new Acao("service\ContratoService", "finalizarContrato",[Acao::POST]),
            "contrato/listar/all" => new Acao("service\ContratoService", "finalizarContrato",[Acao::GET, Acao::POST]),
        
            "imovel/listar" => new Acao("service\...Service", "",[Acao::GET, Acao::POST], false),
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
