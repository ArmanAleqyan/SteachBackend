<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTenderRequest;
use App\Models\OrderTender;
use App\Models\OrderTenderPhoto;
use Validator;
use File;

class CreateOrderTendersRoleId2Controller extends Controller
{


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/CreateTender",
     * summary="CreateTender",
     * description="CreateTender",
     * operationId="CreateTender",
     * tags={"tender"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="category_id", type="string", format="category_id", example="1"),
     *   @OA\Property(property="category_name", type="string", format="category_name", example="Грузо-перевозки"),
     *   @OA\Property(property="sub_category_id", type="string", format="sub_category_id", example="2"),
     *   @OA\Property(property="sub_category_name", type="string", format="sub_category_name", example="2"),
     *   @OA\Property(property="region_id", type="string", format="region_id", example="1"),
     *   @OA\Property(property="region_name", type="string", format="region_name", example="Москва и Московская обл."),
     *   @OA\Property(property="city_id", type="string", format="city_id", example="1"),
     *   @OA\Property(property="city_name", type="string", format="city_name", example="Москва"),
     *   @OA\Property(property="street", type="string", format="street", example="Абрамцевская улица"),
     *   @OA\Property(property="date_time", type="string", format="date_time", example="13/08/2022 09:00"),
     *   @OA\Property(property="description", type="string", format="description", example="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dumm"),
     *     @OA\Property(property="photo[]", type="file", format="photo[]", example="photo.png"),
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

    public function CreateTender(CreateTenderRequest $request){

        $create_tender = OrderTender::create([
            'name' => $request->name,
            'sender_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'category_name' => $request->category_name,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_name' => $request->sub_category_name,
            'region_id' => $request->region_id,
            'region_name' => $request->region_name,
            'city_id' => $request->city_id,
            'city_name' => $request->city_name,
            'street' => $request->street,
            'date_time' => $request->date_time,
            'description' => $request->description,
            'active' => 1,
            'status' => 1,
        ]);

        $photo = $request->file('photo');

        $time = time();
        foreach ($photo as $photos){
            $destinationPath = 'uploads';
            $originalFile = $time++ . $photos->getClientOriginalName();
            $photos->storeas($destinationPath, $originalFile);
            $photos = $originalFile;

            $create_photo =  OrderTenderPhoto::create([
               'photo' => $photos,
               'tender_id' => $create_tender->id
            ]);
        }



        return response()->json([
            'status'=>true,
            'data' => [
                'message' => 'tender created ',
            ],
        ],200);
    }

