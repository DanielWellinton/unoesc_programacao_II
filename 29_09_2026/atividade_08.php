<?php

class Cliente {
    public $nome = "Daniel";
    protected $cpf = "123.456.789-00";
    private $telefone = "(10) 98765-4321";

    public function testarAcessoInterno() {
        return "Nome: {$this->nome}, CPF: {$this->cpf}, Telefone: {$this->telefone}";
    }
}

$cliente = new Cliente();
echo $cliente->nome;
// echo $cliente->cpf;
// echo $cliente->telefone;