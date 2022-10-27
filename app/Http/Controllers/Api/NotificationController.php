<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\RoleId3Reviews;
use App\Models\ActiveJob;
use App\Models\HistoryTransfers;
use App\Models\UserTransport;


class NotificationController extends Controller
{

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/CreateNotification",
     * summary="CreateNotification",
     * description="CreateNotification",
     * operationId="CreateNotification",
     * tags={"Notification"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"tender_id"},
     *       @OA\Property(property="tender_id", type="string", format="tender_id", example="1"),
     *       @OA\Property(property="reciver_id", type="string", format="reciver_id", example="1"),
     *       @OA\Property(property="message", type="string", format="message", example="hello world"),
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



    public function CreateNotification(Request $request){
        $get_notification = Notification::where('sender_id',auth()->user()->id)->where('tender_id',$request->tender_id)->get();
        if($get_notification->isEmpty()){
            $createNotification = Notification::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->receiver_id,
                'message' => $request->message,
                'tender_id' => $request->tender_id,
                'status' => 1
            ]);

            return response()->json([
                'status'=>true,
                'data' => [
                    'receiver_id' => $request->receiver_id,
                    'message' => 'notification created ',
                ],
            ],200);
        }else{
            return response()->json([
                'status'=>true,
                'data' => [
                    'message' => 'you send notification in tender user ',
                ],
            ],422);
        }
    }


    /**
     * @OA\Get(
     *      path="http://80.78.246.59/Stech/public/api/getMyNotoficationRoleId2",
     *      operationId="getMyNotoficationRoleId2",
     *      tags={"Notification"},
     *      summary="Get list of My notification",
     *      description="Returns list of Category",
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

    public function getMyNotoficationRoleId2(){

        $get_my_notification = Notification::
        with('AuthorNotification','TenderNotification')
            ->where('receiver_id',auth()->user()->id)->paginate(10);

        if($get_my_notification->isEmpty()){

            return response()->json([
                'status'=>false,
                'data' => [
                    'message' => 'no notification',
                ],
            ],422);
        }else{

            $COUNT = Notification::with('AuthorNotification','TenderNotification')
                ->where('receiver_id',auth()->user()->id)->where('status',1)->count();

            return response()->json([
                'status'=>true,
                'data' => [
                    'new_notification_count' =>$COUNT,
                    'notification_list' => $get_my_notification,
                ],
            ],200);
        }
    }



    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/AddRoleId3Reviews",
     * summary="AddRoleId3Reviews",
     * description="AddRoleId3Reviews",
     * operationId="AddRoleId3Reviews",
     * tags={"estimates"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="grade", type="string", format="grade", example="1 OR 2 OR 3 OR 4 OR 5"),
     *       @OA\Property(property="receiver_id", type="string", format="receiver_id", example="1"),
     *       @OA\Property(property="message", type="string", format="message", example="hello world"),
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



    public function AddRoleId3Reviews(Request $request){

        $create = RoleId3Reviews::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'grade' => $request->grade,
            'status' => 1
         ]);



        return response()->json([
            'status'=>true,
            'data' => [
                'message' =>  'created estimates',
            ],
        ],200);

    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/singlePageEstimates",
     * summary="singlePageEstimates",
     * description="singlePageEstimates",
     * operationId="singlePageEstimates",
     * tags={"estimates"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="notification_id", type="string", format="notification_id", example="1"),
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

    public function singlePageEstimates(Request $request){


        $notification_id = $request->notification_id;


       $get_notification = Notification::where('id', $notification_id)->first();



       if($get_notification == null){
           return response()->json([
               'status'=>false,
               'data' => [
                   'message' =>  'not job_id',
               ],
           ],422);
       }else{



       $get_job = HistoryTransfers::where('job_id', $get_notification->job_id)->first();

       $get_user = User::where('id', $get_job->user_id)->first();
       $get_user_parametr = UserTransport::where('user_id', $get_job->user_id)->first();


        if($get_user_parametr->category_name != null){
            $category_name = $get_user_parametr->category_name;
        }else{
            $category_name = null;
        }
        if($get_user_parametr->sub_category_name != null){
            $sub_category_name = ', '.$get_user_parametr->sub_category_name;
        }else{
            $sub_category_name = null;
        }
       $data = [
           'user_id' => $get_user->id,
           'user_photo' => $get_user->photo,
           'name' => $get_user->name.' '.$get_user->surname,
           'time_job' => $get_job->time,
           'price' => ceil($get_job->price),
           'type_transport' => $category_name.''.$sub_category_name
       ];

       }
        return response()->json([
            'status'=>true,
            'data' => [
                'user' =>  $data,
            ],
        ],200);
    }
}
