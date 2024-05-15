<?php
namespace generic;
class View {
    private function cabecalho() {
        return "<div> Cabecalho</div>";
    }
    private function rodape(){
        return "<div> Rodape </div>";
    }

    public function conteudo($caminho,$param = array()){
        echo $this->cabecalho();
        include $caminho;
        echo $this->rodape();
    }
}
?>