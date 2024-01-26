<?php

namespace App\Telegram\Webhook\Commands;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Webhook\Webhook;

class Start extends Webhook
{
    public function run()
    {
      $token = explode('/start ', $this->request->input('message')['text'])[1];
      User::where('telegram_token', $token)->update([
          'telegram_id' => $this->request->input('message')['from']['id'],
          'telegram_username' =>$this->request->input('message')['from']['username'],
      ]);
      return Telegram::message($this->chat_id, 'Привет! Спасибо что подписался')->send();
    }
}
