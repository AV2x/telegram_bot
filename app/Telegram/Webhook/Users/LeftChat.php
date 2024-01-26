<?php

namespace App\Telegram\Webhook\Users;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Webhook\Webhook;

class LeftChat extends Webhook
{
    public function run()
    {
        $chat_id = $this->request->input('message')['left_chat_participant']['id'];
        User::where('telegram_id', $chat_id)
            ->update(['fired' => 1]);
        Telegram::message($chat_id, 'Вас уволили за пьянство')->send();
    }
}
