<?php

namespace App\Telegram\Webhook;

use App\Facades\Telegram;
use App\Telegram\Bot\Inline;
use App\Telegram\Webhook\Commands\CancelEdit;
use App\Telegram\Webhook\Commands\EditProfile;
use App\Telegram\Webhook\Commands\Shops;
use App\Telegram\Webhook\Commands\Start;
use App\Telegram\Webhook\Documents\Document;
use App\Telegram\Webhook\Inline\Answer;
use App\Telegram\Webhook\Inline\Product;
use App\Telegram\Webhook\Photo\Photo;
use App\Telegram\Webhook\Text\Forward;
use App\Telegram\Webhook\Text\SendClient;
use App\Telegram\Webhook\Text\Text;
use App\Telegram\Webhook\Users\LeftChat;
use App\Telegram\Webhook\Users\NewChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Realization
{

    protected const Commands = [
        '/start' => Start::class,
        '/edit_profile' => EditProfile::class,
        '/cancel_edit' => CancelEdit::class,
        '/shops' => Shops::class
    ];

    public function take(Request $request)
    {
        if(isset($request->input('message')['entities'][0]['type']) && $request->input('message')['entities'][0]['type'] == 'bot_command')
        {
            $command_name = explode(' ', $request->input('message')['text'])[0];
            return self::Commands[$command_name];
        }
        elseif($request->input('callback_query'))
        {
            $data = json_decode($request->input('callback_query')['data']);
            return '\App\Telegram\Webhook\Actions\\'.$data->action;
        }
        elseif(isset($request->input('message')['photo']))
        {
            return Photo::class;
        }
        elseif(isset($request->input('message')['document']))
        {
            return Document::class;
        }
        elseif (isset($request->input('message')['forward_from_message_id']) )
        {
            return Forward::class;
        }
        elseif (isset($request->input('message')['reply_to_message']))
        {
            return SendClient::class;
        }

        elseif($request->input('message'))
        {
            return Text::class;
        }

        return false;
    }
}
