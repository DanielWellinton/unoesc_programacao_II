<?php

class Usuario {
    private $senha;

    public function __construct($senha) {
        $this->senha = $senha;
    }

    public function verificarSenha($senhaInformada) {
        return $this->senha === $senhaInformada;
    }
}