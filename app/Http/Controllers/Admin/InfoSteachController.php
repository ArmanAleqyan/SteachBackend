<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfoSteach;

class InfoSteachController extends Controller
{

    public function InfoOnas(){
        $get_all = InfoSteach::all();
         return view('admin.InfoOnas.InfoOnas', compact('get_all'));
    }

    public function UpdateInfo(Request $request){
        $update = InfoSteach::where('id', $request->info)->update([
           'email' => $request->email,
           'phone' => $request->phone
        ]);
        return redirect()->back();
    }
}
