<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TexPassportTransport;
use File;
use Validator;
class RoleId3MyProfileUpdateController extends Controller
{

    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/RoleId3UpdateProfilePhoto",
     * summary="RoleId3UpdateProfilePhoto",
     * description="RoleId3UpdateProfilePhoto",
     * operationId="RoleId3UpdateProfilePhoto",
     * tags={"Role_id_3_Profile"},
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

    public function RoleId3UpdateProfilePhoto(Request $request){


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


//    public function updateTexPassportPhoto(Request $request){
//         $rules=array(
//            'photo'  =>"required",
//            'photo_id' => 'required'
//        );
//        $validator=Validator::make($request->all(),$rules);
//        if($validator->fails())
//        {
//            return $validator->errors();
//        }
//
//        $photo = $request->file('photo');
//        $destinationPath = 'uploads';
//        $originalFile = time() . $photo->getClientOriginalName();
//        $photo->storeas($destinationPath, $originalFile);
//        $photo = $originalFile;
//
//
//        $delete =  TexPassportTransport::where('id', $request->photo_id)->first();
//        File::Delete('/storage/app/uploads/'.$delete->photo);
//        $update_tex_passport =  TexPassportTransport::where('id', $request->photo_id)->update(['photo' => $photo]);
//
//        return response()->json([
//            'status'=>true,
//            'message' => [
//                'message' => 'photo updated',
//            ],
//        ],200);
//
//    }

}
