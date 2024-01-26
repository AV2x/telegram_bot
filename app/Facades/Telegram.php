<?php

namespace App\Facades;

use App\Telegram\Bot\Bot;
use App\Telegram\Bot\File;
use App\Telegram\Bot\Message;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Message message(mixed $chat_id, string $text, $reply_id = null)
 * @method static Message editMessage(mixed $chat_id, string $text, int $message_id)
 * @method static Message buttons(mixed $chat_id, string $text, array $buttons)
 * @method static Message editButtons(mixed $chat_id, string $text, array $buttons, int $message_id)
 *
 * @method static File document(mixed $chat_id, $file, string $filename, $reply_id = null)
 * @method static File getFile(string $file_id)
 * @method static File photo(mixed $chat_id, $file, $reply_id = null)
 * @method static File album(mixed $chat_id, array $file_url, $reply_id = null)
 * @method Bot send()
 */

class Telegram extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Telegram::class;
    }
}
