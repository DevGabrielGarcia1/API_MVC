<?php

namespace dao\interface;

interface IClienteDAO {

    //Cadastrar
    public function cadastrarCliente($nome, $CPF, $data_nascimento, $telefone, $email);

    //Editar

    //Excluir

}