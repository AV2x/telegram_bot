<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['name' => 'Новый заказ']);
        Status::create(['name' => 'В обработке']);
        Status::create(['name' => 'Передан курьеру']);
        Status::create(['name' => 'Доставлен']);
        Status::create(['name' => 'Закрыт']);
    }
}
