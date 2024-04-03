<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\Orders;
use App\Models\Products;
use App\Models\Subscriptions;

use App\Enum\ProductEnum;
use App\Enum\ProductCreditEnum;

class SubscriptionService
{
    public function checkProductExists($product_id) {
        return Products::where('id', $product_id);
    }

    public function createOrder($user_id, $product) {

        $new_order = new Orders();
        $new_order->user_id = $user_id;
        $new_order->product_id = $product['id'];
        $new_order->receipt_token = Str::random(32);
        $new_order->price = $product['price'];
        $new_order->credit = $product['credit']; 

        if ($new_order->save()) {
            
            $update_subscriber = Subscriptions::where('user_id' , $user_id)->update([
                'credit_amount' => \DB::raw("credit_amount+".$product['credit']),
                'sub_type' => ProductEnum::PREMIUM,
                'sub_date' => Carbon::now()
            ]);
            
            if ($update_subscriber) {
                return true;
            } else {
                return false;
            } 
            
        } else {
            return false;
        }

    }
}