<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\Storage\UserStorage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $storage;
    public function __construct(UserStorage $storage)
    {
        $this->storage = $storage;
    }

    public function run(): void
    {
        $this->createRoot();
        $this->createAdmin();
        $this->createShareholder();
        $this->createManagers();
    }

    protected function createManagers()
    {
        $file_name = 'anastasia.jpg';
        $user = User::create([
            'name' => 'Анастасия Кудрявцева',
            'email' => 'anastasia@gmail.com',
            'password' => Hash::make('1234567'),
            'role_id' => 3,
            'avatar' => $file_name
        ]);
        $this->storage->saveUrl($user, 'http://185.154.53.66/storage/avatars/'.$file_name, $file_name);
        $file_name = 'maria.jpg';
        $user = User::create([
            'name' => 'Мария Захарова',
            'email' => 'maria@gmail.com',
            'password' => Hash::make('1234567'),
            'role_id' => 3,
            'avatar' => $file_name
        ]);
        $this->storage->saveUrl($user, 'http://185.154.53.66/storage/avatars/'.$file_name, $file_name);
        $file_name = 'anna.jpg';
        $user = User::create([
            'name' => 'Анна Загвоздкина',
            'email' => 'anna@gmail.com',
            'password' => Hash::make('1234567'),
            'role_id' => 3,
            'avatar' => $file_name
        ]);
        $this->storage->saveUrl($user, 'http://185.154.53.66/storage/avatars/'.$file_name, $file_name);
        $file_name = 'olga.jpg';
        $user = User::create([
            'name' => 'Ольга Куриленко',
            'email' => 'olga@gmail.com',
            'password' => Hash::make('1234567'),
            'role_id' => 3,
            'avatar' => $file_name
        ]);
        $this->storage->saveUrl($user, 'http://185.154.53.66/storage/avatars/'.$file_name, $file_name);
        $file_name = 'julia.jpg';
        $user = User::create([
            'name' => 'Юлия Машкова',
            'email' => 'julia@gmail.com',
            'password' => Hash::make('1234567'),
            'role_id' => 3,
            'avatar' => $file_name
        ]);
        $this->storage->saveUrl($user, 'http://185.154.53.66/storage/avatars/'.$file_name, $file_name);
    }
    protected function createRoot()
    {
        $file_name = 'oleg.jpg';
       $user = User::create([
            'name' => 'Олег Тихонов',
            'email' => 'oleg@gmail.com',
            'password' => Hash::make('1234567'),
            'role_id' => 1,
            'avatar' => $file_name
        ]);
        $this->storage->saveUrl($user, 'http://185.154.53.66/storage/avatars/'.$file_name, $file_name);
    }

    protected function createAdmin()
    {
        $file_name = 'andrey.jpg';
        $user = User::create([
            'name' => 'Андрей Белоносов',
            'email' => 'andrey@gmail.com',
            'password' => Hash::make('1234567'),
            'role_id' => 2,
            'avatar' => 'andrey.jpg'
        ]);
        $this->storage->saveUrl($user, 'http://185.154.53.66/storage/avatars/'.$file_name, $file_name);
    }

    protected function createShareholder()
    {
        $file_name = 'rotshild.jpg';
        $user = User::create([
            'name' => 'Майер Амшель Ротшильд',
            'email' => 'rotshild@gmail.com',
            'password' => Hash::make('1234567'),
            'role_id' => 4,
            'avatar' => 'rotshild.jpg'
        ]);
        $this->storage->saveUrl($user, 'http://185.154.53.66/storage/avatars/'.$file_name, $file_name);
    }
}
