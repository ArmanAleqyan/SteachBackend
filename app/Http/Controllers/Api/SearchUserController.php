<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Transport;
use App\Models\UserTransport;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Validator;

class SearchUserController extends Controller
{


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/SearchCategoryName",
     * summary="SearchCategoryName",
     * description="SearchCategoryName",
     * operationId="SearchCategoryName",
     * tags={"Search"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="category_name", type="string", format="category_name", example="Строительная техника"),
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

            public function SearchCategoryName(Request $request){
                $rules=array(
                    'category_name'  => "required",
                );
                $validator=Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    return $validator->errors();
                }

                $data = \Location::get($request->ip());

                $users = User::select("*", DB::raw("6371 * acos(cos(radians(" . $data->latitude . "))
                 * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $data->longitude . "))
                 + sin(radians(" .$data->latitude. ")) * sin(radians(latitude))) AS distance"))
                    ->whereRelation('UserTransport','category_name' , 'like', '%'.$request->category_name.'%')
                    ->where('role_id',3)
                    ->where('active', 2)
                    ->with('UserTransport','UserTransport.TransporPhoto')
                    ->withAvg('RoleId3Reviews', 'grade')
                    ->having('distance', '<', 20)
                    ->orderBy('distance', 'ASC')
                    ->paginate(15)->toArray();
                if($users == []){
                    return response()->json([
                        'status'=>false,
                        'message' => [
                            'users' => 'no users',
                        ],
                    ],422);
                }else{
                    return response()->json([
                        'status'=>true,
                        'message' => [
                            'users' => $users,
                        ],
                    ],200);
                }
            }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/FilterUsers",
     * summary="FilterUsers",
     * description="FilterUsers",
     * operationId="FilterUsers",
     * tags={"Search"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="category_id", type="string", format="category_id", example="1"),
     *       @OA\Property(property="sub_category_id", type="string", format="sub_category_id", example="2"),
     *       @OA\Property(property="latitude", type="string", format="latitude", example="40.1817"),
     *       @OA\Property(property="longitude", type="string", format="longitude", example="44.5099"),
     *       @OA\Property(property="radius", type="string", format="radius", example="10"),
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


            public function FilterUsers(Request $request){

//                $data = \Location::get($request->ip());
//
//                dd($data);

                $rules=array(
                    'category_id'  => "required",
                    'sub_category_id' => 'required',
                    'latitude'  => 'required',
                    'longitude' => 'required',
                    'radius' => 'required',
                );
                $validator=Validator::make($request->all(),$rules);
                if($validator->fails())
                {
                    return $validator->errors();
                }


                $users = User::select("*", DB::raw("6371 * acos(cos(radians(" . $request->latitude . "))
                 * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $request->longitude . "))
                 + sin(radians(" .$request->latitude. ")) * sin(radians(latitude))) AS distance"))
                    ->whereRelation('UserTransport','category_id' , $request->category_id)
                    ->whereRelation('UserTransport','sub_category_id' , $request->sub_category_id)
                    ->where('role_id',3)
                    ->where('active', 2)
                    ->with('UserTransport','UserTransport.TransporPhoto')
                    ->withAvg('RoleId3Reviews', 'grade')
                    ->having('distance', '<', $request->radius)
                    ->orderBy('distance', 'ASC')
                    ->paginate(15)->toArray();

                if($users == []){
                    return response()->json([
                        'status'=>false,
                        'message' => [
                            'users' => 'no users',
                        ],
                    ],422);
                }else{
                    return response()->json([
                        'status'=>true,
                        'message' => [
                            'users' => $users,
                        ],
                    ],200);
                }
            }


    /**
     * @OA\Post(
     * path="http://80.78.246.59/Stech/public/api/OnePageRoleId3",
     * summary="OnePageRoleId3",
     * description="OnePageRoleId3",
     * operationId="OnePageRoleId3",
     * tags={"Search"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"phone"},
     *       @OA\Property(property="user_id", type="string", format="user_id", example="5"),

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


            public function OnePageRoleId3 (Request $request){
                $user_id = $request->user_id;

                $get_user = User::where('id', $user_id)
                    ->with('UserTransport','UserTransport.TransporPhoto','UserTransport.TransportAdditional',
                        'RoleId3Reviews')->
                    withavg('RoleId3Reviews', 'grade')->withsum('UserHistory', 'time')
                    ->first();

                $category_price = UserTransport::where('user_id',$get_user->id)->first();

                if($category_price->sub_category_id != null){
                    $category_price = SubCategory::where('id', $category_price->sub_category_id)->first();
                    $type = $category_price->type;
                    $price = $category_price->price;
                }else{
                    $category_price = Category::where('id', $category_price-> category_id)->first();
                    $type = $category_price->type;
                    $price = $category_price->price;
                }



                return response()->json([
                    'status'=>true,
                    'message' => [
                        'user_type_job' => $type,
                        'user_job_price' => $price,
                        'user' => $get_user,


                    ],
                ],200);
            }
}
