<?php

namespace App\Telegram\Bot;

use Illuminate\Support\Facades\Http;

class Chat extends Bot
{
    protected $data;
    protected $method;


    public function banChatMember(mixed $chat_id, $user_id)
    {
        $this->method = 'banChatMember';
        $this->data = [
            'chat_id' => $chat_id,
            'user_id' => $user_id
        ];

        return $this;
    }

}

