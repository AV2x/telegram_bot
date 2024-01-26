<?php


namespace App\Telegram\Webhook\Text;

use App\Facades\Telegram;
use App\Models\Order;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Helpers\KeyboardButton;
use App\Telegram\Webhook\Webhook;

class Products extends Webhook
{
    public function run()
    {
        KeyboardButton::remove();
        Telegram::buttons($this->chat_id, 'Магазин выбран', KeyboardButton::$buttons)->send();

        InlineButton::webApp('Выбрать', 'https://telegram.povyshev-course.com/webapp/products');
        Telegram::buttons($this->chat_id, 'Выберите товар', InlineButton::$buttons)->send();
    }
}

