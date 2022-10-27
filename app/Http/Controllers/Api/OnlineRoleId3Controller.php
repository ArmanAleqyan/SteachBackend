<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OnlineRoleId3Controller extends Controller
{


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/StartOnline",
     * summary="StartOnline",
     * description="StartOnline",
     * operationId="StartOnline",
     * tags={"Active And No Active role_id = 3"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
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



    public function StartOnline(Request $request){

        if(auth()->user()->balance < 0){
            return response()->json([
                'status'=>FALSE,
                'message' => [
                    'message' => 'no many balance',
                ],
            ],422);
        }else{
            $data = \Location::get($request->ip());

            $update_lat_long = User::where('id', auth()->user()->id)->update([
                'latitude' => $data->latitude,
                'longitude' => $data->longitude,
                'active' => 2,
            ]);
            return response()->json([
                'status'=>true,
                'message' => [
                    'message' => 'user is online',
                    'active' => 2,
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                ],
            ],200);


        }
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/isOnlineUser",
     * summary="isOnlineUser",
     * description="isOnlineUser",
     * operationId="isOnlineUser",
     * tags={"Active And No Active role_id = 3"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
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

    public function isOnlineUser(Request $request){

        $data = \Location::get($request->ip());

        $update = User::where('id', auth()->user()->id)->update([
            'active'=> 1,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
        ]);

        return response()->json([
            'status'=>true,
            'message' => [
                'message' => 'user is not  online',
                'active' => 1,
            ],
        ],200);
    }
}
