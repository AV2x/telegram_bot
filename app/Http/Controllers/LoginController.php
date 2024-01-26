<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        if(!$this->token($request))
        {
            throw new \Exception('Токен не валидный');
        }
        $url = $request->input('photo_url');
        $ext = explode('.', $url);
        $ext = $ext[count($ext) - 1];
        $file_name = uniqid().'.'.$ext;
        $user = User::updateOrCreate(['telegram_id' => $request->input('id')],[
             'name' => $request->input('first_name'),
             'telegram_id' => $request->input('id'),
             'telegram_username' => $request->input('username'),
             //'avatar' => $file_name,
             'password' => Hash::make(123),
         ]);
        if(!$user->avatar)
        {
            Storage::putFileAs('public/telegram/images', $request->input('photo_url'), $file_name);
            $user->avatar = $file_name;
            $user->save();
        }
        if(Auth::attempt(['telegram_id' => $user->telegram_id, 'password' => 123]))
        {
            $request->session()->regenerate();
            return response()->redirectTo('/');
        }
        return response()->redirectTo('/');
    }

    public function token(Request $request)
    {
        $data = $request->all();
        $check_hash = $request->input('hash');
        unset($data['hash']);
        $data_check_arr = [];
        foreach ($data as $key => $value) {
            $data_check_arr[] = $key . '=' . $value;
        }
        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);
        $secret_key = hash('sha256', env('TELEGRAM_BOT_TOKEN'), true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);
        if(strcmp($hash, $check_hash) == 0 && (time() - $data['auth_date']) < 86400)
        {
            return true;
        }
        return false;
    }


    public function telegramAuth()
    {
        $token = md5(uniqid());
        Auth::user()->telegram_token = $token;
        Auth::user()->save();
        return redirect('https://t.me/testpovyshevbot?start='.$token);
    }

}
