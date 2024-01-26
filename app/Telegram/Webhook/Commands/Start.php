<?php

namespace App\Telegram\Webhook\Commands;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Hash;

class Start extends Webhook
{
    public function run()
    {
        $token = explode(' ', $this->text)[1];
      User::where('telegram_token', $token)->update([
          'telegram_id' => $this->chat_id,
          'telegram_username' => $this->request->input('message')['from']['username']
      ]);
      return Telegram::message($this->chat_id, 'Привет! Спасибо что подписался')->send();
    }
}
