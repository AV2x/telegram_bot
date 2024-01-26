<?php

namespace App\Telegram\Bot;

use Illuminate\Support\Facades\Http;

class Message extends Bot
{
    protected $data;
    protected $method;

    public function message(mixed $chat_id, string $text, $reply_id = null)
    {
        $this->method = 'sendMessage';
        $this->data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'link_preview_options' => [
                'is_disabled' => true
            ],

        ];
        if($reply_id)
        {
            $this->data['reply_parameters'] = [
                'message_id' => $reply_id,
            ];
        }
        return $this;
    }

    public function editMessage(mixed $chat_id, string $text, int $message_id)
    {
        $this->method = 'editMessageText';
        $this->data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'message_id' => $message_id
        ];
        return $this;
    }
    public function buttons(mixed $chat_id, string $text, array $buttons, $reply_id = null)
    {
        $this->method = 'sendMessage';
        $this->data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'reply_markup' => $buttons,
        ];
        if($reply_id)
        {
            $this->data['reply_parameters'] = [
                'message_id' => $reply_id
            ];
        }
        return $this;
    }

    public function editButtons(mixed $chat_id, string $text, array $buttons, int $message_id)
    {
        $this->method = 'editMessageText';
        $this->data = [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'html',
            'reply_markup' => $buttons,
            'message_id' => $message_id
        ];
        return $this;
    }
}