    /**
     * @OA\Get(
     *      path="http://80.78.246.59/Stech/public/api/getMytender",
     *      operationId="getMytender",
     *      tags={"tender"},
     *      summary="Get list of Category",
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


    public function getMytender(){
      $user_id = auth()->user()->id;
      $get_Tender = OrderTender::with('Tender')->where('sender_id',$user_id)->where('active', '!=' ,3)->OrderBy('id','Desc')->paginate(15);

        return response()->json([
            'status'=>true,
            'data' => [
                'my_tender' => $get_Tender,
            ],
        ],200);
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/deleteTender",
     * summary="deleteTender",
     * description="deleteTender",
     * operationId="deleteTender",
     * tags={"tender"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"tender_id"},
     *       @OA\Property(property="tender_id", type="string", format="tender_id", example="1"),
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


    public function deleteTender(Request $request){
        $tender_id = $request->tender_id;

        $delete_tender = OrderTender::where('id', $tender_id)->update(['active'=>3]);

        return response()->json([
            'status'=>true,
            'data' => [
                'message' => 'tender deleted',
            ],
        ],200);
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/DeleteTenderPhoto",
     * summary="DeleteTenderPhoto",
     * description="DeleteTenderPhoto",
     * operationId="DeleteTenderPhoto",
     * tags={"tender"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"tender_id"},
     *       @OA\Property(property="tender_id", type="string", format="tender_id", example="1"),
     *       @OA\Property(property="photo_id", type="string", format="photo_id", example="1"),
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

    public function DeleteTenderPhoto(Request $request){
        $rules=array(
            'photo_id'  =>"required",
            'tender_id'  =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }
        $photo_id = $request->photo_id;
        $tender_id =  $request->tender_id;
        $count = OrderTenderPhoto::where('tender_id', $tender_id)->count();
        if($count < 2){
            return response()->json([
                'status'=>false,
                'data' => [
                    'message' => 'photo count do not have  1',
                ],
            ],422);
        }else{
            $delete_storage =   OrderTenderPhoto::where('id', $photo_id)->first();
            File::Delete('/storage/app/uploads/'.$delete_storage->photo);

            $delete_photo = OrderTenderPhoto::where('id', $photo_id)->delete();
            return response()->json([
                'status'=>true,
                'data' => [
                    'message' => 'photo deleted',
                ],
            ],200);
        }
    }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/UpdateTender",
     * summary="UpdateTender",
     * description="UpdateTender",
     * operationId="UpdateTender",
     * tags={"tender"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"tender_id"},
     *       @OA\Property(property="tender_id", type="string", format="tender_id", example="1"),
     *       @OA\Property(property="photo[]", type="file", format="photo[]", example="photo.png"),
     *       @OA\Property(property="region_id", type="string", format="region_id", example="1"),
     *       @OA\Property(property="region_name", type="string", format="region_name", example="Москва и Московская обл."),
     *       @OA\Property(property="city_id", type="string", format="city_id", example="1"),
     *       @OA\Property(property="city_name", type="string", format="city_name", example="Москва"),
     *       @OA\Property(property="street", type="string", format="street", example="Ivanovo 45/1"),
     *       @OA\Property(property="date_time", type="string", format="date_time", example="13/08/2022 09:00"),
     *       @OA\Property(property="description", type="string", format="description", example="description   min:30 charset"),
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

    public function UpdateTender(Request $request){

        $rules=array(
            'tender_id'  =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }

        $tender = OrderTender::where('id', $request->tender_id);


        if(isset($request->photo)){
            $time = time();
            foreach ($request->photo as $photo){
                $destinationPath = 'uploads';
                $originalFile = $time++ . $photo->getClientOriginalName();
                $photo->storeas($destinationPath, $originalFile);
                $photo = $originalFile;
                $create_new_photo = OrderTenderPhoto::create([
                   'tender_id' => $request->tender_id,
                   'photo' => $photo
                ]);
            }
        }




        if(isset($request->region_id) && isset($request->region_name)){
            $tender->update(['region_id' => $request->region_id, 'region_name' =>$request->region_name ]);
        }
        if(isset($request->city_id) && isset($request->city_name)){
            $tender->update(['city_id' => $request->city_id, 'city_name' =>$request->city_name]);
        }

        if(isset($request->street)){
            $tender->update(['street' => $request->street]);
        }
        if(isset($request->date_time)){
            $tender->update(['date_time' => $request->date_time]);
        }
        if(isset($request->description)){
            $rules=array(
                'description'  =>"min:30",
            );
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return $validator->errors();
            }
            $tender->update(['description' => $request->description]);
        }


        return response()->json([
            'status'=>true,
            'data' => [
                'message' => 'tender updated',
            ],
        ],200);
    }


    /**
     * @OA\Get(
     *      path="http://80.78.246.59/Stech/public/api/getAllTenderForRoleId3",
     *      operationId="getAllTenderForRoleId3",
     *      tags={"tender"},
     *      summary="Get list of getAllTenderForRoleId3",
     *      description="Returns list of getAllTenderForRoleId3",
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


    public function getAllTenderForRoleId3(){


        $category_id = auth()->user()->UserTransport[0]->category_id;

        $get_tender =  OrderTender::with('AuthorTender','Tender')->where('active', 2)->where('category_id', $category_id)->OrderBy('id','DESC')->paginate(15);

        if($get_tender->isEMpty()){
            return response()->json([
                'status'=>false,
                'data' => [
                    'message' => 'no tender',
                ],
            ],422);
        }else{
            return response()->json([
                'status'=>true,
                'data' => [
                    'tender' => $get_tender,
                ],
            ],200);
        }


    }



}
