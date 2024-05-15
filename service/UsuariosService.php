<?
namespace service;

use generic\JWTAuth;

class UsuariosService{

    public function autenticar(){
        $jwt = new JWTAuth();
        return $jwt->criarChave("Patrick");
    }
}

?>