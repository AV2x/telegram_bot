<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
       $product = Product::find(1);
       return view('products', ['product' => $product]);
    }
}
