<?php
namespace dao\interface;
interface IProfessorDAO{
    public function listar();
    public function inserir($nome);
}