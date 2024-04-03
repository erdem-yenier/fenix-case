<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ChatRequest;
use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Enum\StatusEnum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $userService;
    protected $chatService;

    public function __construct(UserService $userService, ChatService $chatService)
    {
        $this->userService = $userService;
        $this->chatService = $chatService;
    }

    public function index(ChatRequest $request): JsonResponse {

        $http_code = 200;
        $response_data = [];
        $device_uuid = $request->input('device_uuid');
        $chat_uuid = $request->input('chat_uuid');
        $message = $request->input('message');

        try {

            #service tarafından gelen device_uuidnin varlığını kontrol ediyoruz.
            $check_user = $this->userService->checkUserExists($device_uuid);
            $user = $check_user->first();
            $user_id = $user['id'];

            #service tarafından kullanıcının kredisini kontrol ediyoruz.
            $check_user_subscription = $this->userService->checkUserSubscription($user_id);

            if ($check_user_subscription['credit_amount'] > 0) {

                $create_chat = $this->chatService->createChat($user_id, $chat_uuid, $message);
            
                $response_data['status'] = true;
                $response_data['type'] = StatusEnum::SUCCESS;
                $response_data['data'] = $create_chat;
            } else {

                $http_code = 200;
                $response_data['status'] = false;
                $response_data['type'] = StatusEnum::ERROR;
                $response_data['message'] = 'Yetersiz Kredi. Lütfen kredi satın aldıktan sonra deneyiniz.';
            }
        

        } catch (\Exception $e) {

            $http_code = 400;
            $response_data['status'] = false;
            $response_data['type'] = StatusEnum::ERROR;
            $response_data['message'] = 'Sistemde bir hata testpi edildi. Lütfen daha sonra tekrar deneyiniz.';
            $response_data['catch_message'] = $e->getMessage();
        }

        return response()->json($response_data, $http_code);

    }
}
