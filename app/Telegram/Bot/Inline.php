<?php

namespace App\Telegram\Bot;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Inline extends Bot
{
    protected $data;
    protected $method;

    public function answerInlineQuery(string $inline_query_id, array $result)
    {
        $this->method = 'answerInlineQuery';
        $this->data = [
            'inline_query_id' => $inline_query_id,
            'results' => $result,
            'cache_time' => 0
        ];
        return $this;
    }

}

