<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Exports\ProductsExportTemplate;
use App\Imports\ProductsImport;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\Storage\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    protected $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with(['category', 'images'])
            ->withCount('orders');
        if($request->input('product_name') && $request->input('product_name') != 'null')
        {
            $products = $products->where('name', 'like', '%'.$request->input('product_name').'%');
        }
        if($request->input('category_id') && $request->input('category_id') != 'null')
        {
            $products =  $products->where('category_id', $request->input('category_id'));
        }
        if($request->input('sortByAsc') && $request->input('sortByAsc') != 'null')
        {
            $products = $products->orderBy($request->input('sortByAsc'), 'asc');
        }
        if($request->input('sortByDesc')  && $request->input('sortByDesc') != 'null')
        {
            $products = $products->orderBy($request->input('sortByDesc'), 'desc');
        }
        return Response::json($products->get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $properties = [];
        $property_value = explode(',',$request->input('property_value'));
        foreach (explode(',',$request->input('property_key')) as $key => $property_id)
        {
            if($property_id){
                $properties[$property_id] = ['value' => $property_value[$key]];
            }
        }
      $product =  Product::create([
          'name' => $request->input('name'),
          'category_id' => $request->input('category_id'),
          'price' => $request->input('price'),
          'counts' => $request->input('counts'),
          'count_type' => $request->input('count_type')
      ]);
      $product->properties()->attach($properties);
      $this->storage->save($product, $request->file('files'));
      return Response::json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return Response::json(
            $product->load('properties', 'category', 'images'),
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request )
    {
        $product = Product::find($id);
        $properties = [];
        $property_value = $request->input('property_value');
        foreach ($request->input('property_key') as $key => $property_id)
        {
            if($property_id){
                $properties[$property_id] = ['value' => $property_value[$key]];
            }
        }
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->counts = $request->input('counts');
        $product->property_id = $request->input('property_id');
        $product->count_type = $request->input('count_type');
        $product->save();
        $product->properties()->sync($properties);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Product::destroy($id);
    }

    public function sortImages($id, Request $request)
    {
        $new = $request->input('new');
        $old = $request->input('old');
       $images = ProductImage::where('product_id', $id)->orderBy('sort', 'asc')->get();
       $updateImage = ProductImage::where('product_id', $id)->where('sort', $old)->first();
       foreach ($images as $image)
       {
           if($image->sort >= $new && $image->sort <= $old && $image->sort != $old) //справа на лево
           {
               $image->sort = $image->sort +1;
               $image->save();
           }
           if($image->sort <= $new && $image->sort >= $old) //слева на право
           {
               $image->sort = $image->sort - 1;
               $image->save();
           }

       }
        $updateImage->sort = $new;
       $updateImage->save();
    }
    public function addImages($id, Request $request)
    {
        $product = Product::find($id);
        $this->storage->save($product, $request->file('files'));
        return Response::json($product->images()->get(), 200);
    }
    public function rmImage($id)
    {
        ProductImage::destroy($id);
    }

    public function import(Request $request)
    {
        Excel::import(new ProductsImport(), $request->file('file')->store('files'));
    }
    public function export()
    {
        Excel::store(new ProductsExport(), 'public/exports/products.xlsx');
        return Response::json('/storage/exports/products.xlsx');
    }
    public function template()
    {
        Excel::store(new ProductsExportTemplate(), 'public/exports/template.xlsx');
        return Response::json('/storage/exports/template.xlsx');
    }
}
