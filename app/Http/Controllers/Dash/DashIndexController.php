<?php

namespace App\Http\Controllers\Dash;

use App\Models\Orders;
use App\Enum\StatusEnum;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\OrdersResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashIndexController extends Controller
{
    public function list() {

        $http_code = 200;
        $response_data = [];

        try {

            $response_data['status'] = true;
            $response_data['type'] = StatusEnum::SUCCESS;

            $response_data['data'] = OrdersResource::collection(Orders::get());

        } catch (\Exception $e) {

            $http_code = 400;
            $response_data['status'] = false;
            $response_data['type'] = StatusEnum::ERROR;
            $response_data['message'] = 'Sistemde bir hata vardır lütfen daha sonra tekrar deneyiniz.';
        }

        return response()->json($response_data, $http_code);

    }
}
