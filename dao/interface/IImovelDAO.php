<?php

namespace dao\interface;

interface IImovelDAO {

    //Cadastrar
    public function cadastrarImovel($tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao);

    //Editar
    public function editarImovel($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao);

    //Listar
    public function listarImoveis($id, $tipo_imovel, $id_proprietario, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem, $active);
    public function listarImoveisAll();
    public function listarImoveisPublic($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $max_valor_aluguel, $area, $max_area, $quartos, $max_quartos, $banheiros, $max_banheiros, $vagas_garagem, $max_vagas_garagem);
    public function listarImoveisAllPublic();

    public function desativarImovel($id);

    public function ativarImovel($id);


    public function imovelExists($id);
    public function imovelIsActive($id);
}