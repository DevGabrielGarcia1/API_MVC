<?php

namespace dao\mysql;

use dao\interface\IUsuarioDAO;
use generic\MysqlFactory;

class UsuarioDAO extends MysqlFactory implements IUsuarioDAO
{

    public function verificaLogin($usuario, $senha)
    {
        $sql = "SELECT id, username FROM usuarios WHERE username=:user and senha=:senha";
        $retorno = $this->banco->executar($sql, ["user" => $usuario, "senha" => $senha]);
        return $retorno;
    }

    public function verificaPermissao($id)
    {
        $sql = "SELECT count(id) FROM usuarios WHERE id = :id";
        $retorno = $this->banco->executar($sql, ["id" => $id]);
        return ($retorno[0][0] == 1) ? true : false;
    }

    public function cadastrarUsuario($username, $senha, $nomeCompleto)
    {
        $sql = "INSERT INTO usuarios(username, senha, nomeCompleto) VALUES (:user, :senha, :nomeCompleto)";
        $retorno = $this->banco->executar($sql, ["user" => $username, "senha" => $senha, "nomeCompleto" => $nomeCompleto]);
        return $retorno;
    }

    public function cadastrarCliente($nome, $CPF, $data_nascimento, $telefone, $email)
    {
        $sql = "INSERT INTO clientes(nome, CPF, data_nascimento, telefone, email) VALUES (:nome, :cpf, :dtNasc, :tel, :email)";
        $retorno = $this->banco->executar($sql,
            [
                "nome" => $nome,
                "cpf" => $CPF,
                "dtNasc" => $data_nascimento,
                "tel" => $telefone,
                "email" => $email
            ]
        );
        return $retorno;
    }

    public function cadastrarImovel($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao)
    {
        $sql = "INSERT INTO imoveis(tipo_imovel, endereco, cidade, estado, CEP, valor_aluguel, area, quartos, banheiros, vagas_garagem, descricao) VALUES (:tipo, :endereco, :cidade, :estado, :cep, :valor, :area, :quartos, :banheiros, :vagas, :descr)";
        $retorno = $this->banco->executar($sql,
            [
                "tipo" => $tipo_imovel,
                "endereco" => $endereco,
                "cidade" => $cidade,
                "estado" => $estado,
                "cep" => $CEP,
                "valor" => $valor_aluguel,
                "area" => $area,
                "quartos" => $quartos,
                "banheiros" => $banheiros,
                "vagas" => $vagas_garagem,
                "descr" => $descricao
            ]
        );
        return $retorno;
    }

    public function cadastarContrato($id_imovel, $id_cliente, $data_inicio, $data_fim, $forma_pagamento)
    {
        $sql = "INSERT INTO contratos(id_imovel, id_cliente, data_inicio, data_fim, forma_pagamento) VALUES (:id_imovel, :id_cliente, :dt_inicio, :dt_fim, :pagamento)";
        $retorno = $this->banco->executar($sql,
            [
                "id_imovel" => $id_imovel,
                "id_cliente" => $id_cliente,
                "dt_inicio" => $data_inicio,
                "dt_fim" => $data_fim,
                "pagamento" => $forma_pagamento
            ]
        );
        return $retorno;
    }
}
