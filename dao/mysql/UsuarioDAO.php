<?php

namespace dao\mysql;

use dao\interface\IUsuarioDAO;
use DateTime;
use Exception;
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
        $sql = "SELECT count(id) as valid FROM usuarios WHERE id = :id";
        $retorno = $this->banco->executar($sql, ["id" => $id]);
        return ($retorno[0]['valid'] == 1) ? true : false;
    }

    public function isAdmin($id)
    {
        $sql = "SELECT permissao FROM usuarios WHERE id = :id";
        $retorno = $this->banco->executar($sql, ["id" => $id]);
        return ($retorno[0]['permissao'] == 0) ? true : false;
    }

    public function cadastrarUsuario($username, $senha)
    {
        $sql = "INSERT INTO usuarios(username, senha) VALUES (:user, :senha)";
        try {
            $retorno = $this->banco->executar($sql, ["user" => $username, "senha" => $senha]);
        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                return "Erro: Usuario já existe.";
            }
            return "Erro ao inserir no banco.";
        }
        return true;
    }

    public function editarUsuario($id, $senha_atual, $senha_nova){
        $sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id, "senha" => $senha_nova]);
        } catch (Exception $e) {
            return "Erro ao atualizar o banco.";
        }
        return true;
    }

    public function removerUsuario($id){
        $sql = "DELETE FROM usuarios WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao remover do banco.";
        }
        return true;
    }
}
