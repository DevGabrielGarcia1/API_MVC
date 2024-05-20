<?php

namespace dao\mysql;

use dao\interface\IContratoDAO;
use DateTime;
use Exception;
use generic\MysqlFactory;

class ContratoDAO extends MysqlFactory implements IContratoDAO {

    public function cadastrarContrato($id_imovel, $id_cliente, $data_inicio, $data_fim, $forma_pagamento)
    {
        $dtInicio = DateTime::createFromFormat('d/m/Y', $data_inicio);
        $dtFim = DateTime::createFromFormat('d/m/Y', $data_fim);

        $sql = "INSERT INTO contratos(id_imovel, id_cliente, data_inicio, data_fim, forma_pagamento) VALUES (:id_imovel, :id_cliente, :dt_inicio, :dt_fim, :pagamento)";
        try {
            $retorno = $this->banco->executar(
                $sql,
                [
                    "id_imovel" => $id_imovel,
                    "id_cliente" => $id_cliente,
                    "dt_inicio" => $dtInicio->format('Y-m-d'),
                    "dt_fim" => $dtFim->format('Y-m-d'),
                    "pagamento" => $forma_pagamento
                ]
            );
        } catch (Exception $e) {
            return "Erro ao inserir no banco.";
        }
        return true;
    }

}