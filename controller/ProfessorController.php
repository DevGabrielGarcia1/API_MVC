<?php
namespace controller;

use service\ProfessorService;
use view\ProfessoresView;

class ProfessorController{

    public function listarProfessores(){
        $profView = new ProfessoresView();
        $ProfServ = new ProfessorService();
        $lista = $ProfServ->listar();
        $profView->listaProfessores($lista);
    }
}
?>