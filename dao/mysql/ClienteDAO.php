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
                return "Erro: CPF já existe.";
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

    public function listarCliente($id = null, $nome = null, $CPF = null, $contrato_ativo = null)
    {
        
        $sql = "SELECT c.id, nome, CPF, data_nascimento, telefone, email,  con.data_fim IS NOT NULL as contrato_ativo FROM clientes as c LEFT JOIN contratos as con ON c.id = con.id_cliente WHERE";
        
        $where = array();
        if($id != "" || $id != NULL){
            $sql .= " c.id = :id AND";
            $where['id'] = $id;
        }
        if($nome != "" || $nome != NULL){
            $sql .= " nome like :nome AND";
            $where['nome'] = "%".$nome."%";
        }
        if($CPF != "" || $CPF != NULL){
            $sql .= " CPF = :cpf AND";
            $where['cpf'] = $CPF;
        }
        if($contrato_ativo != "" || $contrato_ativo){
            $sql .= " (con.data_fim IS NOT NULL) = :con AND";
            $where['con'] = $contrato_ativo;
        }

        $sql = substr($sql, 0, -4);
        
        try {
            $retorno = $this->banco->executar($sql, $where);
        } catch (Exception $e) {
            return "Erro ao buscar no banco. ".$e->getMessage();
        }
        return $retorno;
    }

    public function listarClienteAll(){

        $sql = "SELECT c.id, nome, CPF, data_nascimento, telefone, email, con.data_fim IS NOT NULL as contrato_ativo FROM clientes as c LEFT JOIN contratos as con ON c.id = con.id_cliente";
        try {
            $retorno = $this->banco->executar($sql);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return $retorno;
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
}
