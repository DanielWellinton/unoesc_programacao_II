<?php
abstract class Transporte
{
    public function __construct() {}
    abstract public function calcularTarifa(): string;
}

class Onibus extends Transporte
{
    public function calcularTarifa(): string
    {
        return "Calcule para onibus!";
    }
}
class Metro extends Transporte
{
    public function calcularTarifa(): string
    {
        return "Calcule para metro!";
    }
}
class Taxi extends Transporte
{
    public function calcularTarifa(): string
    {
        return "Calcule para taxi!";
    }
}

$transportes = [new Onibus(), new Metro(), new Taxi()];
foreach ($transportes as $transporte) {
    echo $transporte->calcularTarifa() . PHP_EOL;
}
