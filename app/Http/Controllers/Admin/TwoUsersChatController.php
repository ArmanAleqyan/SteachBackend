<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Message;

class TwoUsersChatController extends Controller
{

    public function usersChat($id){


        $usersChat = Message::query()->where(function  ( $query)  use ($id){
            $query->where([
                'sender_id' => $id,
            ])->orWhere([
                'receiver_id' =>$id,
            ]);
        })
            ->with(['SenderMessage', 'ReceiverMessage'])
            ->orderBy('created_at','DESC')
            ->get()
            ->groupBy('room_id')
            ->toArray();


        $data_id = Cookie::get('data_id');

        $get_message = Message::with('SenderMessage', 'ReceiverMessage')->where('room_id', $data_id)->get();





//        $update = Message::where('room_id', $data_id)->where('receiver_id',auth()->user()->id)->update(['status'=> 0]);

        $get_count = Message::where('receiver_id' , $id)->sum('status');

        \Carbon\Carbon::setLocale('ru');
        foreach ($get_message as $time){
            $time['time'] =  $time['created_at']->diffForHumans();
        }




        $right_side_data = [];


        foreach ($usersChat as $item) {

            $review_count = collect($item);
            $review_count = $review_count->where('receiver_id', $id);
            $created_at =  $review_count->last();

            $created_at = $created_at['created_at'];

            $timestamp = strtotime($created_at);

            $created_at = date('d-m-y H:i',$timestamp);
            \Carbon\Carbon::setLocale('ru');

            $t_allowed = \Carbon\Carbon::parse($timestamp);

            $user_name = $id == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['name'] : $item[0]['receiver_message']['name'];
            $receiver_id = $id == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['id'] : $item[0]['receiver_message']['id'];
            $surname = $id == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['surname'] : $item[0]['receiver_message']['surname'];
//            dd($item);
//            $product_id = $item[0]['tender_order_message']['room_id'];
            $room_id =  $item[0]['room_id'];
            $user_image = $id == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['photo'] : $item[0]['receiver_message']['photo'];
//            $product_headline = $item[0]['order_message']['date_time'];
//            $product_name = $item[0]['order_message']['name'];
            //      $product_price = $item[0]['products']['price'];


            $image = $item[0]['file'];

            $review = $review_count->sum('status');

            $messages = $item[0]["message"];

            $right_side_data[] = [
                'user_name' => $user_name,
                'surname' =>$surname,
                'room_id' => $room_id,
//                'tender_name' => $product_name,
                'user_image' => $user_image,
//                'tender_data' => $product_headline,
//                'product_price' => $product_price,
                'messages' => $messages,
                'image' => $image,
                'receiver_id' => $receiver_id,
                'review' => $review,
                'created_at' => $t_allowed->diffForHumans()
            ];

            Cookie::queue('users_data', $id,  80000);

        }

        return view('admin.UsersChat.2usersChat' ,compact('right_side_data','data_id', 'get_count'));
    }

    public function UsersRoomIdChat($id)
    {
        $value = Cookie::get('users_data');

        $usersChat = Message::query()->where(function ($query) use ($value) {
            $query->where([
                'sender_id' => $value,
            ])->orWhere([
                'receiver_id' => $value,
            ]);
        })
            ->with(['SenderMessage', 'ReceiverMessage'])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy('room_id')
            ->toArray();


        $data_id = Cookie::get('data_id');

        $get_message = Message::with('SenderMessage', 'ReceiverMessage')->where('room_id', $data_id)->get();


//        $update = Message::where('room_id', $data_id)->where('receiver_id', auth()->user()->id)->update(['status' => 0]);

        $get_count = Message::where('receiver_id', $value)->sum('status');

        \Carbon\Carbon::setLocale('ru');
        foreach ($get_message as $time) {
            $time['time'] = $time['created_at']->diffForHumans();
        }


        $right_side_data = [];


        foreach ($usersChat as $item) {

            $review_count = collect($item);
            $review_count = $review_count->where('receiver_id',$value);
            $created_at = $review_count->last();
            $created_at = $created_at['created_at'];

            $timestamp = strtotime($created_at);

            $created_at = date('d-m-y H:i', $timestamp);
            \Carbon\Carbon::setLocale('ru');

            $t_allowed = \Carbon\Carbon::parse($timestamp);

            $user_name = $value == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['name'] : $item[0]['receiver_message']['name'];
            $receiver_id = $value == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['id'] : $item[0]['receiver_message']['id'];
            $surname = $value == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['surname'] : $item[0]['receiver_message']['surname'];
//            dd($item);
//            $product_id = $item[0]['tender_order_message']['room_id'];
            $room_id = $item[0]['room_id'];
            $user_image = $value == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['photo'] : $item[0]['receiver_message']['photo'];
//            $product_headline = $item[0]['order_message']['date_time'];
//            $product_name = $item[0]['order_message']['name'];
            //      $product_price = $item[0]['products']['price'];


            $image = $item[0]['file'];

            $review = $review_count->sum('status');

            $messages = $item[0]["message"];

            $right_side_data[] = [
                'user_name' => $user_name,
                'surname' => $surname,
                'room_id' => $room_id,
//                'tender_name' => $product_name,
                'user_image' => $user_image,
//                'tender_data' => $product_headline,
//                'product_price' => $product_price,
                'messages' => $messages,
                'image' => $image,
                'receiver_id' => $receiver_id,
                'review' => $review,
                'created_at' => $t_allowed->diffForHumans()
            ];

            $get_message = Message::with('SenderMessage', 'ReceiverMessage')->where('room_id', $id)->get();


//        $update = Message::where('room_id', $request->data_id)->where('receiver_id',auth()->user()->id)->update(['status'=> 0]);

//        $get_count = Message::where('receiver_id' , auth()->user()->id)->sum('status');

            \Carbon\Carbon::setLocale('ru');
            foreach ($get_message as $time) {
                $time['time'] = $time['created_at']->diffForHumans();
            }






        }
        return view('admin.UsersChat.2usersChat', compact('get_message','right_side_data'));
    }
}
