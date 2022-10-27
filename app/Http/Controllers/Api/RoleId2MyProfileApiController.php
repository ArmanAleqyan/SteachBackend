<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use App\Models\NewNumberUser;
use GreenSMS\GreenSMS;

class RoleId2MyProfileApiController extends Controller
{

    /**
     * @OA\Get(
     *      path="/RoleId2MyProfile",
     *      operationId="RoleId2MyProfile",
     *      tags={"Role_id_2_Profile"},
     *      summary="Get list of GetMyBrone",
     *      description="Returns list of GetMyBrone",
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

    public function RoleId2MyProfile(){

        if(auth()->user()->role_id == 2){
            return response()->json([
                'status'=>true,
                'message' => [
                    'tariff_plus' => auth()->user()->tariff_plus,
                    'role_id' => auth()->user()->role_id,
                    'user' => auth()->user(),
                ],
            ],200);
        }
        if(auth()->user()->role_id == 3){
                $get_user =  User::with('RoleId3Reviews')->where('id', auth()->user()->id)->get();
            return response()->json([
                'status'=>true,
                'message' => [
                    'role_id' => auth()->user()->role_id,
                    'user' => $get_user,
                ],
            ],200);
        }
    }

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/updateRoleId2MyProfile",
     * summary="updateRoleId2MyProfile",
     * description="updateRoleId2MyProfile",
     * operationId="updateRoleId2MyProfile",
     * tags={"Role_id_2_Profile"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="name", type="string", format="name", example="User"),
     *       @OA\Property(property="surname", type="string", format="surname", example="Useryan"),
     *       @OA\Property(property="region", type="region", format="region", example="region"),
     *       @OA\Property(property="region_id", type="region_id", format="region_id", example="region_id"),
     *       @OA\Property(property="city", type="city", format="city", example="city"),
     *       @OA\Property(property="city_id", type="city_id", format="city_id", example="city_id"),
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


    public function updateRoleId2MyProfile(Request $request){
//        $rules=array(
//            'name'  =>"required",
//            'surname'  =>"required",
//            'region' => 'required',
//            'region_id' => 'required',
//            'city' => 'required',
//            'city_id' => 'required',
//        );
//        $validator=Validator::make($request->all(),$rules);
//        if($validator->fails())
//        {
//            return $validator->errors();
//        }


        $update_user = User::where('id', auth()->user()->id);

        if(isset($request->name)){
            $update_user->update([
                'name' => $request->name
            ]);

       if(isset($request->surname)){
           $update_user->update([
               'surname' => $request->surname
           ]);
       }

       if(isset($request->region)){
           $update_user->update([
               'region' => $request->region
           ]);
       }

       if(isset($request->region_id)){
           $update_user->update([
               'region_id' => $request->region_id
           ]);
       }

       if(isset($request->city)){
           $update_user->update([
               'city' => $request->city
           ]);
       }

            if(isset($request->city_id)){
                $update_user->update([
                    'city_id' => $request->city_id
                ]);
            }
        }

        return response()->json([
            'status'=>true,
            'message' => [
                'tariff_plus' => auth()->user(),
                'role_id' => auth()->user()->role_id,
                'user' => auth()->user(),
            ],
        ],200);
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/UpdateRoleId2Phone",
     * summary="UpdateRoleId2Phone",
     * description="UpdateRoleId2Phone",
     * operationId="UpdateRoleId2Phone",
     * tags={"Role_id_2_Profile"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="old_phone", type="string", format="name", example="old_phone"),

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

    public function UpdateRoleId2Phone(Request $request){

        $rules=array(
            'old_phone'  =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }


       $get_user = User::where('id', auth()->user()->id)->where('phone', $request->old_phone)->first();

       if($get_user == null ){
           return response()->json([
               'status'=>false,
               'message' => [
                        'message' => 'wrong number'
               ],
           ],422);
       }else{
           return response()->json([
               'status'=>true,
               'message' => [
                   'message' => 'succses number'
               ],
           ],200);
       }
    }

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/SendCallNewNumberRoleid2",
     * summary="SendCallNewNumberRoleid2",
     * description="SendCallNewNumberRoleid2",
     * operationId="SendCallNewNumberRoleid2",
     * tags={"Role_id_2_Profile"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="new_phone", type="string", format="name", example="new_phone"),

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


    public function SendCallNewNumberRoleid2(Request $request){
        $rules=array(
            'new_phone'  =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }





         $get_new_number = NewNumberUser::where('user_id', auth()->user()->id)->first();

        if($get_new_number->created_at > Carbon::now()->subMinutes(1) || $get_new_number->updated_at > Carbon::now()->subMinutes(1)){
            return response()->json([
                'status'=>false,
                'message' => [
                    'message' => 'send 1 minute ago'
                ],
            ],422);
        }else{
            $phone =     preg_replace('/[+]/', '', $request->new_phone);
            $client = new GreenSMS(['user' => 'lnpxodnywpxrqjwirw','pass' => 'password']);
            $response = $client->call->send(['to' => $phone]);

            if($get_new_number == null){
                $create_new_number =  NewNumberUser::create([
                    'user_id' => auth()->user()->id,
                    'phone' => $request->new_phone,
                    'code' => $response->code
                ]);
                return response()->json([
                    'status'=>true,
                    'message' => [
                        'message' => 'code send your phone'
                    ],
                ],200);
            }else{
                $get_new_number = NewNumberUser::where('user_id', auth()->user()->id)->delete();
                $create_new_number =  NewNumberUser::create([
                    'user_id' => auth()->user()->id,
                    'phone' => $request->new_phone,
                    'code' => $response->code
                ]);
                return response()->json([
                    'status'=>true,
                    'message' => [
                        'message' => 'code send your phone'
                    ],
                ],200);
            }
        }
    }

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/CompareCodeNewNumber",
     * summary="CompareCodeNewNumber",
     * description="CompareCodeNewNumber",
     * operationId="CompareCodeNewNumber",
     * tags={"Role_id_2_Profile"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="new_phone", type="string", format="name", example="new_phone"),

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


    public function CompareCodeNewNumber(Request $request){
        $rules=array(
            'code'  =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }

        $get_code = NewNumberUser::where('code', $request->code)->where('user_id', auth()->user()->id)->first();

        if($get_code == null){
            return response()->json([
                'status'=>false,
                'message' => [
                    'message' => 'wrong code'
                ],
            ],422);
        }else{
            $update_user = User::where('id', auth()->user()->id)->update([
               'phone' => $get_code->phone
            ]);
            $get_code = NewNumberUser::where('code', $request->code)->where('user_id', auth()->user()->id)->delete();
            return response()->json([
                'status'=>true,
                'message' => [
                    'message' => 'phone updated'
                ],
            ],200);
        }
    }



    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/RoleId2Updateavatar",
     * summary="RoleId2Updateavatar",
     * description="RoleId2Updateavatar",
     * operationId="RoleId2Updateavatar",
     * tags={"Role_id_2_Profile"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="avatar", type="file", format="file", example="photo.png"),

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


    public function RoleId2Updateavatar(Request $request){

        $avatar = $request->file('avatar');

        if(isset($avatar)){

            $destinationPath = 'uploads';
            $originalFile = time() . $avatar->getClientOriginalName();
            $avatar->storeas($destinationPath, $originalFile);
            $avatar = $originalFile;

            $update_avatar = User::where('id', auth()->user()->id)->update(['photo' => $avatar]);
            return response()->json([
                'status'=>true,
                'message' => [
                    'message' => 'photo updated',
                    'avatar' => $avatar
                ],
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message' => [
                    'message' => 'no updated',

                ],
            ],422);
        }
    }

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/RoleId2UpdateEmail",
     * summary="RoleId2UpdateEmail",
     * description="RoleId2UpdateEmail",
     * operationId="RoleId2UpdateEmail",
     * tags={"Role_id_2_Profile"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email"},
     *       @OA\Property(property="email", type="email", format="email", example="email"),
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

    public function RoleId2UpdateEmail(Request $request){
        $rules=array(
            'email'  => "email|unique:users",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }


        if(isset($request->email)){
            $update = User::where('id', auth()->user()->id)->update(['email' => $request->email]);
            return response()->json([
                'status'=>true,
                'message' => [
                    'message' => 'email updated',

                ],
            ],200);

        }

    }
}
