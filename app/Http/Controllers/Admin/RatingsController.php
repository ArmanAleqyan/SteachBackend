<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoleId3Reviews;

class RatingsController extends Controller
{

    public function getRaiting(){
        $get_all = RoleId3Reviews::with('SenderReview', 'ReceiverReview')->OrderBy('id', 'DESC')->paginate(10);



        return view('admin.Ratings.GetAll', compact('get_all'));
    }

    public function singlePageRaiting($id){

        $get_all = RoleId3Reviews::with('SenderReview', 'ReceiverReview')->where('id',$id)->get();

        return view('admin.Ratings.SinglePage',compact('get_all'));

    }

    public function updatereview(Request $request){
        $update = RoleId3Reviews::where('id', $request->review_id)->update([
            'grade' => $request->grade,
            'message' => $request->message
        ]);

        return redirect()->back()->with('succses','succses');
    }
}
