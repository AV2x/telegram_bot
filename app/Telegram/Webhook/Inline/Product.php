<?php

namespace App\Telegram\Webhook\Inline;

use App\Facades\Telegram;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Cache;

class Product extends Webhook
{
    public function run()
    {
        $product = \App\Models\Product::where('name', $this->request->input('message')['text'])->first();
        $text = $product->name.PHP_EOL.'Цена: '.$product->price;
        InlineButton::link('Купить '.$product->price.' ₽', 'https://povyshev-course.com/test/payment?product_id='.$product->id);
        InlineButton::add('Написать', 'Order', ['product_id' => $product->id]);
        $images = $product->images->map(fn($item) => 'https://telegram.povyshev-course.com/storage/products/'.$item->file_name)->toArray();
        Cache::forever('webhook-data', Telegram::album($this->chat_id,$images)->send());
        Telegram::buttons($this->chat_id, $text, InlineButton::$buttons)->send();
    }
}
