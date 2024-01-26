<?php

namespace App\Telegram\Helpers;

class InlineButton
{
    private static $button_number = 1;
    public static $buttons = [
        'inline_keyboard' => [

        ]
    ];


    public static function add(mixed $text, string $action, array $data, int $row = 1)
    {
        $data['action'] = $action;
        $data['button_number'] = self::$button_number;
        self::$button_number++;
        self::$buttons['inline_keyboard'][$row -1 ][] = [
            'text' => $text,
            'callback_data' => json_encode($data)
        ];
    }

    public static function link(mixed $text, string $url, int $row = 1)
    {
        self::$buttons['inline_keyboard'][$row -1 ][] = [
            'text' => $text,
            'url' => $url
        ];
    }

    public static function inlineQuery(string $text, string $query, int $row = 1)
    {
        self::$buttons['inline_keyboard'][$row -1 ][] = [
            'text' => $text,
            'switch_inline_query_current_chat' => $query
        ];
    }

    public static function webApp(mixed $text, string $url, int $row = 1)
    {
        self::$buttons['inline_keyboard'][$row -1 ][] = [
            'text' => $text,
            'web_app' => [
                'url' => $url
                ]
        ];
    }
}
