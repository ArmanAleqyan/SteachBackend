<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TenderMessage;
use App\Models\OrderTender;
use App\Models\Notification;
use Illuminate\Http\Request;


class TenderMessagesController extends Controller
{

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/StartChat",
     * summary="StartChat",
     * description="StartChat",
     * operationId="StartChat",
     * tags={"tender"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="receiver_id", type="string", format="receiver_id", example="1"),
     *       @OA\Property(property="tender_id", type="string", format="tender_id", example="2"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(

     *        )
     *     )
     * )
     */


    public function StartChat(Request $request){

        $get_messages = TenderMessage::where('sender_id',auth()->user()->id)->where('tender_id',$request->tender_id)->get();



        if(!$get_messages->isEmpty()){
            return response()->json([
                'status'=> false,
                'data' => [
                    'message' => 'user yes message table',
                ],
            ],422);
        }

        $get_tender = OrderTender::where('id', $request->tender_id)->first();


        if($get_tender  == null){
            return response()->json([
                'status'=> false,
                'data' => [
                    'message' => 'wrong tender_id',
                ],
            ],422);
        }

        $create_new_tender_chat = TenderMessage::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'tender_id' => $request->tender_id,
            'messages' => auth()->user()->name.' '.auth()->user()->surname.' '.'Откликнулся на ваш тендер'.' '.$get_tender->name,
            'status' => 1
        ]);

        $create_notification = Notification::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => auth()->user()->name.' '.auth()->user()->surname.' '.'Откликнулся на ваш тендер'.' '.$get_tender->name,
        ]);


        return response()->json([
            'status'=> true,
            'data' => [
                'message' => 'user started chatTender',
            ],
        ],200);
    }


    /**
     * @OA\Get(
     *      path="http://80.78.246.59/Stech/public/api/getTendersChat",
     *      operationId="getTendersChat",
     *      tags={"tender"},
     *      summary="Get list of getTendersChat",
     *      description="Returns list of getTendersChat",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */


    public function getTendersChat(){
        $usersChat = TenderMessage::query()->where(function ($query) {
            $query->where([
                'sender_id' => auth()->id(),
            ])->orWhere([
                'receiver_id' => auth()->id(),
            ]);

        })
            ->with(['TenderSenderMessage', 'TenderReceiverMessage', 'TenderOrderMessage'])
            ->orderBy('created_at')
            ->get()
            ->groupBy('tender_id')
            ->toArray();


        $right_side_data = [];

        foreach ($usersChat as $item) {

            $review_count = collect($item);

            $user_name = auth()->id() == $item[0]['tender_receiver_message']['id'] ? $item[0]['tender_sender_message']['name'] : $item[0]['tender_receiver_message']['name'];
            $receiver_id = auth()->id() == $item[0]['tender_receiver_message']['id'] ? $item[0]['tender_sender_message']['id'] : $item[0]['tender_receiver_message']['id'];
//            dd($item);
            $product_id = $item[0]['tender_order_message']['id'];
            $user_image = auth()->id() == $item[0]['tender_receiver_message']['id'] ? $item[0]['tender_sender_message']['photo'] : $item[0]['tender_receiver_message']['photo'];
            $product_headline = $item[0]['tender_order_message']['date_time'];
            $product_name = $item[0]['tender_order_message']['name'];
      //      $product_price = $item[0]['products']['price'];

            $image = $item[0]['file'];
            $review = $review_count->sum('status');
            $messages = $item[0]["messages"];

            $right_side_data[] = [
                'user_name' => $user_name,
                'tender_id' => $product_id,
                'tender_name' => $product_name,
                'user_image' => $user_image,
                'tender_data' => $product_headline,
//                'product_price' => $product_price,
                'messages' => $messages,
                'image' => $image,
                'receiver_id' => $receiver_id,
                'review' => $review
            ];
        }
        return response()->json([
            'success' => true,
            'userschatdata' => $right_side_data,
        ], 200);
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/createNewMessageTender",
     * summary="createNewMessageTender",
     * description="createNewMessageTender",
     * operationId="createNewMessageTender",
     * tags={"tender"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="receiver_id", type="string", format="receiver_id", example="1"),
     *       @OA\Property(property="tender_id", type="string", format="tender_id", example="2"),
     *       @OA\Property(property="message", type="string", format="message", example="Hello World"),
     *       @OA\Property(property="file", type="string", format="file", example="photo.png"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(

     *        )
     *     )
     * )
     */

    public function createNewMessageTender(Request $request){


        $get_message = TenderMessage::where('receiver_id', auth()->user()->id)->where('tender_id',$request->tender_id)->get();

        if($get_message->isEmpty()){
            return response()->json([
                'status'=> false,
                'data' => [
                    'message' => 'Подождите пока заказчики ответит вам',
                ],
            ],200);
        }


        if(isset($request->file)) {
            $file = $request->file;
            $time = time();
            foreach ($file as $files) {
                $destinationPath = 'uploads';
                $originalFile = $time++ . $files->getClientOriginalName();
                $files->storeas($destinationPath, $originalFile);
                $files = $originalFile;

                $create_message = TenderMessage::create([
                    'tender_id' => $request->tender_id,
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $request->receiver_id,
                    'messages' => $request->message,
                    'status' => 1,
                    'file' => $files
                ]);
                $fileMessage[] = $create_message;
            }
            return response()->json([
                'status'=> true,
                'data' => [
                    'file' => $fileMessage,
                    'message' => 'message created',
                ],
            ],200);

        }else{
            $create_message = TenderMessage::create([
                'sender_id' =>auth()->user()->id,
                'tender_id' => $request->tender_id,
                'receiver_id' => $request->receiver_id,
                'messages' => $request->messages,
                'status' => 1,
            ]);

            return response()->json([
                'status'=> true,
                'data' => [
                    'file' => $create_message,
                    'message' => 'message created',
                ],
            ],200);
        }
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/singlePageChatTender",
     * summary="singlePageChatTender",
     * description="singlePageChatTender",
     * operationId="singlePageChatTender",
     * tags={"tender"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="receiver_id", type="string", format="receiver_id", example="1"),
     *       @OA\Property(property="tender_id", type="string", format="tender_id", example="2"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(

     *        )
     *     )
     * )
     */

    public function singlePageChatTender(Request $request){

        $user_id = auth()->user()->id;


        $get_chats = TenderMessage::with('TenderSenderMessage','TenderReceiverMessage')->where(['sender_id' => $user_id,'receiver_id' => $request->receiver_id])
            ->OrWhere(['receiver_id'=>$user_id, 'sender_id' =>$request->receiver_id])
            ->where('tender_id' ,$request->tender_id)->update(['status'=> 0]);

        $get_chat = TenderMessage::with('TenderSenderMessage','TenderReceiverMessage')->where(['sender_id' => $user_id,'receiver_id' => $request->receiver_id])
         ->OrWhere(['receiver_id'=>$user_id, 'sender_id' =>$request->receiver_id])
            ->where('tender_id' ,$request->tender_id)->get();


        return response()->json([
            'status'=> true,
            'data' => [
                'single_chat' => $get_chat,
            ],
        ],200);

    }



}
