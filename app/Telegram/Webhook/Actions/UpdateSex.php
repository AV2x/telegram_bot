<?php

namespace App\Telegram\Webhook\Actions;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Cache;

class UpdateSex extends Webhook
{
    public function run()
    {
        $data = $this->data;
        User::where('telegram_id', $this->chat_id)->update([
            'sex' => $data->sex,
            'edit_type' => null,
        ]);
        $user = User::where('telegram_id', $this->chat_id)->first();
        $text = (string)view('telegram.edit_profile', ['user' => $user]);
        InlineButton::add('Пол', 'UpdateProfile', ['sex' => true], 1);
        InlineButton::add('Возраст', 'UpdateProfile', ['age' => true], 1);
        InlineButton::add('Город', 'UpdateProfile', ['city' => true], 2);
        Telegram::answerCallbackQuery($this->chat_id, 'Пол выбран', $this->callback_query_id)->send();
        Telegram::buttons($this->chat_id, $text, InlineButton::$buttons)->send();
    }
}
