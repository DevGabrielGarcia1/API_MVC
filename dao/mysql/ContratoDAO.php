<?php

namespace dao\mysql;

use dao\interface\IContratoDAO;
use DateTime;
use Exception;
use generic\MysqlFactory;

class ContratoDAO extends MysqlFactory implements IContratoDAO
{

    public function cadastrarContrato($id_imovel, $id_cliente, $data_inicio, $forma_pagamento)
    {
        $dtInicio = DateTime::createFromFormat('d/m/Y', $data_inicio);

        $sql = "INSERT INTO contratos(id_imovel, id_cliente, data_inicio, forma_pagamento) VALUES (:id_imovel, :id_cliente, :dt_inicio, :pagamento)";
        try {
            $retorno = $this->banco->executar(
                $sql,
                [
                    "id_imovel" => $id_imovel,
                    "id_cliente" => $id_cliente,
                    "dt_inicio" => $dtInicio->format('Y-m-d'),
                    "pagamento" => $forma_pagamento
                ]
            );
        } catch (Exception $e) {
            return "Erro ao inserir no banco. ";
        }
        return true;
    }

    public function editarContrato($id, $forma_pagamento)
    {
        $sql = "UPDATE contratos SET forma_pagamento = :pag WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id, "pag" => $forma_pagamento]);
        } catch (Exception $e) {
            return "Erro ao atualizar o banco.";
        }
        return true;
    }

    public function finalizarContrato($id, $data_fim)
    {
        $dtFim = DateTime::createFromFormat('d/m/Y', $data_fim);
        
        $sql = "UPDATE contratos SET data_fim = :dt_fim WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id, "dt_fim" => $dtFim->format('Y-m-d')]);
        } catch (Exception $e) {
            return "Erro ao atualizar o banco.";
        }
        return true;
    }

    public function clienteTemContrato($id){
        $sql = "SELECT count(id) as result FROM contratos WHERE id_cliente = :id AND data_fim IS NOT NULL";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return ($retorno[0]['result'] > 0) ? true : false;
    }

    public function imovelTemContrato($id){
        $sql = "SELECT count(id) as result FROM contratos WHERE id_imovel = :id AND data_fim IS NOT NULL";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return ($retorno[0]['result'] > 0) ? true : false;
    }
    
}
