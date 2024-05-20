<?php

namespace dao\mysql;

use dao\interface\IImovelDAO;
use Exception;
use generic\MysqlFactory;

class ImovelDAO extends MysqlFactory implements IImovelDAO {

    public function cadastrarImovel($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao)
    {
        $sql = "INSERT INTO imoveis(tipo_imovel, endereco, cidade, estado, CEP, valor_aluguel, area, quartos, banheiros, vagas_garagem, descricao) VALUES (:tipo, :endereco, :cidade, :estado, :cep, :valor, :area, :quartos, :banheiros, :vagas, :descr)";
        try {
            $retorno = $this->banco->executar(
                $sql,
                [
                    "tipo" => $tipo_imovel,
                    "endereco" => $endereco,
                    "cidade" => $cidade,
                    "estado" => $estado,
                    "cep" => $CEP,
                    "valor" => str_replace(",",".",$valor_aluguel),
                    "area" => $area,
                    "quartos" => $quartos,
                    "banheiros" => $banheiros,
                    "vagas" => $vagas_garagem,
                    "descr" => $descricao
                ]
            );
        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                return "Erro: Imóvel já existe.";
            }
            return "Erro ao inserir no banco.";
        }
        return true;
    }

}