<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\ChatBox;
use App\Models\Subscriptions;

use App\Enum\ChatEnum;

class ChatService
{

    public function createChat($user_id, $chat_uuid, $message) {

        $new_chat_box = new ChatBox();
        $new_chat_box->chat_uuid = $chat_uuid;
        $new_chat_box->user_id = $user_id;
        $new_chat_box->user_type = ChatEnum::USER;
        $new_chat_box->chat_content = $message;
        $new_chat_box->chat_date = Carbon::now(); 

        if ($new_chat_box->save()) {
            
            $update_subscriber = Subscriptions::where('user_id' , $user_id)->decrement('credit_amount', 1);
            
            if ($update_subscriber) {

                $faker = \Faker\Factory::create(); 

                $new_chat_box_bot = new ChatBox();
                $new_chat_box_bot->chat_uuid = $chat_uuid;
                $new_chat_box_bot->user_id = $user_id;
                $new_chat_box_bot->user_type = ChatEnum::CHATBOT;
                $new_chat_box_bot->chat_content = $faker->realText;
                $new_chat_box_bot->chat_date = Carbon::now(); 
                $new_chat_box_bot->save();
                
                return $new_chat_box_bot;
            } else {

                return false;
            } 
            
        } else {

            return false;
        }

    }
}