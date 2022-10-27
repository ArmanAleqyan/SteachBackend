<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenderMessage;
use App\Models\Notification;
use App\Mail\AddBlackListUserEmail;
use App\Models\User;
use App\Models\InfoSteach;
use App\Models\Message;
use App\Models\Region;
use App\Models\City;
use App\Models\HistoryTransfers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Null_;

class NewUserController extends Controller
{

    public function GetNewCustomers(){

        $get_user = User::where('role_id', 2)->where('status', '2')->paginate(10);

       return  view('admin.NewUser.NewUserRoleId2',compact('get_user'));

    }

    public function OnePageGetNewCustomers($id){
       $get_user = User::with('UserTransport','UserTransport.TransporPhoto')->where('id', $id)->get();

       $get_region = Region::OrderBY('id', 'asc')->get();
       $get_city = City::OrderBY('id', 'asc')->get();


       if($get_user[0]->role_id == 3){
            $get_stat = HistoryTransfers::with('ActiveJobHistory')->OrderBy('id', 'Desc')->where('user_id',$id)->get();
            $sum = $get_stat->sum('pracient');
           return view('admin.NewUser.SinglePage', compact('get_user','get_region','get_city','get_stat','sum'));
       }

       return view('admin.NewUser.SinglePage', compact('get_user','get_region','get_city'));
    }

    public function succsesuser($id){
        $user_update = User::where('id',$id)->update(['status' => 1]);

        return redirect()->back()->with('succses','succses');
    }

    public function addBlackList($id){

        $user_update = User::where('id',$id)->update(['black_list' => 2]);
        Message::where(['sender_id' => $id])->where('receiver_id' , '!=' , 1)->delete();
        Message::where(['receiver_id'=>$id])->where('sender_id' , '!=', 1)->delete();
        TenderMessage::where(['sender_id' => $id])->delete();
        TenderMessage::where([ 'receiver_id' => $id])->delete();
        Notification::where('sender_id', $id)->delete();
        Notification::where('receiver_id', $id)->delete();

        $get_user = User::where('id', $id)->get('email');

            $info = InfoSteach::get();


        $details = [
            'email' => $info[0]->email,
        ];
        Mail::to($get_user[0]->email)->send(new AddBlackListUserEmail($details));



        return redirect()->back()->with('blackList','blackList');
    }

    public function deleteBlackList($id){
        $user_update = User::where('id',$id)->update(['black_list' => 1]);

        return redirect()->back()->with('deleteBlackList','deleteBlackList');
    }

    public function updateUserProfile(Request $request){




        $photo = $request->file('photo');

        $get_user = User::where('id', $request->user_id)->first();


        if(isset($request->balance)){
            $new_balance = $get_user->balance +  $request->balance;
            $get_user->update(['balance' => $new_balance]);
        }

        if (isset($request->activity)){
            $new_activity = $get_user->activity +  $request->activity;
            $get_user->update(['activity' => $new_activity]);
        }
        if(isset($request->region_id)){
            $region = Region::where('id', $request->region_id)->first();
            $region_id    = $region->id;
            $region_name = $region->name;
        }else{
            $region_id  =$get_user->region_id;
            $region_name = $get_user->region;
        }

        if(isset($request->city_id)){
            $city = City::where('id', $request->city_id)->first();
            $city_id   =  $city->id;
            $city_name =  $city->name;
        }else{
            $city_id    = $get_user->city_id;
            $city_name  = $get_user->city;
        }


        if(isset($photo)){
            $destinationPath = 'uploads';
            $originalFile = time() . $photo->getClientOriginalName();
            $photo->storeas($destinationPath, $originalFile);
            $photo = $originalFile;
        }else{
           $photo = $get_user->photo;
        }

        $update = $get_user->update([
            'photo' => $photo ,
            'priceJob' => $request->priceJob,
            'phone' => $request->phone,
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'region_id' =>  $region_id ,
            'region' =>     $region_name,
            'city_id' =>   $city_id  ,
            'city' =>    $city_name ,
        ]);

        return redirect()->back()->with('updated','updated');
    }


    public function GetNewExecutor(){
        $get_user = User::where('role_id', 3)->where('status', 2)->paginate(10);



        return view('admin.NewExecutor.AllNewExecuter', compact('get_user'));
    }


    public function activeTariffPlyus($id){
        User::where('id', $id)->update(['tariff_plus'=> 1]);

        return redirect()->back()->with('opentariff','opentariff');
    }

    public function deactiveTariffPlyus($id){
        User::where('id', $id)->update(['tariff_plus'=> NULL]);

        return redirect()->back()->with('closetariff','closetariff');
    }
}
