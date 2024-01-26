<?php

namespace App\Http\Controllers;

use App\Events\NewOrderEvent;
use App\Events\StatusOrderEvent;
use App\Exports\OrdersExport;

use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::with(['products' => function($query){
            $query->select('products.*', 'order_products.counts as order_counts');
            $query->with('category');
            $query->with('images');
        }])->with(['status', 'manager']);
        if($request->input('id') && $request->input('id') != 'null')
        {
            $orders = $orders->where('id', $request->input('id'));
        }
        if($request->input('user_id') && $request->input('user_id') != 'null')
        {
            $orders = $orders->where('user_id', $request->input('user_id'));
        }
        if($request->input('product_id') && $request->input('product_id') != 'null')
        {
            $orders = $orders->whereHas('products', function ($query) use($request)
            {
                $query->where('product_id', $request->input('product_id'));
            });
        }
        if($request->input('client_name') && $request->input('client_name') != 'null')
        {
            $orders = $orders->where('client_name', 'like', '%'.$request->input('client_name').'%');
        }
        if($request->input('client_email') && $request->input('client_email') != 'null')
        {
            $orders = $orders->where('client_email', 'like', '%'.$request->input('client_email').'%');
        }
        if($request->input('client_telephone') && $request->input('client_telephone') != 'null')
        {
            $orders = $orders->where('client_telephone', 'like', '%'.$request->input('client_telephone').'%');
        }
        if($request->input('status_id') && $request->input('status_id') != 'null')
        {
            $orders =  $orders->where('status_id', $request->input('status_id'));
        }
        if($request->input('sortByAsc') && $request->input('sortByAsc') != 'null')
        {
            $orders = $orders->orderBy($request->input('sortByAsc'), 'asc');
        }
        if($request->input('sortByDesc')  && $request->input('sortByDesc') != 'null')
        {
            $orders = $orders->orderBy($request->input('sortByDesc'), 'desc');
        }
        $orders = $orders->orderby('id', 'desc');

        return Response::json($orders->paginate(20), 200);
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
        $counts = [];
        foreach ($request->input('product_id') as $key => $product_id)
        {
            if($product_id){
                $counts[$key] = $product_id[0];
            }
        }
       $order = Order::create([
            'status_id' => Status::first()->id,
            'user_id' => ($request->input('user_id')) ? $request->input('user_id') : Auth::id(),
            'client_name' => $request->input('client_name'),
            'client_email' => $request->input('client_email'),
            'client_telephone' => $request->input('client_telephone'),
        ]);

        $order->products()->attach($counts);
        $order = Order::where('id', $order->id)->with(['products' => function($query){
            $query->select('products.*', 'order_products.counts as order_counts');
            $query->with('category');
            $query->with('images');
        }])->with(['status', 'manager'])->first();
        event(new NewOrderEvent($order));
        return Response::json($order, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);



        //$order->status_id = $request->input('status_id');
        if($request->has('client_name'))
        {
            $order->client_name = $request->input('client_name');
        }
        if($request->has('client_email'))
        {
            $order->client_email = $request->input('client_email');
        }
        if($request->has('client_telephone'))
        {
            $order->client_telephone = $request->input('client_telephone');
        }
        if($request->has('user_id'))
        {
            $order->user_id = $request->input('user_id');
        }

        $order->save();
        if($request->input('product_id'))
        {
            $counts = [];
            foreach ($request->has('product_id') as $key => $product_id)
            {
                if($product_id){
                    $counts[$key] = $product_id[0];
                }
            }
            $order->products()->sync($counts);
        }


        $order = Order::where('id', $id)->with(['products' => function($query){
            $query->select('products.*', 'order_products.counts as order_counts');
            $query->with('category');
            $query->with('images');
        }])->with(['status', 'manager'])->first();
        event(new StatusOrderEvent($order));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Order::destroy($id);
    }

    public function updateStatus($id, Request $request)
    {
        $order = Order::find($id);
        $order->status_id = $request->input('status_id');
        $order->save();
        $order = Order::where('id', $order->id)->with(['products' => function($query){
            $query->select('products.*', 'order_products.counts as order_counts');
            $query->with('category');
            $query->with('images');
        }])->with(['status', 'manager'])->first();
        event(new StatusOrderEvent($order));
    }
    public function export()
    {
        //return (new OrdersExport())->view();
        Excel::store(new OrdersExport(), 'public/exports/orders.xlsx');
        return Response::json('/storage/exports/orders.xlsx');
    }
}
