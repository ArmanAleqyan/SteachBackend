<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;
use GreenSMS\GreenSMS;
use Illuminate\Support\Facades\Hash;
use Validator;

class LoginApiController extends Controller
{

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/userlogin",
     * summary="userlogin",
     * description="userlogin",
     * operationId="userlogin",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="phone", type="string", format="phone", example="+37493073584"),
     *   @OA\Property(property="password", type="string", format="phone_code", example="11111111"),
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

    public function userlogin(UserLoginRequest $request){

        $get_user = User::where('phone', $request->phone)->first();




        if($get_user == null){
            return response()->json([
                'status'=>FALSE,
                'message' => [
                    'message' => 'wrong user',
                ],
            ],422);
        }


        $login = $request->all();
        if($get_user->status == 2){
            return response()->json([
                'status'=>FALSE,
                'message' => [
                    'message' => 'Пожалуйста подождите пока администратор одобрит вас',

                ],
            ],422);
        }
        if($get_user->status == 1){
            $user = Auth::attempt($login);


            $token = $get_user->createToken('Laravel Password Grant Client')->accessToken;
            return response()->json([
                'status'=>true,
                'message' => [
                    'token' => $token,
                    'user' => $get_user,

                ],
            ],200);
        }
    }

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/userlogout",
     * summary="userlogout",
     * description="userlogout",
     * operationId="userlogout",
     * tags={"Auth"},
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
    public function userlogout(){
        $update_active = User::where('id' ,auth()->guard('api')->user()->id)->update(['active'=> 2]);
                auth()->logout();

        return response()->json([
            'status'=>true,
            'message' => [
                   'message' => 'user logouted'
            ],
        ],200);
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/sendcodeforgotpassword",
     * summary="sendcodeforgotpassword",
     * description="sendcodeforgotpassword",
     * operationId="sendcodeforgotpassword",
     * tags={"Auth"},
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


    public function sendcodeforgotpassword(Request $request){
        $rules=array(
            'phone'  =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }

        $get_user =  User::where('phone', $request->phone)->first();

        if($get_user->created_at > Carbon::now()->subMinutes(1) || $get_user->updated_at > Carbon::now()->subMinutes(1)) {
            return response()->json([
                'status' => false,
                'message' => [
                    'message' => 'send 1 minute ago'
                ],
            ], 422);
        }


        if($get_user == null){
            return response()->json([
                'status'=>false,
                'message' => [
                    'message' => 'no number'
                ],
            ],422);
        }else{
        $phone =     preg_replace('/[+]/', '', $request->phone);
        $client = new GreenSMS(['user' => 'lnpxodnywpxrqjwirw','pass' => 'password']);

        $response = $client->call->send(['to' => $phone]);

        $get_user->update([
            'reset_password_code' => $response->code
        ]);
            return response()->json([
                'status'=>true,
                'message' => [
                    'phone' => $request->phone,
                    'code' => 'code sending yor phone'
                ],
            ],200);
        }
    }



    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/comparecoderesetpassword",
     * summary="comparecoderesetpassword",
     * description="comparecoderesetpassword",
     * operationId="comparecoderesetpassword",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="phone", type="string", format="phone", example="+37493073584"),
     *   @OA\Property(property="reset_password_code", type="string", format="reset_password_code", example="1111"),
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



    public function comparecoderesetpassword(Request $request){
        $rules=array(
            'phone' => 'required',
            'reset_password_code'  =>"required|min:4",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }


        $get_user = User::where('phone', $request->phone)->where('reset_password_code',$request->reset_password_code)->first();

        if($get_user == null){
            return response()->json([
                'status'=>false,
                'message' => [
                    'message' => 'not exist veryfi code'
                ],
            ],422);
        }else{
            return response()->json([
                'status'=>true,
                'message' => [
                    'message' => 'code sucsesfuly'
                ],
            ],200);
        }

    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/updatePasswordResetPassword",
     * summary="updatePasswordResetPassword",
     * description="updatePasswordResetPassword",
     * operationId="updatePasswordResetPassword",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="phone", type="string", format="phone", example="+37493073584"),
     *   @OA\Property(property="reset_password_code", type="string", format="reset_password_code", example="1111"),
     *   @OA\Property(property="password", type="string", format="password", example="111111"),
     *   @OA\Property(property="password_confirmation", type="string", format="password", example="111111"),
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


    public function updatePasswordResetPassword(Request $request){
        $rules=array(
            'phone' => 'required',
            'reset_password_code'  =>"required|min:4",
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }

        $get_user = User::where('phone', $request->phone)->where('reset_password_code' , $request->reset_password_code)->first();

        if($get_user == NULL){
            return response()->json([
                'status'=>true,
                'message' => [
                    'message' => 'Не делай такие веши  ))))'
                ],
            ],422);
        }else{
            $update_password = User::where('phone', $request->phone)->where('reset_password_code' , $request->reset_password_code)->update([
                'password' => Hash::make($request->password),
                'reset_password_code' => NULL
            ]);

            return response()->json([
                'status'=>true,
                'message' => [
                    'message' => 'password updated'
                ],
            ],200);
        }
    }












}
