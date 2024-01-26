<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Filesystem\Filesystem;

class ResetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет и накидывает новые данные';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public');
        Artisan::call('migrate:fresh --seed');
        $output = '';
        exec('chmod -R 777 /var/www/crm/storage', $output);
    }
}
