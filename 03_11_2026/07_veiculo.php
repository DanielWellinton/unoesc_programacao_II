<?php
abstract class Veiculo
{
    public function __construct() {}
    abstract public function mover(): string;
}

class Carro2 extends Veiculo
{
    public function mover(): string
    {
        return "Dirija!";
    }
}
class Bicicleta extends Veiculo
{
    public function mover(): string
    {
        return "Pedala!";
    }
}
class Aviao extends Veiculo
{
    public function mover(): string
    {
        return "Voa!";
    }
}

$veiculos = [new Carro2(), new Bicicleta(), new Aviao()];
foreach ($veiculos as $veiculo) {
    echo $veiculo->mover() . PHP_EOL;
}
