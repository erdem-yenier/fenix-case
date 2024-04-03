<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Enum\StatusEnum;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthLoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $device_uuid = $request->input('device_uuid');
        $user_check = User::where('device_uuid', $device_uuid);

        if ($user_check->count() > 0) {
            return $next($request);
        } else {
            return response()->json(['status' => false , 'type' => StatusEnum::ERROR, 'message' => 'Girmiş olduğunuz bilgilerde kullanıcı bulunmamaktadır. Lütfen önce giriş yapınız.'], 401);
        }
        
    }
}
