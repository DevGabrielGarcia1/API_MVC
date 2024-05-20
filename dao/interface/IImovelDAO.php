<?php

namespace dao\interface;

interface IImovelDAO {

    //Cadastrar
    public function cadastrarImovel($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao);

    //Editar

    //Excluir

}