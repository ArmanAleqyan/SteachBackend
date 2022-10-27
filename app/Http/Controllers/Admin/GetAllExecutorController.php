<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class GetAllExecutorController extends Controller
{
    public function  GetAllExecutor(){
            $get_user = User::where('role_id', 3)->where('status',1)->where('black_list', '!=', 2)->paginate(10);


        return view('admin.Executor.AllExecutor',compact('get_user'));
    }

    public function getBlackListUsers(){
        $get_user = User::where('black_list',2)->paginate(10);

        return view('admin.Black_List.AllBlack_List',compact('get_user'));
    }

    public function searchExucator(Request $request){
        $search_phone = $request->search;
       $get_user = User::where('role_id',3)->where($request->Searchmethod,'like', '%' . $search_phone . '%')->paginate(10);
       $count = $get_user->count();


       return view('admin.Executor.SearchExecutor', compact('get_user','count','search_phone'));
    }

    public function serachVinCode(Request $request){

        $get_user = User::whereRelation('UserTransport','vin_code' , 'like', '%' . $request->vincode . '%')->where('status',2)->paginate(10);
        $count = $get_user->count();
        $text = $request->vincode;
     return view('admin.NewExecutor.SearchVinCodeExecutor', compact('get_user','count','text'));
    }

    public function UsersStat(){
        $get_Executor = User::Where('role_id', 3)->where('status', 1)->count();
        $new_get_Executor = User::Where('role_id', 3)->where('status', 2)->count();
        $get_Custumers = User::where('role_id', 2)->count();
        $new_get_Custumers = User::where('role_id', 2)->where('status', 2)->count();

        $get_black_list = User::where('black_list', 2)->count();


        return view('admin.Statistics.User', compact('get_Executor','new_get_Custumers','new_get_Executor','get_Custumers','get_black_list'));
    }
}
