<?php

namespace App\Listeners;

use App\Events\NewOrderEvent;
use App\Events\StatusOrderEvent;
use App\Facades\Telegram;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStatusOrderNotification
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
    public function handle(StatusOrderEvent $event): void
    {
        $text = (string)view('telegram.new_order', ['order' => $event->order]);
        Telegram::editMessage(env('TELEGRAM_PUBLIC_ID'), $text, $event->order->public_message_id)->send();

        $chatText = 'Менеджер: '.$event->order->manager->name.' обновил статус на '.$event->order->status->name;
        dd(Telegram::message(env('TELEGRAM_GROUP_ID'), $chatText, $event->order->chat_message_id)->send());
    }
}
