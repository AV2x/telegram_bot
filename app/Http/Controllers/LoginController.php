<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email - обязательное поле!',
            'password.required' => 'Пароль - обязательное поле!',
            'email.email' => 'Неправильно указан Email',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('home');
        }
        return Response::json(['message' => 'Неправильный email или пароль!'], 422);
    }

    public function auth()
    {
        if(Auth::check())
        {
            return Response::json(Auth::user()->load('permissions'));
        }
        return Response::json(Auth::user());
    }

    public function telegramAuth()
    {
        $token = md5(uniqid());
        Auth::user()->telegram_token = $token;
        Auth::user()->save();
        return redirect('https://t.me/testpovyshevbot?start='.$token);
    }
}
