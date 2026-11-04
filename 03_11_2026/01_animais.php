<?php
abstract class Animal
{
    public function __construct() {}
    abstract public function falar(): string;
}

class Cachorro extends Animal
{
    public function falar(): string
    {
        return "Au au!";
    }
}
class Gato extends Animal
{
    public function falar(): string
    {
        return "Miau!";
    }
}

$animais = [new Cachorro(), new Gato()];
foreach ($animais as $animal) {
    echo $animal->falar() . PHP_EOL;
}
