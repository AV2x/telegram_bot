<?php

namespace App\Telegram\Bot;

class Factory
{

    private Message $message;
    private File $file;
    private Chat $chat;
    private Inline $inline;
    private Payment $payment;

    public function __construct()
    {
        $this->message = new Message();
        $this->file = new File();
        $this->chat = new Chat();
        $this->inline = new Inline();
        $this->payment = new Payment();
    }

    public function __call(string $name, array $arguments)
    {

        foreach ($this as $key => $prop)
        {
            if(method_exists($this->$key, $name))
            {
                return call_user_func_array([$this->$key, $name], $arguments);
            }
        }
        throw new \Exception('Такого метода '.$name.' не нашлось');
    }
}
