<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserUpdatePasswordController extends Controller
{


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/userUpdatePassword",
     * summary="userUpdatePassword",
     * description="userUpdatePassword",
     * operationId="userUpdatePassword",
     * tags={"User Update Password"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="old_password", type="string", format="name", example="old_password"),
     *       @OA\Property(property="password", type="string", format="name", example="password"),
     *       @OA\Property(property="password_confirmation", type="string", format="name", example="password_confirmation"),
     *
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

    public function userUpdatePassword(Request $request){
        $rules=array(
            'old_password'  =>"required",
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }
        $password = auth()->user()->password;

        $check = Hash::check($request->old_password,$password);

            if($check == false){
                return response()->json([
                    'status'=>false,
                    'message' => [
                        'message' => 'wrong password'
                    ],
                ],422);
            }
            if($check == true){
                $update_password = User::where('id', auth()->user()->id)->update([
                   'password' => Hash::make($request->password),
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
