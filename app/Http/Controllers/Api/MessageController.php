<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\JobInvite;
use App\Models\Notification;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\ActiveJob;
use App\Models\OrderTender;
use App\Models\HistoryInvite;
use App\Models\AdminNotification;
use App\Events\NewMessageEvent;

class MessageController extends Controller
{


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/createMessage",
     * summary="createMessage",
     * description="createMessage",
     * operationId="createMessage",
     * tags={"Message"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="receiver_id", type="string", format="receiver_id", example="1"),
     *   @OA\Property(property="message", type="string", format="message", example="Грузо-перевозки"),
     *   @OA\Property(property="file", type="file", format="file", example="photo.png"),
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

    public function createMessage(Request $request){


//        if( $request->message == null || $request->file == null ){
//            return response()->json([
//                'status'=> false,
//                'data' => [
//                    'message' => 'file or message required',
//                ],
//            ],422);
//        }



        $get_chat = Message::where('sender_id',auth()->user()->id)->where('receiver_id' , $request->receiver_id )->first();



        if($get_chat == null){
            $get_chat = Message::where('sender_id', $request->receiver_id )->where('receiver_id' ,auth()->user()->id)->first();
        }

    if($get_chat == null){
       $chat_rum = time();
    }else{
        $chat_rum = $get_chat->room_id;
    }
        if(isset($request->file)){
            $file = $request->file;
            $time = time();
            foreach ($file as $files){
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
                    Carbon::setLocale('ru');
                    $count = Message::where('receiver_id',1)->sum('status');
                    $message = [
                        'message' => $create_message->message,
                        'sender_id'   => $create_message->sender_id,
                        'receiver_id'  => $create_message->receiver_id,
                        'room_id' => $create_message->room_id,
                        'file' => $files,
                        'status' => $create_message->status,
                        'name' => auth()->user()->name,
                        'user_id' => auth()->user()->id,
                        'photo' => auth()->user()->photo,
                        'time' => Carbon::now()->diffForHumans(),
                        'sum' => $count
                    ];
                    event(New  NewMessageEvent($message));
                }

            }
        }else{
            $create_message =  Message::create([
                'sender_id'     => auth()->user()->id,
                'receiver_id'    => $request->receiver_id,
                'room_id'        => $chat_rum,
                'message'        => $request->message,
                'status'         => 1,
            ]);

            Carbon::setLocale('ru');



            if($request->receiver_id == 1){
                $count = Message::where('receiver_id',1)->sum('status');

                $message = [
                    'message' => $create_message->message,
                    'sender_id'   => $create_message->sender_id,
                   'receiver_id'  => $create_message->receiver_id,
                    'room_id' => $create_message->room_id,
                     'message' => $create_message->message,
                    'status' => $create_message->status,
                    'name' => auth()->user()->name,
                    'user_id' => auth()->user()->id,
                    'photo' => auth()->user()->photo,
                    'time' => Carbon::now()->diffForHumans(),
                    'sum' => $count
                ];

                event(New  NewMessageEvent($message));
            }
        }



