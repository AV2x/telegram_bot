<?php

namespace App\Telegram\Bot;

use Illuminate\Support\Facades\Http;

class Payment extends Bot
{
    protected $data;
    protected $method;

    public function payment(mixed $chat_id, string $title, string $description, array $payload, array $prices)
    {
        $this->method = 'sendInvoice';
        $this->data = [
            'chat_id' => $chat_id,
            'title' => $title,
            'description' => $description,
            'payload' => json_encode($payload),
            'provider_token' => env('TELEGRAM_PROVIDER_TOKEN'),
            'currency' => 'RUB',
            'prices' => $prices
        ];
        return $this;
    }

    public function answerPreCheckoutQuery(mixed $pre_checkout_query_id, bool $ok, string $error_message = null)
    {
        $this->method = 'answerPreCheckoutQuery';
        $this->data = [
            'pre_checkout_query_id' => $pre_checkout_query_id,
            'ok' => $ok,
            'error_message' => $error_message
        ];
        return $this;
    }

}
