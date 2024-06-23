<?php

namespace dao\mysql;

use dao\interface\IProprietarioDAO;
use DateTime;
use Exception;
use generic\MysqlFactory;
use generic\Utils;

class ProprietarioDAO extends MysqlFactory implements IProprietarioDAO
{

    public function cadastrarProprietario($nome, $CPF, $data_nascimento, $telefone, $email)
    {
        $dtNasc = Utils::detectDate($data_nascimento);
        
        $sql = "INSERT INTO proprietarios(nome, CPF, data_nascimento, telefone, email) VALUES (:nome, :cpf, :dtNasc, :tel, :email)";
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

    public function editarProprietario($id, $nome, $CPF, $data_nascimento, $telefone, $email)
    {
        $dtNasc = DateTime::createFromFormat('d/m/Y', $data_nascimento);
        
        $sql = "UPDATE proprietarios set nome=IF(:nome='',nome,:nome), 
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

    public function listarProprietario($id = null, $nome = null, $CPF = null)
    {
        
        $sql = "SELECT id, nome, CPF, data_nascimento, telefone, email FROM proprietarios WHERE";
        
        $where = array();
        if($id != "" || $id != NULL){
            $sql .= " id = :id AND";
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

        $sql = substr($sql, 0, -4);
        
        try {
            $retorno = $this->banco->executar($sql, $where);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return $retorno;
    }

    public function listarProprietarioAll(){

        $sql = "SELECT id, nome, CPF, data_nascimento, telefone, email FROM proprietarios";
        try {
            $retorno = $this->banco->executar($sql);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return $retorno;
    }

    public function proprietarioExists($id)
    {
        $sql = "SELECT count(id) as result FROM proprietarios WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao inserir no banco.";
        }
        return ($retorno[0]['result'] == 0) ? false : true;
    }
}
