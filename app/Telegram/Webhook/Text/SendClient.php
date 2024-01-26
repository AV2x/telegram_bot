<?php

namespace App\Telegram\Webhook\Text;

use App\Facades\Telegram;
use App\Models\Order;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Webhook\Webhook;

class SendClient extends Webhook
{
    public function run()
    {
        $order = Order::where('chat_message_id', $this->request->input('message')['reply_to_message']['message_id'])->first();
        $text = 'Менеджер: '.$order->manager->name.' отправил(а) вам сообщение'.PHP_EOL.$this->request->input('message')['text'];
        Telegram::message(5431617179, $text)->send();
    }
}
