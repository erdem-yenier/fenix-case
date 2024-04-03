<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AuthRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Enum\StatusEnum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(AuthRequest $request): JsonResponse {

        $http_code = 200;
        $response_data = [];
        $device_uuid = $request->input('device_uuid');
        $device_name = $request->input('device_name');
        $ip_address = $request->ip();

        try {

            #service tarafından gelen device_uuidnin varlığını kontrol ediyoruz.
            $check_user = $this->userService->checkUserExists($device_uuid);
            
            if ($check_user->count() > 0) {
                
                $user = $check_user->first();
                $user_id = $user['id'];
                
                $check_user_sub = $this->userService->checkUserSubscription($user_id);
                
                $response_data['status'] = true;
                $response_data['type'] = StatusEnum::SUCCESS;
                $response_data['data'] = $check_user_sub;

            } else {

                $create_user = $this->userService->createUser($device_uuid, $device_name, $ip_address);
                $response_data['status'] = true;
                $response_data['type'] = StatusEnum::SUCCESS;
                $response_data['data'] = $create_user;

            }

        } catch (\Exception $e) {

            $http_code = 400;
            $response_data['status'] = false;
            $response_data['type'] = StatusEnum::ERROR;
            $response_data['message'] = 'Sistemde bir hata testpi edildi. Lütfen daha sonra tekrar deneyiniz.';
        }

        return response()->json($response_data, $http_code);

    }
}
