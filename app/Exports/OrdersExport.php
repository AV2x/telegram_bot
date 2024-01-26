<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    public function view(): View
    {
        return view('crm.exports.orders', [
            'orders' => Order::with(['products' => function($query){
                $query->select('products.*', 'order_products.counts as order_counts');
                $query->with('category');
                $query->with('images');
            }])->with(['status', 'manager'])->get()
        ]);
    }
}
