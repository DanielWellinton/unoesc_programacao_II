<?php

class Calculadora {
    private int $operacao;
    private float $parametro1;
    private float $parametro2;
    private float $resultado;

    /**
     * @param int $operacao
     * 1 - Adição
     * 2 - Subtração
     * 3 - Multiplicação
     * 4 - Divisão
     */
    public function operacaoMatematica(int $operacao, float $parametro1, float $parametro2): float
    {
        $this->operacao = $operacao;
        $this->parametro1 = $parametro1;
        $this->parametro2 = $parametro2;

        switch ($this->operacao) {
            case 1:
                $this->resultado = $this->parametro1 + $this->parametro2;
                break;
            case 2:
                $this->resultado = $this->parametro1 - $this->parametro2;
                break;
            case 3:
                $this->resultado = $this->parametro1 * $this->parametro2;
                break;
            case 4:
                if ($this->parametro2 == 0) {
                    throw new InvalidArgumentException("Divisão por zero não é permitida.");
                }
                $this->resultado = $this->parametro1 / $this->parametro2;
                break;
            default:
                throw new InvalidArgumentException("Operação inválida. Informe um valor de 1 a 4.");
        }

        return $this->resultado;
    }

    public function getResultado(): float
    {
        return $this->resultado;
    }
}