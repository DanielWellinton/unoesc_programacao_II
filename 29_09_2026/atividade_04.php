<?php

class Funcionario {
    protected $salario;

    public function __construct($salario) {
        $this->salario = $salario;
    }

    public function getSalario() {
        return $this->salario;
    }
}

class Gerente extends Funcionario {
    public function modificarSalario($novoSalario) {
        $this->salario = $novoSalario;
    }
}