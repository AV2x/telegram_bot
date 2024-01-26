<?php

namespace App\Telegram\Webhook\Users;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Webhook\Webhook;

class NewChat extends Webhook
{
    public function run()
    {
//        $chat_id = $this->request->input('message')['new_chat_participant']['id'];
//        $fired =  User::where('telegram_id', $chat_id)->value('fired');
//        if($fired == 1)
//        {
//            Telegram::banChatMember($this->request->input('message')['chat']['id'], $chat_id)->send();
//        }
        $chat_id = $this->request->input('message')['new_chat_participant']['id'];
        User::where('telegram_id', $chat_id)
            ->update(['fired' => 0]);
        InlineButton::link('Перейти', 'https://telegram.povyshev-course.com/home');
        Telegram::buttons($chat_id, 'Вы получили доступ к дашборду', InlineButton::$buttons)->send();
    }
}
