<?php

namespace App\Http\Middleware;

use Closure;

class Protector
{
    public static function TokenGenerator()
    {
        date_default_timezone_set("UTC");
        return md5(env('SecretWord', "HishamWasHere") . date('hi', time()));
    }

    public function handle($request, Closure $next)
    {
        if (!$request->has('token') || $request->token != self::TokenGenerator()) {
            return response()->json(['status' => false, 'msg' => 'You are not allowed to access Api'], 401);
        }
        return $next($request);
    }
}
