<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TenderMessages;
use Illuminate\Http\Request;
use App\Models\OrderTender;
use App\Models\Region;
use App\Models\City;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\TenderMessage;
use Illuminate\Support\Facades\Cookie;

class TenderController extends Controller
{

    public function getNewTender(){
        $tenders = OrderTender::OrderBy('id', 'DESC')->with('AuthorTender')->where('status', 1)->paginate(10);

        return view('admin.Tender.NewTender', compact('tenders'));
    }

    public function SinglePageTariff($id){
       $tender = OrderTender::with('Tender')->with('AuthorTender','ExecuterTender')->where('id', $id)->get();

       $tenderchat = TenderMessage::where('tender_id', $id)->first();

       if($tenderchat == null){
           $chat = false;
       }else{
           $chat = true;
       }


       $get_region  = Region::all();
       $get_city  = City::all();
       $get_category = Category::all();
       $get_sub_category = SubCategory::all();


       return view('admin.Tender.SinglePageTender', compact('tender','get_region','get_city','get_category', 'get_sub_category','chat'));
    }

    public function SuccsesSinglePageTariff($id){
        $update = OrderTender::where('id', $id)->update(['status' => 2]);

        return redirect()->back()->with('status','status');
    }


    public function UpdateTender(Request $request){

        $get_tender = OrderTender::where('id', $request->tender_id);

        if(isset($request->name)){
            $get_tender->update(['name' => $request->name]);
        }

        if(isset($request->description)){
            $get_tender->update(['description' => $request->description]);
        }

        if(isset($request->street)){
            $get_tender->update(['street' => $request->street]);
        }
        return redirect()->back();
    }

            public function activeTenders(){
                $tenders = OrderTender::OrderBy('id', 'DESC')->with('AuthorTender','ExecuterTender')->where('status', 2)->paginate(10);
                return view('admin.Tender.ActiveTenders', compact('tenders'));
            }

            public function DeActiveTender(){
                $tenders = OrderTender::OrderBy('id', 'DESC')->with('AuthorTender','ExecuterTender')->where('status', 3)->paginate(10);
                return view('admin.Tender.DeActiveTenders', compact('tenders'));
            }

            public function tendersChat($id, $user_id){



                $usersChat = TenderMessage::query()->where(function  ( $query)  use ($user_id){
                    $query->where([
                        'sender_id' => $user_id,
                    ])->orWhere([
                        'receiver_id' =>$user_id,
                    ]);
                })
                    ->with(['TenderSenderMessage', 'TenderReceiverMessage'])
                    ->orderBy('created_at','DESC')
                    ->get()

                    ->toArray();


//                $data_id = Cookie::get('data_id');
//
//                $get_message = Message::with('SenderMessage', 'ReceiverMessage')->where('room_id', $data_id)->get();
//
//
//                $get_count = Message::where('receiver_id' , $id)->sum('status');
//
//                \Carbon\Carbon::setLocale('ru');
//                foreach ($get_message as $time){
//                    $time['time'] =  $time['created_at']->diffForHumans();
//                }
//
//


                $right_side_data = [];


                foreach ($usersChat as $item) {


                    $user_name = $user_id == $item['tender_receiver_message']['id'] ? $item['tender_sender_message']['name'] : $item['tender_receiver_message']['name'];

                    $receiver_id = $user_id == $item['tender_receiver_message']['id'] ? $item['tender_sender_message']['id'] : $item['tender_receiver_message']['id'];
                    $surname = $user_id == $item['tender_receiver_message']['id'] ? $item['tender_sender_message']['surname'] : $item['tender_receiver_message']['surname'];
                    $tender_id =  $item['tender_id'];
                    $user_image = $user_id == $item['tender_receiver_message']['id'] ? $item['tender_sender_message']['photo'] : $item['tender_receiver_message']['photo'];
//
                    $get_tender_name = OrderTender::where('id', $tender_id)->first();
                    $image = $item['file'];

//                    $review = $review_count->sum('status');

                    $messages = $item["messages"];

                    $right_side_data[] = [
                        'user_name' => $user_name,
                        'surname' =>$surname,
                        'tender_id' => $get_tender_name->id,
                      'tender_name' => $get_tender_name->name,
                        'user_image' => $user_image,
//                'tender_data' => $product_headline,
//                'product_price' => $product_price,
                        'messages' => $messages,
                        'image' => $image,
                        'receiver_id' => $receiver_id,
//                        'review' => $review,
//                        'created_at' => $t_allowed->diffForHumans()
                    ];

                }


                foreach ($right_side_data as $unique){
                    $asd[] = $unique['receiver_id'];
                }
                $filterArr = [];
                $a =    array_unique($asd);
                foreach ($a as $val){
                    foreach($right_side_data as $val2){
                        if($val == $val2['receiver_id']){
                            array_push($filterArr,$val2);
                            break;
                        }
                    }
                }

                $right_side_data =$filterArr;

                Cookie::queue('users_tender', $user_id,  80000);


                return view('admin.UsersChat.TenderChat', compact('right_side_data'));
            }

