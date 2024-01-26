<?php

namespace App\Services\Storage;

use Illuminate\Support\Facades\Storage as LaravelStorage;
use Illuminate\Database\Eloquent\Model;

class UserStorage implements Storage
{
    public function save(Model $model, $file)
    {
        if($file){
            $name = uniqid().'.'.$file->getClientOriginalExtension();
            LaravelStorage::putFileAs('/public/users/avatar', $file, $name);
            $model->avatar = $name;
            $model->save();
        }
    }
    public function saveUrl(Model $model, $file, $name)
    {
        if($file){
            LaravelStorage::putFileAs('/public/users/avatar', $file, $name);
            $model->avatar = $name;
            $model->save();
        }
    }
}
