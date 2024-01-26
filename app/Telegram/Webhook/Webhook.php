<?php

namespace App\Telegram\Webhook;

use App\Facades\Telegram;
use App\Telegram\Bot\Factory;
use Illuminate\Http\Request;

class Webhook
{
    protected Request $request;
    protected $chat_id;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->getChatId();
    }

    public function run()
    {
       return Telegram::message(5431617179, 'Не удалось обработать сообщение!')->send();
    }

    final public function getChatId()
    {
        if($this->request->input('callback_query'))
        {
            $this->chat_id = $this->request->input('callback_query')['from']['id'];
        }
        elseif($this->request->input('message'))
        {
            $this->chat_id = $this->request->input('message')['from']['id'];
        }
    }
}
