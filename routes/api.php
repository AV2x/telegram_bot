<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('webhook', [WebhookController::class, 'index']);
Route::group(['middleware' => 'auth'], function (){
    Route::post('logout', function (){
        \Illuminate\Support\Facades\Auth::logout();
    });
    Route::get('/executors', [UserController::class, 'executors']);
    Route::post('change-password', function (Request $request){
        if(\Illuminate\Support\Facades\Hash::check($request->input('oldPassword'), Auth::user()->password))
        {
            Auth::user()->password = \Illuminate\Support\Facades\Hash::make($request->input('oldPassword'));
            Auth::user()->save();
            return \Illuminate\Support\Facades\Response::json(true, 200);
        }
        return Response::json(['message' => 'Неверный старый пароль!'], 422);
    });
    Route::get('/storage/index', [StorageController::class, 'index']);
    Route::post('/storage/delete', [StorageController::class, 'delete']);
    Route::post('/storage/store', [StorageController::class, 'store']);
    Route::get('/orders/export', [OrderController::class, 'export']);
    Route::put('/products/{id}/sort-images', [ProductController::class, 'sortImages']);
    Route::post('/products/{id}/add-images', [ProductController::class, 'addImages']);
    Route::put('/orders/{id}/update-status', [OrderController::class, 'updateStatus']);
    Route::delete('/product/image/{id}/destroy', [ProductController::class, 'rmImage']);
    Route::post('/products/import', [ProductController::class, 'import']);
    Route::get('/products/export', [ProductController::class, 'export']);
    Route::get('/products/template', [ProductController::class, 'template']);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('properties', PropertyController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('roles', RoleController::class);
    Route::post('roles/attach', [RoleController::class, 'attach']);

    Route::resource('statuses', StatusController::class);
    Route::get('dashboard/graphics', [DashboardController::class, 'graphics']);
    Route::get('dashboard/price', [DashboardController::class, 'price']);
});


