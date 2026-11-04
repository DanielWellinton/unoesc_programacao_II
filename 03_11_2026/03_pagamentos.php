<?php
abstract class Pagamento
{
    public function __construct(protected float $valor) {}
    abstract public function processarPagamento(): string;
    protected function valorFormatado(): string
    {
        return number_format($this->valor, 2, ',', '.');
    }
}
class CartaoCredito extends Pagamento
{
    public function processarPagamento(): string
    {
        return "Cartão: pagamento de R$ " . $this->valorFormatado() . " autorizado.";
    }
}
class Pix extends Pagamento
{
    public function processarPagamento(): string
    {
        return "PIX: transferência de R$ " . $this->valorFormatado() . " realizada.";
    }
}
class Boleto extends Pagamento
{
    public function processarPagamento(): string
    {
        return "Boleto: cobrança de R$ " . $this->valorFormatado() . " gerada.";
    }
}
$pagamentos = [new CartaoCredito(150.00), new Pix(75.50), new Boleto(320.00)];
foreach ($pagamentos as $pagamento) {
    echo $pagamento->processarPagamento() . PHP_EOL;
}
