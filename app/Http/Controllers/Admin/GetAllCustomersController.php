<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class GetAllCustomersController extends Controller
{

    public function GetAllCustomers(){
        $get_user = User::where('role_id', 2)->where('status',1)->where('black_list', '!=', 2)->paginate(10);


        return view('admin.Custumers.AllCustumers',compact('get_user'));
    }

    public function searchCustomers(Request $request){
        $search_phone = $request->search;
        $get_user = User::where('role_id',2)->where($request->Searchmethod,'like', '%' . $search_phone . '%')->paginate(10);
        $count = $get_user->count();


        return view('admin.Custumers.searchCustomers', compact('get_user','count','search_phone'));
    }
}
