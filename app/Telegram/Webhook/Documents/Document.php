<?php

namespace App\Telegram\Webhook\Documents;

use App\Facades\Telegram;
use App\Telegram\Webhook\Webhook;
use Illuminate\Support\Facades\Storage;

class Document extends Webhook
{
    public function run()
    {
        $chat_id = $this->request->input('message')['from']['id'];
        $doc = $this->request->input('message')['document'];
        $file = Telegram::getFile($doc['file_id'])->send();
        $file_path = $file['result']['file_path'];
        $ext = explode('.', $file_path);
        $ext = $ext[count($ext) - 1];
        $file_name = uniqid().'.'.$ext;
        Storage::putFileAs('public/telegram/documents', env('TELEGRAM_FILE_PATH').env('TELEGRAM_BOT_TOKEN').'/'.$file_path, $file_name);
        Telegram::message($chat_id, 'Документ сохранен')->send();
    }
}
