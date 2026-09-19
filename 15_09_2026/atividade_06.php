<?php

class Retangulo {

    private float $largura;
    private float $altura;

    public function __construct(float $largura, float $altura)
    {
        $this->largura = $largura;
        $this->altura = $altura;
    }

    public function getLargura(): float
    {
        return $this->largura;
    }

    public function setLargura(float $largura): void
    {
        $this->largura = $largura;
    }

    public function getAltura(): float
    {
        return $this->altura;
    }

    public function setAltura(float $altura): void
    {
        $this->altura = $altura;
    }

    public function getArea(): float
    {
        return $this->largura * $this->altura;
    }

    public function getPerimetro(): float
    {
        $perimetro = 0;
        $perimetro += $this->largura * 2;
        $perimetro += $this->altura * 2;
        return $perimetro;
    }
}