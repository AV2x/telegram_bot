<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $managersId[] = User::where('role_id', 3)->get()->map(fn($user) => $user->id);
        $managersId = $managersId[0];
        $productsId[] = Product::get()->map(fn($product) => $product->id);
        $productsId = $productsId[0];
        for ($i = 1; $i <= 1000; $i++)
        {
            $phone = '+79';
            for ($p = 0; $p <= 8; $p++)
                {
                    $phone = $phone.rand(1, 9);
                }
            $created_at = fake()->dateTimeBetween('-1 month', 'now');
            $order = Order::create([
                'status_id' => Status::first()->id,
                'user_id' => rand($managersId[0], $managersId[count($managersId) - 1]),
                'client_name' => fake()->name,
                'client_email' => fake()->unique()->safeEmail(),
                'client_telephone' => $phone,
                'created_at' => $created_at,
                'updated_at' => $created_at
            ]);
            $order->products()->attach([ rand($productsId[0], $productsId[count($productsId) -1])  => ['counts' => rand(1, 2)]]);
        }
    }

}
