<?php

namespace view;

use generic\View;

class ProfessoresView extends View
{
    public function listaProfessores($lista)
    {
        $param = array(
            "lista" => $lista
        );
        $this->conteudo("public/ListaProfessores.php", $param);
    }
}
