<?php

namespace App\Console\Commands;

use App\Facades\Telegram;
use App\Models\User;
use Illuminate\Console\Command;

class FiredUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fired:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Выкидывание из тг каналов уволенных пользователей';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('fired', 1)->get();
        foreach ($users as $user)
        {
            Telegram::banChatMember(env('TELEGRAM_GROUP_ID'), $user->telegram_id)->send();
        }
    }
}
