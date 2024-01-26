<?php

use App\Facades\Telegram;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [ProductController::class, 'index']);
//Route::any('/api/authenticate', [LoginController::class, 'authenticate']);
//Route::get('telegram-authenticate', [LoginController::class, 'telegramAuth'])->middleware('auth');
Route::get('/webhook-data', function (\App\Telegram\Webhook\Webhook $webhook){
    dd(\Illuminate\Support\Facades\Cache::get('webhook-data'));
});
