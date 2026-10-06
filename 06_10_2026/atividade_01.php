<?php

class ContaBancaria {
    private float $saldo = 0.0;

    public function depositar(float $valor): void {
        if ($valor <= 0) {
            throw new InvalidArgumentException("Valor de depósito inválido.");
        }
        $this->saldo += $valor;
    }

    public function sacar(float $valor): bool {
        if ($valor <= 0 || $valor > $this->saldo) {
            return false;
        }
        $this->saldo -= $valor;
        return true;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }
}