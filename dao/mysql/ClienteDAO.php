<?php

namespace dao\mysql;

use dao\interface\IClienteDAO;
use DateTime;
use Exception;
use generic\MysqlFactory;
use generic\Retorno;

class ClienteDAO extends MysqlFactory implements IClienteDAO
{

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

    public function editarCliente($id, $nome, $CPF, $data_nascimento, $telefone, $email)
    {
        $dtNasc = DateTime::createFromFormat('d/m/Y', $data_nascimento);
        
        $sql = "UPDATE clientes set nome=IF(:nome='',nome,:nome), 
                                    CPF=IF(:cpf='',CPF,:cpf), 
                                    data_nascimento=IF(:dtNasc='',data_nascimento,:dtNasc), 
                                    telefone=IF(:tel='',telefone,:tel), 
                                    email=IF(:email='',email,:email)
                                    WHERE id = :id";
        try {
            $retorno = $this->banco->executar(
                $sql,
                [
                    "id" => $id,
                    "nome" => $nome,
                    "cpf" => $CPF,
                    "dtNasc" => ($dtNasc!=false)?$dtNasc->format('Y-m-d'):'',
                    "tel" => $telefone,
                    "email" => $email
                ]
            );
        } catch (Exception $e) {
            return "Erro ao inserir no banco.";
        }
        return true;
    }

    public function clienteExists($id)
    {
        $sql = "SELECT count(id) as result FROM clientes WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao inserir no banco.";
        }
        return ($retorno[0]['result'] == 0) ? false : true;
    }

    public function listarClienteAll(){

        $sql = "SELECT id, nome, CPF, data_nascimento, telefone, email,   if(contrato) as contrato_ativo FROM clientes ";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao inserir no banco.";
        }
        return ($retorno[0]['result'] == 0) ? false : true;
    }
}
