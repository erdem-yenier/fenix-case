<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Products;
use App\Enum\StatusEnum;
use Illuminate\Http\JsonResponse;

use App\Services\UserService;
use App\Services\SubscriptionService;

use App\Http\Resources\ProductsResource;

use App\Http\Requests\SubscriptionRequest;

class SubscriptionController extends Controller
{

    protected $userService;
    protected $subscriptionService;

    public function __construct(UserService $userService, SubscriptionService $subscriptionService)
    {
        $this->userService = $userService;
        $this->subscriptionService = $subscriptionService;
    }
 
    public function list() {

        $http_code = 200;
        $response_data = [];

        try {

            $response_data['status'] = true;
            $response_data['type'] = StatusEnum::SUCCESS;
            $response_data['data'] = ProductsResource::collection(Products::where('is_status', 1)->get());

        } catch (\Exception $e) {

            $http_code = 400;
            $response_data['status'] = false;
            $response_data['type'] = StatusEnum::ERROR;
            $response_data['message'] = 'Sistemde bir hata vardır lütfen daha sonra tekrar deneyiniz.';
        }

        return response()->json($response_data, $http_code);

    }

    public function subscription(SubscriptionRequest $request): JsonResponse {

        $http_code = 200;
        $response_data = [];
        $response_data['status'] = true;
        $response_data['type'] = StatusEnum::SUCCESS;
        $device_uuid = $request->input('device_uuid');
        $product_id = $request->input('product_id');
        $ip_address = $request->ip();

        try {

            #service tarafından gelen product_id ile prodduct varlığını kontrol ediyoruz.
            $check_product = $this->subscriptionService->checkProductExists($product_id);
                
            if ($check_product->count() > 0) {

                $product = $check_product->first();

                #service tarafından gelen device_uuidnin bilgilerini çekiyoruz.
                $check_user = $this->userService->checkUserExists($device_uuid);
                $user_id = $check_user->first()['id'];
                $create_order = $this->subscriptionService->createOrder($user_id, $product);

                if (!$create_order) {
                    $http_code = 400;
                    $response_data['status'] = false;
                    $response_data['type'] = StatusEnum::ERROR;
                    $response_data['message'] = 'Sistemde bir hata tespit edildi. Lütfen daha sonra tekrar deneyiniz.';
                }

            } else {

                $response_data['status'] = false;
                $response_data['type'] = StatusEnum::ERROR;
                $response_data['message'] = 'Seçmiş olduğunuz ürün silinmiş veya bulunmamaktadır.';
            }


        } catch (\Exception $e) {

            $http_code = 400;
            $response_data['status'] = false;
            $response_data['type'] = StatusEnum::ERROR;
            $response_data['message'] = 'Sistemde bir hata tespit edildi. Lütfen daha sonra tekrar deneyiniz.';
            $response_data['catch_message'] = $e->getMessage();
        }
        

        return response()->json($response_data, $http_code);
    }
    
}
