<?php

namespace App\Telegram\Webhook\Actions;

use App\Facades\Telegram;
use App\Models\Order;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Helpers\KeyboardButton;
use App\Telegram\Webhook\Webhook;

class OrderReady extends Webhook
{
    public function run()
    {
        Order::where('id', $this->data->order_id)->update(['status_id' => 3]);
        $order = Order::where('id', $this->data->order_id)->with(['products' => function($query){
            $query->select('products.*', 'order_products.counts as order_counts');
            $query->with('category');
            $query->with('images');
        }])->with(['status', 'manager'])->first();
        $text = (string)view('telegram.new_order', ['order' => $order]);
        Telegram::editMessage(env('TELEGRAM_GROUP_ID'), $text, $order->message_id)->send();
        Telegram::editMessage($this->chat_id, $text, $this->message_id)->send();
        Telegram::answerCallbackQuery($this->chat_id, 'Заказ отправлен', $this->callback_query_id)->send();
    }
}
