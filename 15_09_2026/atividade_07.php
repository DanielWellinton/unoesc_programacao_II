<?php

class Funcionario {
    private string $nome;
    private float $salario;

    public function __construct(string $nome, float $salario)
    {
        $this->nome = $nome;
        $this->salario = $salario;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getSalario(): float
    {
        return $this->salario;
    }

    public function reajusteSalarioConformePorcentagem(float $porcentagem): void
    {
        $porcentagem /= 100;
        $this->salario += ($this->salario * $porcentagem);
    }
}