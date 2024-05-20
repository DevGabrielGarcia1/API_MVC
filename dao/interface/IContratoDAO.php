<?php

namespace dao\interface;
 
interface IContratoDAO {

    //Cadastrar
    public function cadastrarContrato($id_imovel, $id_cliente, $data_inicio, $forma_pagamento);

    //Editar
    public function editarContrato($id, $forma_pagamento);

    //Finalizar
    public function finalizarContrato($id, $data_fim);

    public function clienteTemContrato($id);
    public function imovelTemContrato($id);

}