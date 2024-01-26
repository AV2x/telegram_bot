<?php

namespace App\Telegram\Helpers;

class InlineQueryResultArticle
{
    public static $result = [];

    public static function add(mixed $id, string $title, string $description, array $input_message, string $image_url = null, int $image_height = null, int $image_with = null)
    {
        self::$result[] = [
            'type' => 'article',
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'input_message_content' => $input_message,
        ];
        if($image_url)
        {
            self::$result[count(self::$result) - 1]['thumbnail_url'] = $image_url;
        }
        if($image_height)
        {
            self::$result[count(self::$result) - 1]['thumbnail_height'] = $image_height;
        }
        if($image_with)
        {
            self::$result[count(self::$result) - 1]['thumbnail_width'] = $image_with;
        }
    }
}
