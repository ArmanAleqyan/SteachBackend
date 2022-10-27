<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\OrderTranzaction;

class OrderTransactionController extends Controller
{

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/OrderTranzaction",
     * summary="OrderTranzaction",
     * description="OrderTranzaction",
     * operationId="OrderTranzaction",
     * tags={"OrderTranzaction"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
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

    public function OrderTranzaction(Request $request){

        $get = OrderTranzaction::where('user_id', auth()->user()->id)->first();
        if($get == null){
            OrderTranzaction::create([
                'user_id' => auth()->user()->id,
                'status' => 1,
            ]);
            User::where('id', auth()->user()->id)->update([
                'tariff_plus' => 1
            ]);
            return response()->json([
                'status'=>true,
                'message' => [
                    'message' => 'Order succsed',
                ],
            ],200);
        }else{
            return response()->json([
                'status'=>true,
                'message' => [
                    'message' => 'yor accaunt  have tariff',
                ],
            ],422);
        }



    }
}
