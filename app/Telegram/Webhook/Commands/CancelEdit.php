<?php

namespace App\Telegram\Webhook\Commands;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Helpers\KeyboardButton;
use App\Telegram\Webhook\Webhook;

class CancelEdit extends Webhook
{
    public function run()
    {
        User::where('telegram_id', $this->chat_id)->update([
            'edit_type' => null,
        ]);
        KeyboardButton::remove();
        Telegram::buttons($this->chat_id, 'Редактирование отменено', KeyboardButton::$buttons)->send();
    }
}
