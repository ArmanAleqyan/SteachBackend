<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ActiveJob;
use App\Models\Notification;
use App\Models\HistoryTransfers;


class ActiveJobController extends Controller
{


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/StartJob",
     * summary="StartJob",
     * description="StartJob",
     * operationId="StartJob",
     * tags={"Jobs"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="job_id", type="string", format="job_id", example="1"),
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

        public function StartJob(Request $request){
            $data = Carbon::now();
            $update_job = ActiveJob::where('id', $request->job_id)->update([
               'start_job' => $data,
                'status' => 2,
            ]);
            $get_parametrs = ActiveJob::where('id', $request->job_id)->first();
            $update_user_status = User::where('id', auth()->user()->id)->update([
                'active' => 1,
            ]);

            $create_notification = Notification::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $get_parametrs->sender_id,
                'message' => 'User Start Job',
                'status' => 1
            ]);

            return response()->json([
                'status'=> true,
                'data' => [
                    'message' => 'user started job',
                ],
            ],200);
        }


        public function endJob(Request $request){
            if(isset($request->type) && $request->type == 'time'){
                $data = Carbon::now();
                $update_job = ActiveJob::where('id', $request->job_id)->update([
                    'end_job' => $data,
                    'status' => 3,
                ]);
                $get_parametrs = ActiveJob::where('id', $request->job_id)->first();
                $create_notification = Notification::create([
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $get_parametrs->sender_id,
                    'message' => 'User End Job',
                    'status' => 1,
                    'job_id' => $get_parametrs->id
                ]);


                $start_time =   strtotime($get_parametrs->start_job);
                $end_time = strtotime($get_parametrs->end_job);
                $time = $end_time - $start_time;

                //dd($time);
                $asd  = $time / 86400;
                $hours = floor($asd);
                $minits =

                $price = $get_parametrs->price;
                $secs = $time % 60;
                $hrs = $time / 60;
                $mins = $hrs % 60;
                $hrs = $hrs / 60;

                $time = ( (int)$hrs . ":" . (int)$mins . ":" . (int)$secs);
//            dd($time);
                $many = $hrs*$price + $mins*($price/60) + $secs*($price/3600);
//            dd($many);
                $pracient = $many / 100 * 10;
//            dd($pracient);

                $get_user = User::where('id', auth()->user()->id)->first();

//            $get_user->balance -  $pracient;
                $data = \Location::get($request->ip());
                $get_user->update([
                    'balance' => ceil($get_user->balance -  $pracient),
                    'active' => 2,
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                ]);


                $create_history_transfer = HistoryTransfers::create([
                    'user_id' => auth()->user()->id,
                    'time' => $time,
                    'price' => $many,
                    'pracient' => $pracient,
                    'job_id' => $get_parametrs->id
                ]);
                
                return response()->json([
                    'status'=> true,
                    'data' => [
                        'time' => $time,
                        'price' => $many,
                        'pracient' => $pracient,
                        'message' => 'user end job',
                    ],
                ],200);
            }

        }
}
