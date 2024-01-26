<?php

namespace App\Http\Controllers;

use App\Helpers\Analytics\Data;
use App\Helpers\Analytics\Price;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    public function graphics(Request $request, Data $data)
    {
        if($request->input('type') == 1){
            $data = $data->today($request);
        }
        elseif ($request->input('type') == 3){
            $data = $data->yesterday($request);
        }
        elseif ($request->input('type') == 4)
        {
            $data = $data->week($request);
        }
        elseif ($request->input('type') == 5)
        {
            $data = $data->month($request);
        }
        elseif ($request->input('type') == 2)
        {
            $data = $data->ownDates($request, $request->input('date_from'), $request->input('date_to'));
        }
        return Response::json($data, 200);
    }
    public function price(Request $request, Price $price)
    {
        if ($request->input('type') == 1) {
            $price = $price->today($request);
        } elseif ($request->input('type') == 3) {
            $price = $price->yesterday($request);
        } elseif ($request->input('type') == 4) {
            $price = $price->week($request);
        } elseif ($request->input('type') == 5) {
            $price = $price->month($request);
        } elseif ($request->input('type') == 2) {
            $price = $price->ownDates($request, $request->input('date_from'), $request->input('date_to'));
        }
        return Response::json($price, 200);
    }
}
