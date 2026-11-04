<?php

abstract class FiguraGeometrica
{
    abstract public function calcularArea(): float;
}

class Circulo extends FiguraGeometrica
{
    public function __construct(private float $raio) {}
    public function calcularArea(): float
    {
        return pi() * pow($this->raio, 2);
    }
}

class Retangulo extends FiguraGeometrica
{
    public function __construct(private float $base, private float $altura) {}
    public function calcularArea(): float
    {
        return $this->base * $this->altura;
    }
}

class Triangulo extends FiguraGeometrica
{
    public function __construct(private float $base, private float $altura) {}
    public function calcularArea(): float
    {
        return ($this->base * $this->altura) / 2;
    }
}

$figurasGeometricas = [new Circulo(5), new Retangulo(4, 6), new Triangulo(8, 3)];
foreach ($figurasGeometricas as $figuraGeometrica) {
    echo get_class($figuraGeometrica) . ": " . number_format($figuraGeometrica->calcularArea(), 2, ',', '.') . " unidades²" . PHP_EOL;
}
