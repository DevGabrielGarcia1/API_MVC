<?php

namespace dao\mysql;

use dao\interface\IClienteDAO;
use DateTime;
use Exception;
use generic\MysqlFactory;

class ClienteDAO extends MysqlFactory implements IClienteDAO {

    public function cadastrarCliente($nome, $CPF, $data_nascimento, $telefone, $email)
    {
        $dtNasc = DateTime::createFromFormat('d/m/Y', $data_nascimento);

        $sql = "INSERT INTO clientes(nome, CPF, data_nascimento, telefone, email) VALUES (:nome, :cpf, :dtNasc, :tel, :email)";
        try {
            $retorno = $this->banco->executar(
                $sql,
                [
                    "nome" => $nome,
                    "cpf" => $CPF,
                    "dtNasc" => $dtNasc->format('Y-m-d'),
                    "tel" => $telefone,
                    "email" => $email
                ]
            );
        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                return "Erro: Cliente já existe.";
            }
            return "Erro ao inserir no banco.";
        }
        return true;
    }

}