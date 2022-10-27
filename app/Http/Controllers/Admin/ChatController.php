<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Cookie;

class ChatController extends Controller
{

    public function AdminSendMessage(Request $request){

        $get_chat = Message::where('sender_id',auth()->user()->id)->where('receiver_id' , $request->receiver_id )->first();



        if($get_chat == null){
            $get_chat = Message::where('sender_id', $request->receiver_id )->where('receiver_id' ,auth()->user()->id)->first();
        }
        if($get_chat == null){
            $chat_rum = time();
        }else{
            $chat_rum = $get_chat->room_id;
        }


        Message::create([
            'room_id' => $chat_rum,
            'sender_id' =>auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'status' => 1
        ]);

        return redirect()->back()->with('messageCreated', 'messageCreated');
    }

    public function ChatBlade(){
        $usersChat = Message::query()->where(function ($query) {
            $query->where([
                'sender_id' => auth()->id(),
            ])->orWhere([
                'receiver_id' => auth()->id(),
            ]);
        })
            ->with(['SenderMessage', 'ReceiverMessage'])
            ->orderBy('created_at','DESC')
            ->get()
            ->groupBy('room_id')
            ->toArray();


        $data_id = Cookie::get('data_id');

        $get_message = Message::with('SenderMessage', 'ReceiverMessage')->where('room_id', $data_id)->get();





        $update = Message::where('room_id', $data_id)->where('receiver_id',auth()->user()->id)->update(['status'=> 0]);

        $get_count = Message::where('receiver_id' , auth()->user()->id)->sum('status');

        \Carbon\Carbon::setLocale('ru');
        foreach ($get_message as $time){
            $time['time'] =  $time['created_at']->diffForHumans();
        }




        $right_side_data = [];


        foreach ($usersChat as $item) {

            $review_count = collect($item);
            $review_count = $review_count->where('receiver_id', auth()->user()->id);
            $created_at =  $review_count->last();
            if(!$review_count->isEMpty()){
                $created_at = $created_at['created_at'];
            }




            $timestamp = strtotime($created_at);

            $created_at = date('d-m-y H:i',$timestamp);
            \Carbon\Carbon::setLocale('ru');

            $t_allowed = \Carbon\Carbon::parse($timestamp);

            $user_name = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['name'] : $item[0]['receiver_message']['name'];
            $receiver_id = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['id'] : $item[0]['receiver_message']['id'];
            $surname = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['surname'] : $item[0]['receiver_message']['surname'];
//            dd($item);
//            $product_id = $item[0]['tender_order_message']['room_id'];
             $room_id =  $item[0]['room_id'];
            $user_image = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['photo'] : $item[0]['receiver_message']['photo'];
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
        }








        return view('admin.Chat.Chat' ,compact('right_side_data','data_id', 'get_count','get_message'));
    }

     public function getRoomId(Request $request){


        $get_message = Message::with('SenderMessage', 'ReceiverMessage')->where('room_id', $request->data_id)->get();
//         Cookie::make('name', $request->data_id, 60);
//         Cookie::queue('data_id', $request->data_id, 800);


        $update = Message::where('room_id', $request->data_id)->where('receiver_id',auth()->user()->id)->update(['status'=> 0]);

        $get_count = Message::where('receiver_id' , auth()->user()->id)->sum('status');

         \Carbon\Carbon::setLocale('ru');
        foreach ($get_message as $time){
           $time['time'] =  $time['created_at']->diffForHumans();
        }


        return response()->json([
            'status' => true,
            'sum' => $get_count,
            'data' => $get_message
        ]);
     }

    public function createMessage(Request $request){


        if( $request->message == null && $request->file == 'undefined' ){
            return response()->json([
                'status'=> false,
                'data' => [
                    'message' => 'file or message required',
                ],
            ],422);
        }





        $get_chat = Message::where('sender_id',auth()->user()->id)->where('receiver_id' , $request->receiver_id )->first();



        if($get_chat == null){
            $get_chat = Message::where('sender_id', $request->receiver_id )->where('receiver_id' ,auth()->user()->id)->first();
        }



        if($get_chat == null){
            $chat_rum = time();
        }else{
            $chat_rum = $get_chat->room_id;
        }


        if( $request->file != "undefined"){
            $files = $request->file;
            $time = time();
                $destinationPath = 'uploads';
                $originalFile = $time++ . $files->getClientOriginalName();
                $files->storeas($destinationPath, $originalFile);
                $files = $originalFile;

                $create_message =  Message::create([
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $request->receiver_id,
                    'room_id' => $chat_rum,
                    'message' => $request->message,
                    'status' => 1,
                    'file' => $files
                ]);
                if($request->receiver_id == 1){
                    $message =   $create_message;
                    event(New  NewMessageEvent($message));
                }

        }else{
            $create_message =  Message::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->receiver_id,
                'room_id' => $chat_rum,
                'message' => $request->message,
                'status' => 1,
            ]);
            if($request->receiver_id == 1){
                $message =   $create_message;
                event(New  NewMessageEvent($message));
            }
        }

        \Carbon\Carbon::setLocale('ru');




        $data = [
            'file' => $create_message->file,
            'message' => $create_message->message,
            'name' => auth()->user()->name,
            'photo' => auth()->user()->photo,
            'created_at' => $create_message->created_at->diffForHumans()
        ];



        return response()->json([
            'status'=> true,
            'data' => [
                'message' => 'message created',
                'data' => $data
            ],
        ],200);
    }



    public function SearchLeftUsers(Request $request){

        $usersChat = Message::query()->where(function ($query) {
            $query->where([
                'sender_id' => auth()->id(),
            ])->orWhere([
                'receiver_id' => auth()->id(),
            ]);
        })->whereRelation('SenderMessage', 'name', 'like', '%'.$request->name.'%')
            ->with(['SenderMessage', 'ReceiverMessage'])
            ->orderBy('created_at','DESC')
            ->get()
            ->groupBy('room_id')
            ->toArray();




        $right_side_data = [];


        foreach ($usersChat as $item) {

            $review_count = collect($item);
            $review_count = $review_count->where('receiver_id', auth()->user()->id);
            $created_at =  $review_count->last();
            $created_at = $created_at['created_at'];

            $timestamp = strtotime($created_at);

            $created_at = date('d-m-y H:i',$timestamp);
            \Carbon\Carbon::setLocale('ru');

            $t_allowed = \Carbon\Carbon::parse($timestamp);

            $user_name = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['name'] : $item[0]['receiver_message']['name'];
            $receiver_id = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['id'] : $item[0]['receiver_message']['id'];
            $surname = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['surname'] : $item[0]['receiver_message']['surname'];
//            dd($item);
//            $product_id = $item[0]['tender_order_message']['room_id'];
            $room_id =  $item[0]['room_id'];
            $user_image = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['photo'] : $item[0]['receiver_message']['photo'];
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
        }






        return response()->json([
            'status'=> true,
            'data' => [$right_side_data,],
        ],200);
    }



}


