<?php

namespace App\Telegram\Webhook\Text;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Text extends Webhook
{
    public function run()
    {
        $user = User::where('telegram_id', $this->chat_id)->first();
        if($user->edit_type == 2)
        {
            App::make(EditAge::class)->run();
        }
        elseif ($user->edit_type == 3)
        {
            App::make(EditCity::class)->run();
        }

        if($this->request->input('message')['text'] == 'Магазин 1')
        {
            App::make(Products::class)->run();
        }
    }
}