            public function tenderChatSinglePage($id, $user_id){

                $get_coockie = Cookie::get('users_tender');



                $usersChat = TenderMessage::query()->where(function  ( $query)  use ($get_coockie){
                    $query->where([
                        'sender_id' => $get_coockie,
                    ])->orWhere([
                        'receiver_id' =>$get_coockie,
                    ]);
                })
                    ->with(['TenderSenderMessage', 'TenderReceiverMessage'])
                    ->orderBy('created_at','DESC')
                    ->get()

                    ->toArray();


//                $data_id = Cookie::get('data_id');
//
//                $get_message = Message::with('SenderMessage', 'ReceiverMessage')->where('room_id', $data_id)->get();
//
//
//                $get_count = Message::where('receiver_id' , $id)->sum('status');
//
//                \Carbon\Carbon::setLocale('ru');
//                foreach ($get_message as $time){
//                    $time['time'] =  $time['created_at']->diffForHumans();
//                }
//
//



                $right_side_data = [];


                foreach ($usersChat as $item) {


                    $user_name = $get_coockie == $item['tender_receiver_message']['id'] ? $item['tender_sender_message']['name'] : $item['tender_receiver_message']['name'];

                    $receiver_id = $get_coockie == $item['tender_receiver_message']['id'] ? $item['tender_sender_message']['id'] : $item['tender_receiver_message']['id'];
                    $surname = $get_coockie == $item['tender_receiver_message']['id'] ? $item['tender_sender_message']['surname'] : $item['tender_receiver_message']['surname'];
                    $tender_id =  $item['tender_id'];
                    $user_image = $get_coockie == $item['tender_receiver_message']['id'] ? $item['tender_sender_message']['photo'] : $item['tender_receiver_message']['photo'];
//
                    $get_tender_name = OrderTender::where('id', $tender_id)->first();
                    $image = $item['file'];

//                    $review = $review_count->sum('status');

                    $messages = $item["messages"];

                    $right_side_data[] = [
                        'user_name' => $user_name,
                        'surname' =>$surname,
                        'tender_id' => $get_tender_name->id,
                        'tender_name' => $get_tender_name->name,
                        'user_image' => $user_image,
//                'tender_data' => $product_headline,
//                'product_price' => $product_price,
                        'messages' => $messages,
                        'image' => $image,
                        'receiver_id' => $receiver_id,
//                        'review' => $review,
//                        'created_at' => $t_allowed->diffForHumans()
                    ];

                }

//                dd($right_side_data);


                foreach ($right_side_data as $unique){
                    $asd[] = $unique['receiver_id'];
                }
                $filterArr = [];
                $a =    array_unique($asd);
                foreach ($a as $val){
                    foreach($right_side_data as $val2){
                        if($val == $val2['receiver_id']){
                            array_push($filterArr,$val2);
                            break;
                        }
                    }
                }

                $right_side_data =$filterArr;
                $get_message = TenderMessage::query()->where(function ($query) use ($id,$user_id) {
                    $query->where([
                        'sender_id' => $user_id,
                    ])->orWhere([
                        'receiver_id' => $user_id,
                    ]);
                })->where('tender_id', $id)
                    ->with(['TenderSenderMessage', 'TenderReceiverMessage'])

                    ->get();



                return view('admin.UsersChat.TenderChat', compact('right_side_data','get_message'));
            }
}
