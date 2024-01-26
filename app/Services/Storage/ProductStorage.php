<?php

namespace App\Services\Storage;

use Illuminate\Support\Facades\Storage as LaravelStorage;
use Illuminate\Database\Eloquent\Model;

class ProductStorage implements Storage
{
    public function save(Model $product, $files)
    {

        if($files && count($files) > 0){
            $count = 0;
            if($product->images->count())
            {
                $count = $product->images->count();
            }
            if($count)
            {
                $sort = $count;
            }
            else{
                $sort = 0;
            }
            foreach ($files as $key => $file)
            {

                $name = uniqid().'.'.$file->getClientOriginalExtension();
                LaravelStorage::putFileAs('/public/products/', $file, $name);
                $product->images()->create([
                    'file_name' => $name,
                    'sort' => $sort,
                ]);
                $sort++;
            }
        }
    }

    public function saveUrl(Model $product, $files)
    {
        if($files && count($files) > 0){
            $count = 0;
            if($product->images->count())
            {
                $count = $product->images->count();
            }
            if($count)
            {
                $sort = $count;
            }
            else{
                $sort = 0;
            }
            foreach ($files as $key => $file)
            {

                $name = $key;
                LaravelStorage::putFileAs('/public/products/', $file.'/'.$name, $name);
                $product->images()->create([
                    'file_name' => $name,
                    'sort' => $sort,
                ]);
                $sort++;
            }
        }
    }
}
