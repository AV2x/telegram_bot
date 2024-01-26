<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    public function view(): View
    {
        return view('crm.exports.product', [
            'products' => Product::with('images', 'properties', 'category')->get()
        ]);
    }
}
