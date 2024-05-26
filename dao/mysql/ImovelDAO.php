<?php

namespace dao\mysql;

use dao\interface\IImovelDAO;
use Exception;
use generic\MysqlFactory;

class ImovelDAO extends MysqlFactory implements IImovelDAO {

    public function cadastrarImovel($tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao)
    {
        $sql = "INSERT INTO imoveis(tipo_imovel, id_proprietario, endereco, cidade, estado, CEP, valor_aluguel, area, quartos, banheiros, vagas_garagem, descricao) VALUES (:tipo, :proprietario, :endereco, :cidade, :estado, :cep, :valor, :area, :quartos, :banheiros, :vagas, :descr)";
        try {
            $retorno = $this->banco->executar(
                $sql,
                [
                    "tipo" => $tipo_imovel,
                    "proprietario"=> $id_proprietario,
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

    public function editarImovel($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao)
    {
        $sql = "UPDATE imoveis set  tipo_imovel=IF(:tipoI='',tipo_imovel,:tipoI), 
                                    id_proprietario=IF(:idP='',id_proprietario,:idP), 
                                    endereco=IF(:endereco='',endereco,:endereco), 
                                    cidade=IF(:cidade='',cidade,:cidade), 
                                    estado=IF(:estado='',estado,:estado),
                                    CEP=IF(:cep='',CEP,:cep),
                                    valor_aluguel=IF(:valorA='',valor_aluguel,:valorA),
                                    area=IF(:area='',area,:area),
                                    quartos=IF(:quartos='',quartos,:quartos),
                                    banheiros=IF(:banheiros='',banheiros,:banheiros),
                                    vagas_garagem=IF(:vagasG='',vagas_garagem,:vagasG),
                                    descricao=IF(:descr='',descricao,:descr)
                                    WHERE id = :id";
        try {
            $retorno = $this->banco->executar(
                $sql,
                [
                    "id" => $id,
                    "tipoI" => $tipo_imovel,
                    "idP" => $id_proprietario,
                    "endereco" => $endereco,
                    "cidade" => $cidade,
                    "estado" => $estado,
                    "cep" => $CEP,
                    "valorA" => str_replace(",",".",$valor_aluguel),
                    "area" => $area,
                    "quartos" => $quartos,
                    "banheiros" => $banheiros,
                    "vagasG" => $vagas_garagem,
                    "descr" => $descricao
                ]
            );
        } catch (Exception $e) {
            return "Erro ao inserir no banco. ".$e->getMessage();
        }
        return true;
    }

    public function desativarImovel($id)
    {
        $sql = "UPDATE imoveis set active=0 WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                return "Erro ao desativar imovel.";
            }
            return "Erro ao atuaizar no banco.";
        }
        return true;
    }

    public function ativarImovel($id)
    {
        $sql = "UPDATE imoveis set active=1 WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            if ($e->getCode() == 23000) {
                return "Erro ao ativar imovel.";
            }
            return "Erro ao atualizar no banco.";
        }
        return true;
    }

    public function imovelExists($id)
    {
        $sql = "SELECT count(id) as result FROM imoveis WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return ($retorno[0]['result'] == 0) ? false : true;
    }

    public function imovelIsActive($id)
    {
        $sql = "SELECT active as result FROM imoveis WHERE id = :id";
        try {
            $retorno = $this->banco->executar($sql, ["id" => $id]);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return ($retorno[0]['result'] == 0) ? false : true;
    }
}