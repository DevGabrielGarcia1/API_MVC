<?php

namespace dao\interface;

interface IUsuarioDAO{
    public function verificaLogin($usuario,$senha);
    public function verificaPermissao($id);
    
    //Cadastrar
    public function cadastrarUsuario($username, $senha);

    //Editar


    //Excluir
}

