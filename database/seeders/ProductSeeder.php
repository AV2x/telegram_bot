<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Services\Storage\ProductStorage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $storage;
    protected $properties = [
        '1' => ['value' => '12 мес.'],
        '5' => ['value' => '6.7'],
        '6' => ['value' => '2796x1290'],
        '7' => ['value' => '460 ppi'],
        '8' => ['value' => 'OLED'],
        '9' => ['value' => 'безрамочный'],
        '10' => ['value' => '120 Гц'],
        '11' => ['value' => 'металл, стекло'],
        '12' => ['value' => 'iOS'],
        '13' => ['value' => 'iOS 16'],
        '14' => ['value' => 'Apple'],
        '15' => ['value' => 'Apple A16 Bionic'],
        '16' => ['value' => '6'],
        '17' => ['value' => '3'],
        '18' => ['value' => '48+12+12 Мп'],
        '19' => ['value' => 'Sony IMX590, Sony IMX633, Sony IMX713, Sony IMX803'],
        '20' => ['value' => '2-кратный оптический зум, 3-кратный оптический зум, 15-кратный цифровой зум'],
        '21' => ['value' => 'Full HD, HD, Ultra HD 4K'],
        '22' => ['value' => '1280x720 (30 кадр./сек.), 1920x1080 (30 кадр./сек.), 1920x1080 (60 кадр./сек.), 3840x2160 (24 кадр./сек.), 3840x2160 (25 кадр./сек.), 3840x2160 (30 кадр./сек.), 3840x2160 (60 кадр./сек.)'],
        '23' => ['value' => '1920x1080 (120 кадр./сек.), 1920x1080 (240 кадр./сек.)'],
        '24' => ['value' => '2-кратный оптический зум, 3-кратный оптический зум, 6-кратный оптический зум, 9-кратный цифровой зум'],
        '25' => ['value' => 'нет'],
        '26' => ['value' => '12 Мп'],
        '27' => ['value' => '1.9'],
        '28' => ['value' => '1920x1080 (30 кадр./сек.), 1920x1080 (60 кадр./сек.), 1920x1080 (120 кадр./сек.), 3840×2160 (30 кадр./сек.), 3840×2160 (60 кадр./сек.)'],
        '29' => ['value' => '5.3'],
        '30' => ['value' => '4 (802.11n), 5 (802.11ac), 6 (802.11ax)'],
        '31' => ['value' => 'есть'],
        '32' => ['value' => 'A-GPS, BeiDou, GPS, Galileo, QZSS, ГЛОНАСС'],
    ];
    public function __construct(ProductStorage $storage)
    {
        $this->storage = $storage;
    }
    public function run(): void
    {
        $product = Product::create([
            'name' => '6.7" Смартфон Apple iPhone 14 Pro Max 1000 ГБ золотистый',
            'category_id' => 1,
            'price' => 169000,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '1_1.webp' => 'http://185.154.53.66/storage/products/',
            '1_2.webp' => 'http://185.154.53.66/storage/products/',
            '1_3.webp' => 'http://185.154.53.66/storage/products/'
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Apple iPhone 14 Pro Max'],
            '3' => ['value' => '2022'],
            '4' => ['value' => 'золотистый'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);


  ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.7" Смартфон Apple iPhone 14 Pro Max 1000 ГБ фиолетовый',
            'category_id' => 1,
            'price' => 169000,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '3_1.webp' => 'http://185.154.53.66/storage/products/',
            '3_2.webp' => 'http://185.154.53.66/storage/products/',
            '3_3.webp' => 'http://185.154.53.66/storage/products/'
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Apple iPhone 14 Pro Max'],
            '3' => ['value' => '2022'],
            '4' => ['value' => 'фиолетовый'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);


        ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.7" Смартфон Apple iPhone 14 Pro Max 1000 ГБ серебристый',
            'category_id' => 1,
            'price' => 169000,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '2_1.webp' => 'http://185.154.53.66/storage/products/',
            '2_2.webp' => 'http://185.154.53.66/storage/products/',
            '2_3.webp' => 'http://185.154.53.66/storage/products/'
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Apple iPhone 14 Pro Max'],
            '3' => ['value' => '2022'],
            '4' => ['value' => 'серебристый'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);



        ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.7" Смартфон Apple iPhone 14 Pro Max 1000 ГБ черный',
            'category_id' => 1,
            'price' => 169000,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '4_1.webp' => 'http://185.154.53.66/storage/products/',
            '4_2.webp' => 'http://185.154.53.66/storage/products/',
            '4_3.webp' => 'http://185.154.53.66/storage/products/'
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Apple iPhone 14 Pro Max'],
            '3' => ['value' => '2022'],
            '4' => ['value' => 'черный'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);



        ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.8" Смартфон Samsung Galaxy S23 Ultra 512 ГБ черный',
            'category_id' => 2,
            'price' => 119000,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '5_1.webp' => 'http://185.154.53.66/storage/products/',
            '5_2.webp' => 'http://185.154.53.66/storage/products/',
            '5_3.webp' => 'http://185.154.53.66/storage/products/',
            '5_4.webp' => 'http://185.154.53.66/storage/products/',
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Samsung Galaxy S23 Ultra'],
            '3' => ['value' => '2023'],
            '4' => ['value' => 'черный'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);



        ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.8" Смартфон Samsung Galaxy S23 Ultra 256 ГБ бежевый',
            'category_id' => 2,
            'price' => 109000,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '6_1.webp' => 'http://185.154.53.66/storage/products/',
            '6_2.webp' => 'http://185.154.53.66/storage/products/',
            '6_3.webp' => 'http://185.154.53.66/storage/products/',
            '6_4.webp' => 'http://185.154.53.66/storage/products/',
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Samsung Galaxy S23 Ultra'],
            '3' => ['value' => '2023'],
            '4' => ['value' => 'бежевый'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);




        ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.6" Смартфон Samsung Galaxy S23+ 512 ГБ зеленый',
            'category_id' => 2,
            'price' => 97999,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '7_1.webp' => 'http://185.154.53.66/storage/products/',
            '7_2.webp' => 'http://185.154.53.66/storage/products/',
            '7_3.webp' => 'http://185.154.53.66/storage/products/',
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Samsung Galaxy S23+'],
            '3' => ['value' => '2023'],
            '4' => ['value' => 'зеленый'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);




        ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.1" Смартфон Samsung Galaxy S23 256 ГБ бежевый',
            'category_id' => 2,
            'price' => 79999,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '8_1.webp' => 'http://185.154.53.66/storage/products/',
            '8_2.webp' => 'http://185.154.53.66/storage/products/',
            '8_3.webp' => 'http://185.154.53.66/storage/products/',
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Samsung Galaxy S23'],
            '3' => ['value' => '2023'],
            '4' => ['value' => 'бежевый'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);



        ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.1" Смартфон Samsung Galaxy S23 128 ГБ черный',
            'category_id' => 2,
            'price' => 79999,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '9_1.webp' => 'http://185.154.53.66/storage/products/',
            '9_2.webp' => 'http://185.154.53.66/storage/products/',
            '9_3.webp' => 'http://185.154.53.66/storage/products/',
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Samsung Galaxy S23'],
            '3' => ['value' => '2023'],
            '4' => ['value' => 'черный'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);



        ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.36" Смартфон Xiaomi 13 256 ГБ белый',
            'category_id' => 3,
            'price' => 72999,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '10_1.webp' => 'http://185.154.53.66/storage/products/',
            '10_2.webp' => 'http://185.154.53.66/storage/products/',
            '10_3.webp' => 'http://185.154.53.66/storage/products/',
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Xiaomi 13'],
            '3' => ['value' => '2023'],
            '4' => ['value' => 'белый'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);



        ////////////////////////////////////////////////////////////////////



        $product = Product::create([
            'name' => '6.67" Смартфон Xiaomi 12T Pro 256 ГБ голубой',
            'category_id' => 3,
            'price' => 62999,
            'counts' => 50,
            'count_type' => 'шт',
        ]);
        $files = [
            '11_1.webp' => 'http://185.154.53.66/storage/products/',
            '11_2.webp' => 'http://185.154.53.66/storage/products/',
            '11_3.webp' => 'http://185.154.53.66/storage/products/',
        ];
        $this->storage->saveUrl($product, $files);
        $properties = [
            '2' => ['value' => 'Xiaomi 12T Pro'],
            '3' => ['value' => '2023'],
            '4' => ['value' => 'голубой'],
        ];
        foreach ($this->properties as $key => $property)
        {
            $properties[$key] = $property;
        }
        $product->properties()->attach($properties);
    }
}
