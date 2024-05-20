<?php

namespace dao\interface;

interface IClienteDAO {
    public function clienteExists($id);

    //Cadastrar
    public function cadastrarCliente($nome, $CPF, $data_nascimento, $telefone, $email);

    //Editar
    public function editarCliente($id, $nome, $CPF, $data_nascimento, $telefone, $email);

    
}