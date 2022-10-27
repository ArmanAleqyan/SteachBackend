<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoryInvite;

class InviteController extends Controller
{

    public function DangerInvite(){
        $get_invite = HistoryInvite::with('SenderInviteHistory', 'ReceiverInviteHistory','TenderNameHistory')->OrderBy('id','Desc')->paginate(10);

        HistoryInvite::where('status', 1)->update(['status'=> 2]);
       return view('admin.Invite.DangerInvite', compact('get_invite'));
    }
}
