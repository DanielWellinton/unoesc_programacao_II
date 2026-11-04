<?php
abstract class Impressora
{
    public function __construct() {}
    abstract public function imprimir(): string;
}

class Pdf extends Impressora
{
    public function imprimir(): string
    {
        return "Imprimindo PDF";
    }
}
class Texto extends Impressora
{
    public function imprimir(): string
    {
        return "Imprimindo texto!";
    }
}
class Imagem extends Impressora
{
    public function imprimir(): string
    {
        return "Imprimindo imagem!";
    }
}

$impressoras = [new Pdf(), new Texto(), new Imagem()];
foreach ($impressoras as $impressora) {
    echo $impressora->imprimir() . PHP_EOL;
}
