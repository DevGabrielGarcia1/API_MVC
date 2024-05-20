<?php

namespace dao\interface;

interface IUsuarioDAO{
    public function verificaLogin($usuario,$senha);
    public function verificaPermissao($id);
    public function isAdmin($id);
    
    //Cadastrar
    public function cadastrarUsuario($username, $senha);

    //Editar
    public function editarUsuario($id, $senha_atual, $senha_nova);

    //Excluir
    public function removerUsuario($id);
}

