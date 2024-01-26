<?php

namespace App\Helpers\Analytics;

use App\Models\Order;
use Illuminate\Http\Request;

class Data
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
        return $this->dates($dates, $request, 'week' );
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
        foreach ($date['hours'] as $key => $hour)
        {
            $nextHour = $hour +1;
            if(in_array($nextHour, $date['hours']))
            {
                $orders = Order::with(['products' => function($query){
                    $query->select('products.*', 'order_products.counts as order_counts');
                }])
                    ->whereDate('created_at', $date['date'])
                    ->whereTime('created_at', '>=', $hour.':00:00')
                    ->whereTime('created_at', '<', $nextHour.':00:00');

            }
            else{
                $orders = Order::with(['products' => function($query){
                    $query->select('products.*', 'order_products.counts as order_counts');
                }])
                    ->whereDate('created_at', $date['date'])
                    ->whereTime('created_at', '>=', $hour.':00:00');
            }
            if($request->input('category_id'))
            {
                $orders = $orders->whereHas('products', function ($query) use($request){
                    $query->where('category_id', $request->input('category_id'));
                });
            }
            elseif ($request->input('product_id'))
            {
                $orders = $orders->where('product_id', $request->input('product_id'));
            }
            elseif ($request->input('user_id'))
            {
                $orders = $orders->where('user_id', $request->input('user_id'));
            }
            $orders = $orders->get();
            $newOrders[$key]['type'] = $hour;
            $newOrders[$key]['amount'] = 0;
            foreach ($orders as $order){
                foreach ($order->products as $product){
                    $newOrders[$key]['amount'] = $product->order_counts * $product->price + $newOrders[$key]['amount'];
                }
            }

        }
        return $newOrders;
    }

    protected function dates($dates, Request $request, $type = null )
    {
        $newOrders = [];
        $orders = Order::with(['products' => function($query){
            $query->select('products.*', 'order_products.counts as order_counts');
        }])
            ->whereBetween('created_at', [$dates[0], $dates[count($dates)-1]]);
            if($request->input('category_id'))
            {
                $orders = $orders->whereHas('products', function ($query) use($request){
                    $query->where('category_id', $request->input('category_id'));
                });
            }
            elseif ($request->input('product_id'))
            {
                $orders = $orders->where('product_id', $request->input('product_id'));
            }
            elseif ($request->input('user_id'))
            {
                $orders = $orders->where('user_id', $request->input('user_id'));
            }
            $orders = $orders->get();
        foreach ($dates as $key => $date)
        {
            $arrayOrders = $orders->filter(function ($o, $i) use($date){
                return date('Y-m-d', strtotime($o->created_at)) == $date;
            });
            $newOrders[$key]['type'] = ($type == 'week') ? self::weekCount[$key]: $date;
            $newOrders[$key]['amount'] = 0;
            foreach ($arrayOrders as $order){
                foreach ($order->products as $product){
                    $newOrders[$key]['amount'] = $product->order_counts * $product->price + $newOrders[$key]['amount'];
                }
            }
        }
        return $newOrders;
    }
}
