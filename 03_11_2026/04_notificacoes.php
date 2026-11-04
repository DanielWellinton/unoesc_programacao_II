<?php

interface Notificacao
{
    public function enviar(string $mensagem, string $destinatario): string;
}

class EmailNotificacao implements Notificacao
{
    public function enviar(string $mensagem, string $destinatario): string
    {
        return "E-mail para {$destinatario}: {$mensagem}";
    }
}

class SmsNotificacao implements Notificacao
{
    public function enviar(string $mensagem, string $destinatario): string
    {
        return "Sms para {$destinatario}: {$mensagem}";
    }
}

class PushNotificacao implements Notificacao
{
    public function enviar(string $mensagem, string $destinatario): string
    {
        return "Push para {$destinatario}: {$mensagem}";
    }
}

$notificacoes = [new EmailNotificacao(), new SmsNotificacao(), new PushNotificacao()];
foreach ($notificacoes as $notificacao) {
    echo $notificacao->enviar("Bem-vindo ao sistema!", "Leandro") . PHP_EOL;
}