        return response()->json([
            'status'=> true,
            'data' => [
                'message' => 'message created',
            ],
        ],200);
    }


    /**
     * @OA\Get(
     *      path="http://80.78.246.59/Stech/public/api/ChatUser",
     *      operationId="ChatUser",
     *      tags={"Message"},
     *      summary="Get list of ChatUser",
     *      description="Returns list of ChatUser",
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

    public function ChatUser(Request $request){

        $usersChat = Message::query()->where(function ($query) {
            $query->where([
                'sender_id' => auth()->id(),
            ])->orWhere([
                'receiver_id' => auth()->id(),
            ]);
        })
            ->with(['SenderMessage', 'ReceiverMessage'])
            ->orderBy('created_at')
            ->get()
            ->groupBy('room_id')
            ->toArray();




        $right_side_data = [];


        foreach ($usersChat as $item) {

            $review_count = collect($item);

            $user_name = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['name'] : $item[0]['receiver_message']['name'];
            $receiver_id = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['id'] : $item[0]['receiver_message']['id'];

//            dd($item);
//            $product_id = $item[0]['tender_order_message']['id'];
            $user_image = auth()->id() == $item[0]['receiver_message']['id'] ? $item[0]['sender_message']['photo'] : $item[0]['receiver_message']['photo'];
//            $product_headline = $item[0]['order_message']['date_time'];
//            $product_name = $item[0]['order_message']['name'];
            //      $product_price = $item[0]['products']['price'];

            $image = $item[0]['file'];
            $review = $review_count->sum('status');

            $messages = $item[0]["message"];

            $right_side_data[] = [
                'user_name' => $user_name,
//                'tender_id' => $product_id,
//                'tender_name' => $product_name,
                'user_image' => $user_image,
//                'tender_data' => $product_headline,
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


//        $user_id = auth()->user()->id;
//        $chat_data = [];
//        $data = [];
//
//        $usersChat = Message::query()->where(function ($query) {
//            $query->where([
//                'sender_id' => auth()->id(),
//            ])->orWhere([
//                'receiver_id' => auth()->id(),
//            ]);
//        })
//            ->with('SenderMessage', 'ReceiverMessage')
//            ->orderBy('created_at', 'DESC')
//            ->get();
//
////            ->toArray();
//
////        $invoices = Message::where('receiver_id', auth()->user()->id)->where('status', 1)->count();
////        dd($invoices );
//
//
//        foreach ($usersChat as $asd) {
//
//
//                if ($asd['receiver_id'] == auth()->user()->id){
//
//                    $asd['receiver_message'] = $asd['sender_message'];
//                    $asd['receiver_id'] = $asd['sender_id'];
//                    $asd['sender_id'] = auth()->user()->id;
//
//                    unset($asd['sender_message']);
//                }else{
//                    unset($asd['sender_message']);
//                }
//                $send_blade[] = $asd;
//        }
//        if (isset($send_blade)){
//            $usersChat = collect($send_blade);
//            $usersChat = $usersChat->unique('receiver_id');
//        }
//
//
//
//        if($usersChat == null){
//            return response()->json([
//                'status'=> false,
//                'data' => [
//                    'message' => 'no chat',
//                ],
//            ],422);
//        }else{
//            return response()->json([
//                'status'=> true,
//                'data' => [
//                    'users' => $usersChat,
//                ],
//            ],200);
//        }
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/OnePageMessage",
     * summary="OnePageMessage",
     * description="OnePageMessage",
     * operationId="OnePageMessage",
     * tags={"Message"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="receiver_id", type="string", format="receiver_id", example="1"),
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

    public function OnePageMessage(Request $request){
        $get_jpb_invite = JobInvite::where('receiver_id', $request->receiver_id)
            ->where('sender_id',auth()->user()->id)
            ->where('status', 1)
            ->orWhere('status',2)
            ->get();

        if($get_jpb_invite->isEMpty()){
            $asd = 'no invite';
        }else{
            $asd = 'yes invite';
         }
       $get_masage = Message::with('ReceiverMessage', 'SenderMessage')->
       where('sender_id' , auth()->user()->id)->where('receiver_id' , auth()->user()->id)
       ->orWhere(['receiver_id' => $request->receiver_id, 'sender_id' => $request->receiver_id])->get();

        $get_masages = Message::with('ReceiverMessage', 'SenderMessage')->
        where('sender_id' , auth()->user()->id)->where('receiver_id' , auth()->user()->id)
            ->orWhere(['receiver_id' => $request->receiver_id, 'sender_id' => $request->receiver_id])->update(['status'=>0]);

        return response()->json([
            'status'=> true,
            'data' => [
                'invete' => $asd,
                'message' => $get_masage,
            ],
        ],200);
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/addNewInvite",
     * summary="addNewInvite",
     * description="addNewInvite",
     * operationId="addNewInvite",
     * tags={"Invite"},
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

    public function addNewInvite(Request $request){

        $create_notfication = Notification::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'tender_id' => $request->tender_id,
            'message' => 'Job Invite',
            'status' => 1
        ]);


        $create_invite = JobInvite::create([
           'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'tender_id' => $request->tender_id,
            'status' => 1
        ]);
        return response()->json([
            'status'=> true,
            'message' =>  'invite created',
        ],200);

    }



    /**
     * @OA\Get(
     *      path="http://80.78.246.59/Stech/public/api/getRoleId3Invite",
     *      operationId="getRoleId3Invite",
     *      tags={"Invite"},
     *      summary="Get list of getRoleId3Invite",
     *      description="Returns list of getRoleId3Invite",
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

    public function getRoleId3Invite(){
        $get_jpb_invite = JobInvite::where('receiver_id', auth()->user()->id)->where('status',1)->first();

        if($get_jpb_invite->tender_id != null){
            $get_tender = OrderTender::where('id',$get_jpb_invite->tender_id)->first();
            if($get_tender == null){
                $name = 'null';
            }else{
                $name = $get_tender->name;
            }
        }else{
            $name = 'null';
        }


       if($get_jpb_invite != null ){
           $get_user = User::where('id', $get_jpb_invite->sender_id)->first();
           $data = [
               'tender_name' => $name,
               'sender_id' => $get_user->id,
               'sender_name' => $get_user->name,
               'sender_surname' => $get_user->surname
           ];
           return response()->json([
               'status'=> true,
               'data' => [
                   $data
               ],
           ],200);
       }else{
           return response()->json([
               'status'=> false,
               'message' => [
                   'no invite'
               ],
           ],422);
       }
    }

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/SuccsesInvite",
     * summary="SuccsesInvite",
     * description="SuccsesInvite",
     * operationId="SuccsesInvite",
     * tags={"Invite"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="sender_id", type="string", format="sender_id", example="1"),

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

    public function SuccsesInvite(Request $request){

                if(isset($request->tender_id)){
                    $tender_id = $request->tender_id;

                    $update_tender_status = OrderTender::where('id', $request->tender_id)->update(['status' => 2]);
                }else{
                    $tender_id = 'null';
                }

            $get_user = User::with('UserTransport')->where('id', auth()->user()->id)->first();

            if($get_user->UserTransport[0]->sub_category_id != null){
                $get_category = SubCategory::where('id', $get_user->UserTransport[0]->sub_category_id)->first();
            }else{
                $get_category = Category::where('id', $get_user->UserTransport[0]->category_id )->first();
            }
            $create_jobs = ActiveJob::create([
                'sender_id' => $request->sender_id,
                'receiver_id' => auth()->user()->id,
                'tender_id' => $tender_id,
                'status' => 1,
                'type' =>   $get_category->type,
                'price' => $get_category->price
            ]);
            $crete_notification = Notification::create([
               'sender_id' => auth()->user()->id,
               'receiver_id' => $request->sender_id,
               'message' => 'Пользователь принял ваше приглашение',
                'status' => 1
            ]);

            $update_invite =  JobInvite::where('id', $request->invite_id)->update(['status'=>2]);

            return response()->json([
                'status'=> true,
                'data' => [
                    'job_id' => $create_jobs->id,
                    'message' => 'succsesed invite',
                    'type' => $get_category->type,
                    'price' => $get_category->price
                ],
            ],200);
    }

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/deleteInvite",
     * summary="deleteInvite",
     * description="deleteInvite",
     * operationId="deleteInvite",
     * tags={"Invite"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="sender_id", type="string", format="sender_id", example="1"),
     *       @OA\Property(property="invite_id", type="string", format="invite_id", example="1"),

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

    public function deleteInvite(Request $request){

        $get_invite =   JobInvite::where('id', $request->invite_id)->first();

        $createHistory = HistoryInvite::create([
           'sender_id' => $get_invite->sender_id,
           'receiver_id' => $get_invite->receiver_id,
           'tender_id' => $get_invite->tender_id,
           'status' => 1
        ]);

        $createAdminNotification = AdminNotification::create([
            'sender_id' => $get_invite->sender_id,
            'receiver_id' => $get_invite->receiver_id,
            'message' => 'Исполнитель отклонил прглашения',
            'status' => 1
        ]);





        $dellete_invite = JobInvite::where('receiver_id', auth()->user()->id)->where('sender_id', $request->sender_id)->delete();
        $create_notification =  Notification::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->sender_id,
            'message' => 'Пользователь отклонил ваше приглашение',
        ]);

        return response()->json([
            'status'=> true,
            'data' => [
                'message' => 'dangered invite',
            ],
        ],200);
    }






}
