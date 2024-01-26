<?php

namespace App\Telegram\Bot;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Bot
{
    protected $data;
    protected $method;

    public function send()
    {
       return Http::post('https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/'.$this->method,
            $this->data)->json();
    }
}
