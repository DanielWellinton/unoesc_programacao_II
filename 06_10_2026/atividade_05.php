<?php

class Funcionario {
    protected float $salario;
    protected string $nome;

    public function __construct(string $nome, float $salario) {
        $this->nome = $nome;
        $this->salario = $salario;
    }

    public function getSalario(): float {
        return $this->salario;
    }
}

class Gerente extends Funcionario {
    private float $bonus;

    public function __construct(string $nome, float $salario, float $bonus) {
        parent::__construct($nome, $salario);
        $this->bonus = $bonus;
    }

    public function setBonus(float $bonus): void {
        $this->bonus = $bonus;
    }

    public function getSalarioTotal(): float {
        return $this->salario + $this->bonus;
    }
}