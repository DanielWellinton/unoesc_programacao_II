<?php

class ContaBancaria {
    private $saldo = 0.0;

    public function depositar($valor) {
        if ($valor > 0) {
            $this->saldo += $valor;
        }
    }

    public function sacar($valor) {
        if ($valor > 0) {
            $this->saldo -= $valor;
        }
    }

    public function getSaldo() {
        return $this->saldo;
    }
}