<?php

namespace App\Telegram\Webhook\Inline;

use App\Facades\Telegram;
use App\Models\Product;
use App\Telegram\Helpers\InlineQueryResultArticle;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Answer extends Webhook
{
    public function run()
    {
        $id = $this->request->input('inline_query')['id'];
        $query = $this->request->input('inline_query')['query'];

        $products = new Product();
        if($query)
        {
            $products = $products->where('name', 'like', '%'.$query.'%');
        }
        $products = $products->get();
        foreach ($products as $product)
        {
            $product_image = 'https://telegram.povyshev-course.com/storage/products/'.$product->images[0]->file_name;
            $input_message = [
                'message_text' => $product->name,
            ];
            InlineQueryResultArticle::add($product->id, $product->name, 'Цена: '.$product->price, $input_message, $product_image, 500, 436);
        }

       Telegram::answerInlineQuery($id, InlineQueryResultArticle::$result)->send();
    }
}
