<?php

namespace App\Telegram\Webhook\Text;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Webhook\Webhook;

class EditAge extends Webhook
{
    public function run()
    {
        User::where('telegram_id', $this->chat_id)->update([
            'age' => $this->text,
            'edit_type' => null,
        ]);

        $user = User::where('telegram_id', $this->chat_id)->first();
        $text = (string)view('telegram.edit_profile', ['user' => $user]);
        InlineButton::add('Пол', 'UpdateProfile', ['sex' => true], 1);
        InlineButton::add('Возраст', 'UpdateProfile', ['age' => true], 1);
        InlineButton::add('Город', 'UpdateProfile', ['city' => true], 2);
        Telegram::buttons($this->chat_id, $text, InlineButton::$buttons)->send();
    }
}
