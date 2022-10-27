<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Cookie;

class CategoryController extends Controller
{

    public function getcategory(){
        $get_Category = Category::all();



        return view('admin.Category.AllCategory',compact('get_Category'));
    }

    public function SinglePageCategory(Request $request, $id){



       $get_category = Category::where('id', $id)->get();
       $sub_category = SubCategory::with('CategorySubCategory')->where('category_id', $id)->get();
       return view('admin.Category.SinglePage', compact('get_category', 'sub_category'));
    }


    public function UpdateCategory(Request $request){
        $update = Category::where('id', $request->category_id)->update([
           'type' => $request->type,
            'price' => $request->price,
            'category_name' => $request->category_name
        ]);
        return redirect()->back();
    }

    public function SinglePageSubCategory($id){
       $get_sub_category = SubCategory::where('id', $id)->get();


       return view('admin.Category.SinglePageSubCategory', compact('get_sub_category'));
    }

    public function UpdateSubCategory(Request $request){
        $update = SubCategory::where('id', $request->sub_category_id)->update([
            'type' => $request->type,
            'price' => $request->price,
            'sub_category_name' => $request->sub_category_name
        ]);

        return redirect()->back();
    }
}
