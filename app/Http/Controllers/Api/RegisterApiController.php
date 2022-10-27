<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\NewRegisterPhone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdditionalEquipmentTransport;
use App\Models\UserTransport;
use App\Models\TexPassportTransport;
use App\Models\PhotoTransport;
use Validator;
use GreenSMS\GreenSMS;
use App\Http\Requests\RegisterRequest;
use App\Events\NewMessageEvent;


class RegisterApiController extends Controller
{

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/newPhoneRegister",
     * summary="newPhoneRegister",
     * description="newPhoneRegister",
     * operationId="newPhoneRegister",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="phone", type="string", format="phone", example="+37493073584"),
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

            public function newPhoneRegister(Request $request){

                $rules=array(
                    'phone'  =>"required|unique:users",
                );
                $validator=Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    return $validator->errors();
                }

                    $get_phone = NewRegisterPhone::where('phone' , $request->phone)
                    ->where('created_at' , '>' , Carbon::now()->subMinutes(1))->get();


                if(!$get_phone->isEMpty()){
                    return response()->json([
                        'status'=>false,
                        'message' => [
                            'message' => 'send call 1 minute ago'
                        ],
                    ],422);
                }

//                $phone =     preg_replace('/[+]/', '', $request->phone);
//                $client = new GreenSMS(['user' => '37493073584','pass' => '150997Arman.']);
//                $response = $client->call->send(['to' => $phone]);
                    $create = NewRegisterPhone::create([
                        'phone' => $request->phone,
                        'phone_code' => 1111
                    ]);



                if($create){
                    return response()->json([
                        'status'=>true,
                        'message' => [
                            'send_code' => 'true',
                            'phone' => $request->phone,
                            'code' => 1111
                        ],
                    ],200);
                }
            }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/dublnewPhoneRegister",
     * summary="dublnewPhoneRegister",
     * description="dublnewPhoneRegister",
     * operationId="dublnewPhoneRegister",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="phone", type="string", format="phone", example="+37493073584"),
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
            public function dublnewPhoneRegister(Request $request){

                $rules=array(
                    'phone'  =>"required|unique:users",
                );
                $validator=Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    return $validator->errors();
                }

                $get_phone = NewRegisterPhone::where('phone' , $request->phone)->get()->last();

                if($get_phone->created_at > Carbon::now()->subMinutes(1) || $get_phone->updated_at > Carbon::now()->subMinutes(1)){
                    return response()->json([
                        'status'=>false,
                        'message' => [
                         'message' => 'send 1 minute ago'
                        ],
                    ],422);
                }else{
//                $phone =     preg_replace('/[+]/', '', $request->phone);
//                $client = new GreenSMS(['user' => '37493073584','pass' => '150997Arman.']);
//                $response = $client->call->send(['to' => $phone]);

                    $get_phone = NewRegisterPhone::where('phone' , $request->phone)->update([
                        'phone_code' =>1111
                    ]);
                    return response()->json([
                        'status'=>true,
                        'message' => [
                            'message' => 'code send yor phone',
                            'phone' => $request->phone,
                            'code' => 1111,
                        ],
                    ],200);
                }
            }

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/comparecode",
     * summary="comparecode",
     * description="comparecode",
     * operationId="comparecode",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="phone", type="string", format="phone", example="+37493073584"),
     *   @OA\Property(property="phone_code", type="string", format="phone_code", example="1111"),
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

            public function comparecode(Request $request){
                $rules=array(
                    'phone' => 'required',
                    'phone_code'  =>"required",
                );
                $validator=Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    return $validator->errors();
                }


                $get_phone = NewRegisterPhone::where('phone_code' , $request->phone_code)->where('phone', $request->phone)->get();

                if(!$get_phone->isEMpty()){
                    return response()->json([
                        'status'=>true,
                        'message' => [
                            'message' => 'succses Code',

                        ],
                    ],200);
                }else{
                    return response()->json([
                        'status'=>true,
                        'message' => [
                            'message' => 'Invalid Code',

                        ],
                    ],422);
                }
            }

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/register",
     * summary="register",
     * description="register",
     * operationId="register",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="name", type="string", format="name", example="user"),
     *      @OA\Property(property="surname", type="surname", format="surname", example="surname"),
     *      @OA\Property(property="photo", type="photo", format="photo", example="photo.jpg"),
     *      @OA\Property(property="email", type="email", format="email", example="email"),
     *      @OA\Property(property="phone", type="phone", format="phone", example="phone"),
     *      @OA\Property(property="region", type="region", format="region", example="region"),
     *      @OA\Property(property="region_id", type="region", format="region", example="region_id"),
     *      @OA\Property(property="city", type="city", format="city", example="city"),
     *      @OA\Property(property="city_id", type="city_id", format="city_id", example="city_id"),
     *      @OA\Property(property="password", type="password", format="password", example="11111111"),
     *      @OA\Property(property="role_id", type="role_id", format="role_id", example="2 OR 3"),
     *      @OA\Property(property="if register role_id = 3", type="if register role_id = 3", format="if register role_id = 3", example="if register role_id = 3"),
     *      @OA\Property(property="category_name", type="category_name", format="category_name", example="category_name"),
     *      @OA\Property(property="category_id", type="category_id", format="category_id", example="category_id"),
     *      @OA\Property(property="sub_category_name", type="sub_category_name", format="sub_category_name", example="sub_category_name"),
     *      @OA\Property(property="sub_category_id", type="sub_category_id", format="sub_category_id", example="sub_category_id"),
     *      @OA\Property(property="vin_code", type="vin_code", format="vin_code", example="vin_code"),
     *      @OA\Property(property="AdditionalEquipmentTransport", type="AdditionalEquipmentTransport", format="AdditionalEquipmentTransport", example="kosh^manual"),
     *      @OA\Property(property="tex_passport_photo", type="tex_passport_photo", format="tex_passport_photo", example="tex_passport_photo"),
     *      @OA\Property(property="transport_photo", type="transport_photo", format="transport_photo", example="transport_photo"),
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


            public function register(RegisterRequest $request){

                if($request->role_id == 2){

                    $avatar = $request->file('photo');
                    if(isset($avatar)){
                        $avatar = $request->file('photo');
                        $destinationPath = 'uploads';
                        $originalFile = time() . $avatar->getClientOriginalName();
                        $avatar->storeas($destinationPath, $originalFile);
                        $avatar = $originalFile;
                    }else{
                        $avatar = 'default.jpg';
                    }
                    $create_user = User::create([
                        'name' => $request->name,
                        'surname' => $request->surname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'photo' =>$avatar,
                        'region' => $request->region,
                        'region_id' => $request->region_id,
                        'city' => $request->city,
                        'city_id' => $request->city_id,
                        'area' => $request->area,
                        'area_id' => $request->id,
                        'password' =>  Hash::make($request->password),
                        'role_id' => $request->role_id,
                        'status' => 2,
                    ]);
                    $get_phone = NewRegisterPhone::where('phone', $request->phone)->delete();
//                    auth()->login($create_user);
//                    $token = $create_user->createToken('Laravel Password Grant Client')->accessToken;

                    $create_message =  Message::create([
                        'sender_id'     => $create_user->id,
                        'receiver_id'    => 1,
                        'room_id'        => time(),
                        'message'        => 'Здравствуйте я новый заказчик',
                        'status'         => 1,
                    ]);

                    Carbon::setLocale('ru');


                        $count = Message::where('receiver_id',1)->sum('status');

                        $message = [
                            'sender_id'   => $create_message->sender_id,
                            'receiver_id'  => $create_message->receiver_id,
                            'room_id' => $create_message->room_id,
                            'message' => $create_message->message,
                            'status' => $create_message->status,
                            'name' => $create_user->name,
                            'user_id' => $create_user->id,
                            'photo' => $create_user->photo,
                            'time' => Carbon::now()->diffForHumans(),
                            'sum' => $count
                        ];

                        event(New  NewMessageEvent($message));

                    return response()->json([
                        'status'=>true,
                        'data' => [
//                            'token' => $token,
                            'user' => $create_user
                        ],
                    ],200);
                 }

                if($request->role_id == 3){
                    $avatar = $request->file('photo');
                    if(isset($avatar)){
                        $avatar = $request->file('photo');
                        $destinationPath = 'uploads';
                        $originalFile = time() . $avatar->getClientOriginalName();
                        $avatar->storeas($destinationPath, $originalFile);
                        $avatar = $originalFile;
                    }else{
                        $avatar = 'default.jpg';
                    }

                    $rules=array(
                        'category_id' => 'required',
                        'category_name' => 'required',
                        'sub_category_id'  =>"required",
                        'sub_category_name'  =>"required",
                        'vin_code' => 'required',
                        'tex_passport_photo' => 'required|min:2',
                        'transport_photo' => 'required',
                    );
                    $validator=Validator::make($request->all(),$rules);
                    if($validator->fails())
                    {
                        return $validator->errors();
                    }

                    $create_user = User::create([
                        'name' => $request->name,
                        'surname' => $request->surname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'photo' => $avatar,
                        'region' => $request->region,
                        'region_id' => $request->region_id,
                        'city' => $request->city,
                        'city_id' => $request->city_id,
                        'area' => $request->area,
                        'area_id' => $request->id,
                        'password' =>  Hash::make($request->password),
                        'role_id' => $request->role_id,
                        'status' => 2,
                    ]);
                    $get_phone = NewRegisterPhone::where('phone', $request->phone)->delete();


                            $create_transport = UserTransport::create([
                                'user_id' => $create_user->id,
                                'category_id' => $request->category_id,
                                'sub_category_id' => $request->sub_category_id,
                                'category_name' => $request->category_name,
                                'sub_category_name' => $request->sub_category_name,
                                'vin_code' => $request->vin_code,
                                'status' => 1
                            ]);

                        $time = time();
                    foreach ($request->tex_passport_photo as $tex_passport){
                        $destinationPath = 'uploads';
                        $originalFile = $time++ . $tex_passport->getClientOriginalName();
                        $tex_passport->storeas($destinationPath, $originalFile);
                        $tex_passport = $originalFile;
                        $create_tex_passport = TexPassportTransport::create([
                            'transport_id' => $create_transport->id,
                            'photo' => $tex_passport
                        ]);
                    }

                    foreach ($request->transport_photo as $transport_photo){
                        $destinationPath = 'uploads';
                        $originalFile = $time++ . $transport_photo->getClientOriginalName();
                        $transport_photo->storeas($destinationPath, $originalFile);
                        $transport_photo = $originalFile;

                        $create_transport_photo = PhotoTransport::create([
                            'transport_id' => $create_transport->id,
                            'photo' => $transport_photo
                        ]);
                    }

                    $explode_additional  = explode('^', $request->AdditionalEquipmentTransport);

                    foreach ($explode_additional as $additional){
                       $create_additional =  AdditionalEquipmentTransport::create([
                           'transport_id' => $create_transport->id,
                            'additional_id' => $request->additional_id,
                            'additional_name' => $request->additional_name,
                        ]);
                    }
                    $create_message =  Message::create([
                        'sender_id'     => $create_user->id,
                        'receiver_id'    => 1,
                        'room_id'        => time(),
                        'message'        => 'Здравствуйте я новый Исполнитель',
                        'status'         => 1,
                    ]);

                    Carbon::setLocale('ru');


                    $count = Message::where('receiver_id',1)->sum('status');

                    $message = [
                        'sender_id'   => $create_message->sender_id,
                        'receiver_id'  => $create_message->receiver_id,
                        'room_id' => $create_message->room_id,
                        'message' => $create_message->message,
                        'status' => $create_message->status,
                        'name' => $create_user->name,
                        'user_id' => $create_user->id,
                        'photo' => $create_user->photo,
                        'time' => Carbon::now()->diffForHumans(),
                        'sum' => $count
                    ];

                    event(New  NewMessageEvent($message));

//                    auth()->login($create_user);
//
//                    $token = $create_user->createToken('Laravel Password Grant Client')->accessToken;
                    return response()->json([
                        'status'=>true,
                        'data' => [
//                            'token' => $token,
                            'user' => $create_user
                        ],
                    ],200);


                }

            }
}
