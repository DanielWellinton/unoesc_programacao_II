<?php
class Relatorio
{
    public function __call(string $nomeMetodo, array $argumentos): void
    {
        if ($nomeMetodo == "gerar") {
            foreach ($argumentos as $argumento) {
                if ($argumento == 0) {
                    echo "Iniciando relatório.\n";
                } else if ($argumento == 1) {
                    echo "Finalizado relatório.\n";
                }
            }
        }
    }
}
$relatorio = new Relatorio();
$relatorio->gerar(0);
$relatorio->gerar(1);
