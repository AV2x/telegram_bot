<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    protected $rows;
    protected $imgSort = 0;
    public function collection(Collection $rows)
    {
        $product = null;
        foreach ($rows as $key => $row)
        {
            if($key == 0) { continue;}
            $product = $this->product($row, $product);
            $this->properties($row, $product);
            $this->image($product, $row);
        }
    }
    protected function product($row, $product)
    {
        if($row[0]){
            $category = Category::firstOrCreate(['name' => $row[1]]);
            return Product::create([
                'name' => $row[0],
                'category_id' => $category->id,
                'price' => (int)$row[2],
                'counts' => (int)$row[3],
                'count_type' => $row[4],
            ]);
        }
        return $product;

    }

    protected function properties($row, Product $product)
    {
        if($row[5] && $row[6])
        {
           $property = Property::firstOrCreate(['name' => $row[5]]);
           $product->properties()->attach([$property->id => ['value' => $row[6]]]);
        }
    }

    protected function image(Product $product, $row)
    {
        if($row[0]){
            $this->imgSort = 0;
        }
        else{
            $this->imgSort++;
        }
        $product->images()->create([
            'file_name' => $row[7],
            'sort' => $this->imgSort,
        ]);
    }
}
