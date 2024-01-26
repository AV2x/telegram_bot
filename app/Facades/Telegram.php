<?php

namespace App\Facades;

use App\Telegram\Bot\Bot;
use App\Telegram\Bot\Chat;
use App\Telegram\Bot\File;
use App\Telegram\Bot\Inline;
use App\Telegram\Bot\Message;
use App\Telegram\Bot\Payment;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Message message(mixed $chat_id, string $text, $reply_id = null)
 * @method static Message editMessage(mixed $chat_id, string $text, int $message_id)
 * @method static Message buttons(mixed $chat_id, string $text, array $buttons)
 * @method static Message editButtons(mixed $chat_id, string $text, array $buttons, int $message_id)
 * @method static Message answerCallbackQuery(mixed $chat_id, string $text, $callback_query_id, $show_alert = false)
 *
 * @method static File document(mixed $chat_id, $file, string $filename, $reply_id = null)
 * @method static File getFile(string $file_id)
 * @method static File photo(mixed $chat_id, $file, $reply_id = null)
 * @method static File album(mixed $chat_id, array $file_url, $reply_id = null)
 *
 * @method static Chat banChatMember(mixed $chat_id, $user_id)
 *
 * @method static Inline answerInlineQuery(string $inline_query_id, array $result)
 * @method static Payment payment(mixed $chat_id, string $title, string $description, array $payload, array $prices)
 * @method static Payment answerPreCheckoutQuery(mixed $pre_checkout_query_id, bool $ok, string $error_message = null)
 *
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
