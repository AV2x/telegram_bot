<?php

namespace App\Telegram\Bot;

use Illuminate\Support\Facades\Http;

class File extends Bot
{
    protected $data;
    protected $method;
    private $file;
    private $filename;
    private $type;

    public function document(mixed $chat_id, $file, string $filename, $reply_id = null)
    {
        $this->method = 'sendDocument';
        $this->type = 'document';
        $this->file = $file;
        $this->filename = $filename;
        $this->data = [
            'chat_id' => $chat_id,
        ];
        if($reply_id)
        {
            $this->data['reply_parameters'] = [
                'message_id' => $reply_id
            ];
        }
        return $this;
    }

    public function getFile($file_id)
    {
        $this->method = 'getFile';
        $this->data = [
            'file_id' => $file_id,
        ];
        return $this;
    }

    public function photo(mixed $chat_id, $file, string $filename, $reply_id = null)
    {
        $this->method = 'sendPhoto';
        $this->type = 'photo';
        $this->file = $file;
        $this->filename = $filename;
        $this->data = [
            'chat_id' => $chat_id,
        ];
        if($reply_id)
        {
            $this->data['reply_parameters'] = [
                'message_id' => $reply_id
            ];
        }
        return $this;
    }

    public function album(mixed $chat_id, array $file_url, $reply_id = null)
    {
        $this->method = 'sendMediaGroup';
        $this->type = 'media';
        foreach ($file_url as $key => $url)
        {
            $this->data['media'][] = [
              'media' => $url,
              'type' => 'photo'
            ];
        }
        $this->data['chat_id'] = $chat_id;
        if($reply_id)
        {
            $this->data['reply_parameters'] = [
                'message_id' => $reply_id
            ];
        }
        return $this;
    }

    public function send()
    {
        if($this->file)
        {
            return Http::attach($this->type, $this->file, $this->filename)->post('https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/'.$this->method,
                $this->data)->json();
        }
        return Http::post('https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/'.$this->method,
            $this->data)->json();
    }
}
