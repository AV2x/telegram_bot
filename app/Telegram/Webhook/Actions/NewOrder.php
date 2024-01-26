<?php

namespace App\Telegram\Webhook\Actions;

use App\Facades\Telegram;
use App\Models\Product;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Webhook\Webhook;
use App\Models\Order;

class NewOrder extends Webhook
{
    private $data;
    public function run()
    {
       $this->data = json_decode($this->request->input('callback_query')['data']);
       if($this->data->button_number == 3)
       {
           return $this->sendDate();
       }
       $product_id = $this->data->product_id;
       if($this->data->button_number == 1)
       {
          $date = date('Y-m-d');
       }
       elseif ($this->data->button_number == 2)
       {
           $date = (new \DateTime())->modify('+1 days')->format('Y-m-d');
       }
       Order::create([
           'telegram_user_id' => $this->chat_id,
           'product_id' => $product_id,
           'date' => $date,
           'status_id' => 1
       ]);
       $product = Product::find($product_id);
        $text = (string)view('telegram.afterOrder', ['product' => $product]);
       Telegram::editMessage($this->chat_id, $text, $this->request->input('callback_query')['message']['message_id'])->send();

    }

    public function sendDate()
    {
        $product = Product::find($this->data->product_id);
        $text = (string)view('telegram.product', ['product' => $product]);
        $data = [
            'product_id' => $product->id,
        ];
        InlineButton::add('17 Января', 'NewOrder2', $data, 1);
        InlineButton::add('18 Января', 'NewOrder2', $data, 2);
        InlineButton::add('19 Января', 'NewOrder2', $data, 3);
        InlineButton::add('20 Января', 'NewOrder2', $data, 4);

       Telegram::editButtons($this->chat_id, $text, InlineButton::$buttons, $this->request->input('callback_query')['message']['message_id'])->send();
    }
}
