<?php

namespace App\Telegram\Webhook\Actions;

use App\Facades\Telegram;
use App\Models\User;
use App\Telegram\Helpers\InlineButton;
use App\Telegram\Helpers\KeyboardButton;
use App\Telegram\Webhook\Webhook;

class UpdateProfile extends Webhook
{
    public function run()
    {
        $data = json_decode($this->request->input('callback_query')['data']);

        if($data->button_number == 2)
        {
            User::where('telegram_id', $this->chat_id)->update(['edit_type' => 2]);
            $text = 'Напишите сколько вам лет:'.PHP_EOL.'Отмена: /cancel_edit';
            Telegram::message($this->chat_id, $text)->send();
        }
        elseif($data->button_number == 1)
        {
            User::where('telegram_id', $this->chat_id)->update(['edit_type' => 1]);
            InlineButton::add('🙎🏼‍♂️Мужской', 'UpdateSex', ['sex' => 1]);
            InlineButton::add('🙎🏽‍♀️Женский', 'UpdateSex', ['sex' => 2]);
            Telegram::buttons($this->chat_id, 'Выберите пол', InlineButton::$buttons)->send();
        }
        elseif ($data->button_number == 3)
        {
            User::where('telegram_id', $this->chat_id)->update(['edit_type' => 3]);
            KeyboardButton::add('Санкт-Петербург', 1);
            KeyboardButton::add('Москва', 2);
            KeyboardButton::add('Воронеж', 3);
            Telegram::buttons($this->chat_id, 'Выберите город:'.PHP_EOL.'Отмена: /cancel_edit', KeyboardButton::$buttons)->send();
        }
    }
}
