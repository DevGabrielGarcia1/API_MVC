<?php

namespace dao\interface;
 
interface IContratoDAO {

    public function cadastrarContrato($id_imovel, $id_cliente, $data_inicio, $data_fim, $forma_pagamento);

}