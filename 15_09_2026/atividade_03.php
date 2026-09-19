<?php

class ContaBancaria
{
    private string $titular;
    private float $saldo;

    public function __construct(string $titular, float $saldo)
    {
        $this->titular = $titular;
        $this->saldo = $saldo;
    }

    public function getTitular(): string
    {
        return $this->titular;
    }

    public function depositar(float $valor): void
    {
        $this->saldo += $valor;
    }

    public function sacar(float $valor): void
    {
        $this->saldo -= $valor;
    }

    public function exibirSaldo(): string
    {
        return "R$ " . number_format($this->saldo, 2, ',', '.');
    }
}
