<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTransport;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\PhotoTransport;
use App\Models\TexPassportTransport ;
use App\Models\AdditionalParametr ;
use App\Models\AdditionalEquipmentTransport ;

class TransportController extends Controller
{

    public function SinglePageTransport($id){

            $get_transport = UserTransport::with('TransporPhoto','texPassport','TransportAdditional','UserTransport')->where('id', $id)->get();

            $category = Category::all();
            $sub_categorty = SubCategory::all();
        $additional = AdditionalParametr::all();

            return view('admin.Transport.singlePageTransport',compact('get_transport','additional','category','sub_categorty'));
    }

    public function deletephoto(Request $request){


        $delete = PhotoTransport::where('id',$request->photo_id)->delete();


        return response()->json([
            'status'=> true,
            'data' => [
                'message' => 'deleted',
            ],
        ],200);
            }

    public function deleteadditional(Request $request){


        $delete = AdditionalEquipmentTransport::where('id',$request->additional_id)->delete();


        return response()->json([
            'status'=> true,
            'data' => [
                'message' => 'deleted',
            ],
        ],200);
    }

            public function UpdateTransport(Request $request){



        if(isset($request->yuix)){


//                $explode = explode('^', $key);



                $create = AdditionalEquipmentTransport::create([
                    'transport_id' =>$request->transport_id,
//                    'additional_id' => $explode[0],
                    'additional_name' => $request->yuix,
                ]);


        }



        $get_transport = UserTransport::where('id', $request->transport_id)->first();
        if(isset($request->photos)){
            $time = time();
                foreach ($request->photos as $item){
                    $destinationPath = 'uploads';
                    $originalFile = $time++ . $item->getClientOriginalName();
                    $item->storeas($destinationPath, $originalFile);
                    $photos = $originalFile;

                    $create = PhotoTransport::create(['transport_id' => $request->transport_id, 'photo' => $photos]);
                }
        }


        if(isset($request->tex_passport1)){
            $tex1 =$request->tex_passport1;
            $destinationPath = 'uploads';
            $originalFile = time() . $tex1->getClientOriginalName();
            $tex1->storeas($destinationPath, $originalFile);
            $tex1 = $originalFile;

            $update = TexPassportTransport::where('id' ,$request->tex_passport1_id )->update(['photo' => $tex1]);
        }

                if(isset($request->tex_passport2)){
                    $tex2 =$request->tex_passport2;
                    $destinationPath = 'uploads';
                    $originalFile = time() . $tex2->getClientOriginalName();
                    $tex2->storeas($destinationPath, $originalFile);
                    $tex2 = $originalFile;

                    $update = TexPassportTransport::where('id' ,$request->tex_passport2_id )->update(['photo' => $tex2]);
                }

            $get_category = Category::where('id', $request->category_id)->first();
            $get_sub_category = SubCategory::where('id', $request->sub_category_id)->first();


            if(isset($request->sub_category_id)){
                $get_sub_category = SubCategory::where('id', $request->sub_category_id)->first();

                $sub_category_name =  $get_sub_category->sub_category_name;
                $sub_category_id   =  $get_sub_category->id;
            }else{
                $sub_category_name = $get_transport->sub_category_name;
                $sub_category_id  = $get_transport->id;
            }

            $update = UserTransport::where('id', $request->transport_id)->update([
                'vin_code' => $request->vin_code,
                'category_id' => $get_category->id,
                'category_name' => $get_category->category_name,
                'sub_category_name' => $sub_category_name,
                'sub_category_id' => $sub_category_id,
            ]);

        return redirect()->back()->with('succses','succses');
            }

            public function deleteSubCategory($id){

                $userTransport = UserTransport::where('id', $id)->update(['sub_category_name' => null, 'sub_category_id' => null]);

                return redirect()->back();
            }



}
