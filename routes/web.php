<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|test1112
*/

//\App\Telegram\Helpers\InlineButton::webApp('Аналитика', 'https://telegram.povyshev-course.com/analytics-today');
//\App\Facades\Telegram::buttons(5431617179, 'test', \App\Telegram\Helpers\InlineButton::$buttons)->send();
Route::get('/', function () {
    return response()->redirectTo('/login');
});

Route::get('/webapp/products', function (){
    $products = \App\Models\Product::get();
    return view('telegram.webapp.products', ['products' => $products]);
});
Route::get('/webapp/product/{id}', function ($id){
    $product = \App\Models\Product::find($id);
    return view('telegram.webapp.product', ['product' => $product]);
});

Route::view('/analytics-today', 'crm.webapp.analytics');

Route::get('telegram-auth', [LoginController::class, 'telegramAuth']);
Route::get('api/auth', [LoginController::class, 'auth']);
Route::get('get/telegram/bot/webhook-data', function (\Illuminate\Http\Request $request)
{
    dd(\Illuminate\Support\Facades\Cache::get('webhook-data'));
});
Route::any('/login', function (){
    if(Auth::check()) {
        return response()->redirectTo('/home');
    }
    return view('authorize');
});
Route::post('/api/login', [LoginController::class, 'login']);

Route::any('{any?}/{any2?}/{any3?}', function (){
    return view('crm');
});


