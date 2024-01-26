<?php

namespace App\Http\Controllers;

use App\Telegram\Webhook\Realization;
use App\Telegram\Webhook\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function index(Request $request, Webhook $webhook, Realization $realization)
    {

        Cache::forever('webhook-data', $request->all());
        $path = $realization->take($request);
        if($path)
        {
            try {
                App::make($path)->run();
            }
            catch (\Exception $exception)
            {
                Log::error($exception);
                //$webhook->run();
            }
            return true;
        }
        else{
            $webhook->run();
        }

        return true;
    }
}
