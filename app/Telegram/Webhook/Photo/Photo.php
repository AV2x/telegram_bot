<?php

namespace App\Telegram\Webhook\Photo;

use App\Facades\Telegram;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Storage;

class Photo extends Webhook
{
    public function run()
    {
        $chat_id = $this->request->input('message')['from']['id'];
        $pictures = $this->request->input('message')['photo'];
        $file = Telegram::getFile($pictures[count($pictures) - 1]['file_id'])->send();
        $file_path = $file['result']['file_path'];
        $ext = explode('.', $file_path);
        $ext = $ext[count($ext) - 1];
        $file_name = uniqid().'.'.$ext;
        Storage::putFileAs('public/telegram/images', env('TELEGRAM_FILE_PATH').env('TELEGRAM_BOT_TOKEN').'/'.$file_path, $file_name);
        Telegram::message($chat_id, 'Спасибо за собачку!')->send();
    }
}
