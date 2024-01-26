<?php

namespace App\Services\Storage;

use Illuminate\Database\Eloquent\Model;

interface Storage
{
    public function save(Model $model, $file);
}
