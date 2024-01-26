<?php

namespace App\Telegram\Webhook\Actions;

use App\Facades\Telegram;
use App\Models\Order;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Helpers\KeyboardButton;
use App\Telegram\Webhook\Webhook;

class OrderManager extends Webhook
{
    public function run()
    {
        Order::where('id', $this->data->order_id)->update(['status_id' => 2]);
        $order = Order::where('id', $this->data->order_id)->with(['products' => function($query){
            $query->select('products.*', 'order_products.counts as order_counts');
            $query->with('category');
            $query->with('images');
        }])->with(['status', 'manager'])->first();
        $text = (string)view('telegram.new_order', ['order' => $order]);
        Telegram::editMessage(env('TELEGRAM_GROUP_ID'), $text, $order->message_id)->send();
        InlineButton::add('Заказ обработан', 'OrderReady', ['order_id' => $order->id]);
        Telegram::editButtons($this->chat_id, $text, InlineButton::$buttons, $this->message_id)->send();
        Telegram::answerCallbackQuery($this->chat_id, 'Заказ в обработке', $this->callback_query_id)->send();
    }
}
