<?php

namespace dao\interface;

interface IUsuarioDAO{
    public function verificaLogin($usuario,$senha);
    public function verificaPermissao($id);
    public function cadastrarUsuario($username, $senha, $nomeCompleto);
    public function cadastrarCliente($nome, $CPF, $data_nascimento, $telefone, $email);
    public function cadastrarImovel($tipo_imovel, $endereco, $cidade, $estado, $CEP, $valor_aluguel, $area, $quartos, $banheiros, $vagas_garagem, $descricao);
    public function cadastarContrato($id_imovel, $id_cliente, $data_inicio, $data_fim, $forma_pagamento);
}

