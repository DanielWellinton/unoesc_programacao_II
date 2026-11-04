<?php

class Calculadora
{
    public function somar(float $a, ?float $b = null, ?float $c = null): float
    {
        $resultado = $a;
        if ($b !== null) $resultado += $b;
        if ($c !== null) $resultado += $c;
        return $resultado;
    }
}
$calculadora = new Calculadora();
echo $calculadora->somar(5) . PHP_EOL;
echo $calculadora->somar(5, 3) . PHP_EOL;
echo $calculadora->somar(5, 3, 2) . PHP_EOL;
