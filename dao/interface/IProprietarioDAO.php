<?php

namespace dao\interface;

interface IProprietarioDAO {
    public function proprietarioExists($id);

    //Cadastrar
    public function cadastrarProprietario($nome, $CPF, $data_nascimento, $telefone, $email);

    //Editar
    public function editarProprietario($id, $nome, $CPF, $data_nascimento, $telefone, $email);

    public function listarProprietario($id = null, $nome = null, $CPF = null);
    public function listarProprietarioAll();
}