<?php

namespace dao\interface;

interface IClienteDAO {
    public function clienteExists($id);

    //Cadastrar
    public function cadastrarCliente($nome, $CPF, $data_nascimento, $telefone, $email);

    //Editar
    public function editarCliente($id, $nome, $CPF, $data_nascimento, $telefone, $email);

    public function listarCliente($id = null, $nome = null, $CPF = null, $contrato_ativo = null);
    public function listarClienteAll();
}