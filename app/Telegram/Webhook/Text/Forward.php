<?php

namespace App\Telegram\Webhook\Text;

use App\Facades\Telegram;
use App\Models\Order;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Webhook\Webhook;

class Forward extends Webhook
{
    public function run()
    {
        Order::where('public_message_id', $this->request->input('message')['forward_from_message_id'])
            ->update(['chat_message_id' => $this->message_id]);

    }
}
