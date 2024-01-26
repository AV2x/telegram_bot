<?php

namespace App\Telegram\Webhook\Commands;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Webhook\Webhook;

class EditProfile extends Webhook
{
    public function run()
    {
        $name = $this->request->input('message')['from']['first_name'];
        InlineButton::add('👤 Пол','EditUser', ['sex' => 1], 1);
        InlineButton::add('🦉 Возраст','EditUser', ['age' => 1], 1);
        InlineButton::add('🕸 Город','EditUser', ['city' => 1], 2);
        InlineButton::add('🏴‍☠️ Страна','EditUser', ['country' => 1], 3);
        return Telegram::buttons(5431617179, 'Редактирование профиля '.$name, InlineButton::$buttons)->send();
    }
}
