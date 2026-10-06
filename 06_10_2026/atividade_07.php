<?php

class Carro {
    private float $velocidade = 0.0;

    public function acelerar(float $incremento): void {
        if ($incremento < 0) return;
        $this->velocidade += $incremento;
        if ($this->velocidade > 200) {
            $this->velocidade = 200;
        }
    }

    public function frear(float $decremento): void {
        if ($decremento < 0) return;
        $this->velocidade -= $decremento;
        if ($this->velocidade < 0) {
            $this->velocidade = 0;
        }
    }

    public function getVelocidade(): float {
        return $this->velocidade;
    }
}