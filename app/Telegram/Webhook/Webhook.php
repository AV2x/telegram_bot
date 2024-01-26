<?php

namespace App\Telegram\Webhook;

use App\Facades\Telegram;
use App\Telegram\Bot\Factory;
use Illuminate\Http\Request;

class Webhook
{
    protected Request $request;
    protected $chat_id;
    protected $message_id;
    protected $data;
    protected $text;
    protected $callback_query_id;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->getChatId();
        $this->getMessageId();
        $this->getData();
        $this->getText();
        $this->getQueryId();
    }

    public function run()
    {
       return Telegram::message(5431617179, 'Не удалось обработать сообщение!')->send();
    }

    final public function getChatId()
    {
        if($this->request->input('callback_query'))
        {
            $this->chat_id = $this->request->input('callback_query')['from']['id'];
        }
        elseif($this->request->input('message'))
        {
            $this->chat_id = $this->request->input('message')['from']['id'];
        }
    }
    final public function getMessageId()
    {
        if($this->request->input('callback_query'))
        {
            $this->message_id = $this->request->input('callback_query')['message']['message_id'];
        }
        elseif($this->request->input('message'))
        {
            $this->message_id = $this->request->input('message')['message_id'];
        }
    }

    final public function getData()
    {
        if($this->request->input('callback_query'))
        {
            $this->data = json_decode($this->request->input('callback_query')['data']);
        }
    }
    final public function getText()
    {
        if(isset($this->request->input('message')['text']))
        {
            $this->text = $this->request->input('message')['text'];
        }
    }
    final public function getQueryId()
    {
        if($this->request->input('callback_query'))
        {
            $this->callback_query_id = $this->request->input('callback_query')['id'];
        }
    }

}
