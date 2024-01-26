<?php

namespace App\Helpers\Analytics;

use App\Models\Order;
use Illuminate\Http\Request;

class Price
{
    protected $day = [
        '01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'
    ];
    protected $week = [
        '01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24'
    ];
    protected const weekCount= ['пн.', 'вт', 'ср', 'чт', 'пт', 'суб', 'вск'];
    public function today(Request $request)
    {
        $date = [
            'date' => date('Y-m-d'),
            'hours' => $this->day,
        ];
        return $this->recountDay($date, $request);
    }
    public function yesterday(Request $request)
    {
        $date = [
            'date' => (new \DateTime())->modify('-1 days')->format('Y-m-d'),
            'hours' => $this->day,
        ];
        return $this->recountDay($date, $request);
    }
    public function week(Request $request)
    {
        $week_start =  date('Y-m-d', strtotime("this week"));
        $dates = [$week_start];
        for ($i = 1; $i <= 6; $i++)
        {
            $dates[] = (new \DateTime($week_start))->modify('+'.$i.' days')->format('Y-m-d');
        }
        return $this->dates($dates, $request, 'week');
    }
    public function month(Request $request)
    {
        $start =  date('Y-m-01');
        $dates = [$start];

        for ($i = 1; $i <= date('t', mktime(0, 0, 0, date('m'))) -1; $i++)
        {
            $dates[] = (new \DateTime($start))->modify('+'.$i.' days')->format('Y-m-d');
        }
        return $this->dates($dates, $request);
    }
    public function ownDates(Request $request, $dateFrom, $dateTo)
    {
        $datediff = strtotime($dateTo) - strtotime($dateFrom);
        $daysCount = $datediff / (60 * 60 * 24);
        $dates = [$dateFrom];

        for ($i = 1; $i <= $daysCount; $i++)
        {
            $dates[] = (new \DateTime($dateFrom))->modify('+'.$i.' days')->format('Y-m-d');
        }
        return $this->dates($dates, $request);
    }


    protected function recountDay($date, Request $request)
    {
        $newOrders = [];

            $orders = Order::join('order_products as po', 'po.order_id', '=', 'orders.id')
                ->join('products as p', 'po.product_id', '=', 'p.id')
                ->join('categories as c', 'p.category_id', '=', 'c.id')
                ->join('users as u', 'orders.user_id', '=', 'u.id')
                ->select('orders.*',  'po.counts as order_counts',
                    'p.name as product_name', 'p.id as product_id', 'p.price', 'c.name as category_name', 'c.id as category_id',
                    'u.name as user_name'
                );
                $orders = $orders->whereDate('orders.created_at', $date['date']);
                $orders = $orders->get();
            if($request->input('users')){
                $orders = $orders->groupBy('user_id');
                $type = 'user_name';
            }
            elseif($request->input('products'))
            {
                $orders = $orders->groupBy('product_id');
                $type = 'product_name';
            }
            elseif ($request->input('categories'))
            {
                $orders = $orders->groupBy('category_id');
                $type = 'category_name';
            }
            $i = 0;
            foreach ($orders as $orderKey => $orderGroup)
            {
                $newOrders[$i]['amount'] = 0;
                foreach ($orderGroup as $order)
                {
                    $newOrders[$i]['amount'] = $order->order_counts * $order->price + $newOrders[$i]['amount'];
                    $newOrders[$i]['type'] = $order->$type;
                }
                $i++;
            }

        return $newOrders;
    }

    protected function dates($dates, Request $request, $type = null)
    {
        $newOrders = [];
        $orders = Order::join('order_products as po', 'po.order_id', '=', 'orders.id')
            ->join('products as p', 'po.product_id', '=', 'p.id')
            ->join('categories as c', 'p.category_id', '=', 'c.id')
            ->join('users as u', 'orders.user_id', '=', 'u.id')
            ->select('orders.*',  'po.counts as order_counts',
                'p.name as product_name', 'p.id as product_id', 'p.price', 'c.name as category_name', 'c.id as category_id',
                'u.name as user_name'
            )
            ->whereBetween('orders.created_at', [$dates[0], $dates[count($dates)-1]])->get();
        if($request->input('users')){
            $orders = $orders->groupBy('user_id');
            $type = 'user_name';
        }
        elseif($request->input('products'))
        {
            $orders = $orders->groupBy('product_id');
            $type = 'product_name';
        }
        elseif ($request->input('categories'))
        {
            $orders = $orders->groupBy('category_id');
            $type = 'category_name';
        }


        $i = 0;
        foreach ($orders as $orderKey => $orderGroup)
        {
            $newOrders[$i]['amount'] = 0;
            foreach ($orderGroup as $order)
            {
                $newOrders[$i]['amount'] = $order->order_counts * $order->price + $newOrders[$i]['amount'];
                $newOrders[$i]['type'] = $order->$type;
            }
            $i++;
        }
        return $newOrders;
    }
}
