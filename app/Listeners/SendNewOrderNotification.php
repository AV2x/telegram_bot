<?php

namespace App\Listeners;

use App\Events\NewOrderEvent;
use App\Facades\Telegram;
use App\Telegram\Helpers\InlineButton;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNewOrderNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewOrderEvent $event): void
    {
        $text = (string)view('telegram.new_order', ['order' => $event->order]);
        $telegram = Telegram::message(env('TELEGRAM_PUBLIC_ID'), $text)->send();
        $event->order->public_message_id = $telegram['result']['message_id'];
        $event->order->save();

        InlineButton::add('Взять заказ', 'OrderManager', ['order_id' => $event->order->id]);
        Telegram::buttons($event->order->manager->telegram_id, $text, InlineButton::$buttons)->send();
    }
}
