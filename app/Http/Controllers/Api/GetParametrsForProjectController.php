<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Region;

class GetParametrsForProjectController extends Controller
{

    /**
     * @OA\Get(
     *      path="http://80.78.246.59/Stech/public/api/getCategory",
     *      operationId="getCategory",
     *      tags={"GetParametrForProject"},
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

    public function getCategory(){

        $category = Category::with('CategorySubCategory')->get();

        return response()->json([
            'status'=>true,
            'message' => [
                'category' => $category,


            ],
        ],200);
    }


    /**
     * @OA\Get(
     *      path="http://80.78.246.59/Stech/public/api/getRegion",
     *      operationId="getRegion",
     *      tags={"GetParametrForProject"},
     *      summary="Get list of Region",
     *      description="Returns list of Region",
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
    public function getRegion(){
      $region = Region::with('RegionAndCity')->get();
        return response()->json([
            'status'=>true,
            'message' => [
                'region' => $region,
            ],
        ],200);
    }
}
