<?php
abstract class Mensagem
{
    public function __construct() {}
    abstract public function formatarTexto(string $texto): string;
}

class Maiusculo extends Mensagem
{
    public function formatarTexto(string $texto): string
    {
        return strtoupper($texto);
    }
}
class Minusculo extends Mensagem
{
    public function formatarTexto(string $texto): string
    {
        return strtolower($texto);
    }
}
class Capitalizado extends Mensagem
{
    public function formatarTexto(string $texto): string
    {
        return ucfirst($texto);
    }
}

$mensagems = [new Maiusculo(), new Minusculo(), new Capitalizado()];
foreach ($mensagems as $mensagem) {
    echo $mensagem->formatarTexto("teXto") . PHP_EOL;
}
