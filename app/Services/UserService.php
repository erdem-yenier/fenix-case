<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Enum\ProductEnum;
use App\Enum\ProductCreditEnum;
use App\Models\Subscriptions;

class UserService
{
    public function checkUserExists($device_uuid) {
        return User::where('device_uuid' , $device_uuid);
    }

    public function createUser($device_uuid, $device_name, $ip_address) {

        $new_user = new User();
        $new_user->device_uuid = $device_uuid;
        $new_user->device_name = $device_name;
        $new_user->ip_address = $ip_address;
        $new_user->is_status = 1; 

        if ($new_user->save()) {
            $new_user_id = $new_user->id;
            $new_subscriber = new Subscriptions();
            $new_subscriber->user_id = $new_user_id;
            $new_subscriber->sub_type = ProductEnum::FREE;
            $new_subscriber->credit_amount = ProductCreditEnum::FREECREDIT;
            $new_subscriber->sub_date = Carbon::now();

            if ($new_subscriber->save()) {
                return $this->checkUserSubscription($new_user_id);
            } else {
                return false;
            } 
        } else {
            return false;
        }

    }

    public function checkUserSubscription($user_id) {

        $data = [];
        $user = User::find($user_id);  
        
        $data = [
            'user_id' => $user_id,
            'device_uuid' => $user['device_uuid'],
            'device_name' => $user['device_name'],
            'sub_type' => $user->subscriptions->sub_type,
            'credit_amount' => $user->subscriptions->credit_amount,
            'sub_date' => $user->subscriptions->sub_date
        ];

        foreach ($user->chat_box as $item) {
            $data['chat_history'][$item['chat_uuid']][] = [
                'message' => $item['chat_content'],
                'chat_date' => $item['chat_date']
            ];
        }

        return $data;

    }
}