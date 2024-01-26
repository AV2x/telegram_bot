<?php

namespace App\Telegram\Webhook\Text;

use App\Facades\Telegram;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Cache;

class Text extends Webhook
{
    public function run()
    {
        Telegram::message($this->chat_id, 'Ваше сообщение принято')->send();
    }
}
