<?php

namespace dao\mysql;

use dao\interface\IContratoDAO;
use DateTime;
use Exception;
use generic\MsgRetorno;
use generic\MysqlFactory;
use stdClass;

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

    public function listarContratos($id, $id_imovel, $id_cliente, $data_inicio, $data_fim, $forma_pagamento, $contrato_ativo)
    {

        $dtInicio = DateTime::createFromFormat('d/m/Y', $data_inicio);
        $dtFim = DateTime::createFromFormat('d/m/Y', $data_fim);

        $sql = "SELECT  id, id_imovel, id_cliente, DATE_FORMAT(data_inicio,'%d/%m/%Y') as data_inicio, DATE_FORMAT(data_fim,'%d/%m/%Y') as data_fim, forma_pagamento, data_fim IS NULL as contrato_ativo FROM contratos WHERE";
        
        $where = array();
        if($id != ""){
            $sql .= " id = :id AND";
            $where['id'] = $id;
        }
        if($id_imovel != ""){
            $sql .= " id_imovel = :idImovel AND";
            $where['idImovel'] = $id_imovel;
        }
        if($id_cliente != ""){
            $sql .= " id_cliente = :idCli AND";
            $where['idCli'] = $id_cliente;
        }
        if($data_inicio!= ""){
            $sql .= " data_inicio like :dtIni AND";
            try {
                $where['dtIni'] = "%".$dtInicio->format('Y-m-d')."%";
            } catch (\Throwable $th) {
                $where['dtIni'] = "%".$data_inicio."%";
            }
        }
        if($data_fim != ""){
            $sql .= " data_fim like :dtFim AND";
            try {
                $where['dtFim'] = "%".$dtFim->format('Y-m-d')."%";
            } catch (\Throwable $th) {
                $where['dtFim'] = "%".$data_fim."%";
            }
            
        }
        if($forma_pagamento != ""){
            $sql .= " forma_pagamento like :pag AND";
            $where['pag'] = "%".$forma_pagamento."%";
        }
        if($contrato_ativo != ""){
            $sql .= " (data_fim IS NULL) = :con AND";
            $where['con'] = $contrato_ativo;
        }

        $sql = substr($sql, 0, -4);
        
        try {
            $retorno = $this->banco->executar($sql, $where);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return $retorno;
    }

    public function listarContratosAll()
    {
        $sql = "SELECT  id, id_imovel, id_cliente, DATE_FORMAT(data_inicio,'%d/%m/%Y') as data_inicio, DATE_FORMAT(data_fim,'%d/%m/%Y') as data_fim, forma_pagamento FROM contratos";
        try {
            $retorno = $this->banco->executar($sql);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return $retorno;
    }

    public function clienteTemContratoAtivo($id){
        $sql = "SELECT count(id) as result FROM contratos WHERE id_cliente = :id AND data_fim IS NULL";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return ($retorno[0]['result'] == 0) ? false : true;
    }

    public function imovelTemContratoAtivo($id){
        $sql = "SELECT count(id) as result FROM contratos WHERE id_imovel = :id AND data_fim IS NULL";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return ($retorno[0]['result'] == 0) ? false : true;
    }
    
}
