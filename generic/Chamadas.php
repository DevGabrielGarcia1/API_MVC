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
            "usuario/listar" => new Acao("service\UsuarioService", "listarUsuarios",[Acao::GET, Acao::POST]),

            "cliente/cadastrar" => new Acao("service\ClienteService", "cadastrarCliente",[Acao::POST]),
            "cliente/editar" => new Acao("service\ClienteService", "editarCliente",[Acao::POST]),
            "cliente/listar" => new Acao("service\ClienteService", "listarCliente",[Acao::GET, Acao::POST]),
            "cliente/listar/all" => new Acao("service\ClienteService", "listarClienteAll",[Acao::GET, Acao::POST]),


            "proprietario/cadastrar" => new Acao("service\ProprietarioService", "cadastrarProprietario",[Acao::POST]),
            "proprietario/editar" => new Acao("service\ProprietarioService", "editarProprietario",[Acao::POST]),
            "proprietario/listar" => new Acao("service\ProprietarioService", "listarProprietario",[Acao::GET, Acao::POST]),
            "proprietario/listar/all" => new Acao("service\ProprietarioService", "listarProprietarioAll",[Acao::GET, Acao::POST]),

            "imovel/cadastrar" => new Acao("service\ImovelService", "cadastrarImovel",[Acao::POST]),
            "imovel/editar" => new Acao("service\ImovelService", "editarImovel",[Acao::POST]),
            "imovel/desativar" => new Acao("service\ImovelService", "desativarImovel",[Acao::POST]),
            "imovel/ativar" => new Acao("service\ImovelService", "ativarImovel",[Acao::POST]),
            "imovel/listar" => new Acao("service\ImovelService", "listarImoveis",[Acao::GET, Acao::POST]),
            "imovel/listar/all" => new Acao("service\ImovelService", "listarImoveisAll",[Acao::GET, Acao::POST]),

            "contrato/cadastrar" => new Acao("service\ContratoService", "cadastrarContrato",[Acao::POST]),
            "contrato/editar" => new Acao("service\ContratoService", "editarContrato",[Acao::POST]),
            "contrato/finalizar" => new Acao("service\ContratoService", "finalizarContrato",[Acao::POST]),
            "contrato/listar" => new Acao("service\ContratoService", "listarContratos",[Acao::POST]),
            "contrato/listar/ativos" => new Acao("service\ContratoService", "listarContratosAtivos",[Acao::GET, Acao::POST]),
            "contrato/listar/all" => new Acao("service\ContratoService", "listarContratosAll",[Acao::GET, Acao::POST]),
        
            "public/imovel/listar" => new Acao("service\ImovelService", "listarImoveisPublic",[Acao::GET], false),
            "public/imovel/listar/all" => new Acao("service\ImovelService", "listarImoveisAllPublic",[Acao::GET], false)
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
