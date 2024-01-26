<?php

namespace App\Telegram\Webhook\Commands;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Helpers\KeyboardButton;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Hash;

class Shops extends Webhook
{
    public function run()
    {
        KeyboardButton::add('Магазин 1');
        KeyboardButton::add('Магазин 2', 2);
        KeyboardButton::add('Магазин 3', 3);
        Telegram::buttons($this->chat_id, 'Выберите магазин', KeyboardButton::$buttons)->send();
    }
}
