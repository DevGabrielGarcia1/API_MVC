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
                return "Erro: Problema com ID do proprietário.";
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


    public function listarImoveisPublic($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem)
    {
        $sql = "SELECT i.id, tipo_imovel, endereco, cidade, estado, CEP, valor_aluguel, area, quartos, banheiros, vagas_garagem, descricao FROM imoveis as i LEFT JOIN contratos as c ON i.id = c.id_imovel WHERE ((c.id_imovel IS NOT NULL AND c.data_fim IS NOT NULL) OR c.id_imovel IS NULL) AND active = 1 AND";
        return $this->listImoveis(null, $tipo_imovel, null, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem, null,  $sql);
    }


    public function listarImoveis($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem, $active)
    {
        $sql = "SELECT id, tipo_imovel, id_proprietario, endereco, cidade, estado, CEP, valor_aluguel, area, quartos, banheiros, vagas_garagem, descricao, active FROM imoveis WHERE";
        return $this->listImoveis($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem, $active, $sql);
    }
    

    private function listImoveis($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem, $active, $_sql)
    {
        $sql = $_sql;
        
        $where = array();
        //id
        if($id != ""){
            $sql .= " id = :id AND";
            $where['id'] = $id;
        }
        //tipo
        if($tipo_imovel != ""){
            $sql .= " tipo_imovel like :tipo AND";
            $where['tipo'] = "%".$tipo_imovel."%";
        }
        //proprietario
        if($id_proprietario != ""){
            $sql .= " id_proprietario = :idProp AND";
            $where['idProp'] = $id_proprietario;
        }
        //endereço
        if($endereco != ""){
            $sql .= " endereco like :end AND";
            $where['end'] = "%".$endereco."%";
        }
        //cidade
        if($cidade != ""){
            $sql .= " cidade like :cidade AND";
            $where['cidade'] = "%".$cidade."%";
        }
        //estado
        if($estado != ""){
            $sql .= " estado like :estado AND";
            $where['estado'] = "%".$estado."%";
        }
        //cep
        if($CEP != ""){
            $sql .= " CEP = :cep AND";
            $where['cep'] = $CEP;
        }
        //valor aluguel e max
        if($valor_aluguel!= ""){
            $_sql = " valor_aluguel = :valorA AND";
            //max
            if($max_valor_aluguel != ""){
                $_sql = " (valor_aluguel BETWEEN :valorA AND :valorMax) AND";
                $where['valorMax'] = $max_valor_aluguel;
            }
            $sql .= $_sql;
            $where['valorA'] = $valor_aluguel;
        }
        //area e max
        if($area != ""){
            $_sql = " area = :area AND";
            //max
            if($max_area != ""){
                $_sql = " (area BETWEEN :area AND :areaMax) AND";
                $where['areaMax'] = $max_area;
            }
            $sql .= $_sql;
            $where['area'] = $area;
        }
        //quartos e max
        if($quartos != ""){
            $_sql = " quartos = :quart AND";
            //max
            if($max_quartos != ""){
                $_sql = " (quartos BETWEEN :quart AND :quartMax) AND";
                $where['quartMax'] = $max_quartos;
            }
            $sql .= $_sql;
            $where['quart'] = $quartos;
        }
        //banheiros e max
        if($banheiros != ""){ 
            $_sql = " banheiros = :ban AND";
            //max
            if($max_banheiros != ""){
                $_sql = " (banheiros BETWEEN :ban AND :banMax) AND";
                $where['banMax'] = $max_banheiros;
            }
            $sql .= $_sql;
            $where['ban'] = $banheiros;
        }
        //vagas garagem e max
        if($vagas_garagem != ""){
            $_sql = " vagas_garagem = :vagasG AND";
            //max
            if($max_vagas_garagem != ""){
                $_sql = " (vagas_garagem BETWEEN :vagasG AND :vagasGMax) AND";
                $where['vagasGMax'] = $max_vagas_garagem;
            }
            $sql .= $_sql;
            $where['vagasG'] = $vagas_garagem;
        }
        //active
        if($active != ""){
            $sql .= " active = :active AND";
            $where['active'] = $active;
        }

        $sql = substr($sql, 0, -4);
        
        try {
            $retorno = $this->banco->executar($sql, $where);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return $retorno;
    }

    public function listarImoveisAllPublic()
    {
        $sql = "SELECT i.id, tipo_imovel, endereco, cidade, estado, CEP, valor_aluguel, area, quartos, banheiros, vagas_garagem, descricao FROM imoveis as i LEFT JOIN contratos as c ON i.id = c.id_imovel WHERE ((c.id_imovel IS NOT NULL AND c.data_fim IS NOT NULL) OR c.id_imovel IS NULL) AND active = 1";
        return $this->listImoveisAll($sql);
    }

    public function listarImoveisAll()
    {
        $sql = "SELECT id, tipo_imovel, id_proprietario, endereco, cidade, estado, CEP, valor_aluguel, area, quartos, banheiros, vagas_garagem, descricao, active FROM imoveis";
        return $this->listImoveisAll($sql);
    }

    private function listImoveisAll($_sql)
    {
        $sql = $_sql;
        try {
            $retorno = $this->banco->executar($sql);
        } catch (Exception $e) {
            return "Erro ao buscar no banco.";
        }
        return $retorno;
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