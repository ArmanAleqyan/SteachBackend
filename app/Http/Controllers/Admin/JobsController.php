<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActiveJob;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportUser;
use App\Exports\ExportUser;


class JobsController extends Controller
{

    public function activeJobs(){

        $get_jobs = ActiveJob::with('ActiveJobSender','ActiveJobReceiver','ActiveJobTender')->where('status', '!=' , 3)->paginate(10);


        return view('admin.Jobs.ActiveJob',compact('get_jobs'));
    }

    public function deactiveJobde(){
        $get_jobs = ActiveJob::with('ActiveJobSender','ActiveJobReceiver','ActiveJobTender','ActiveJobHistory')->where('status',3)->paginate(10);


        return view('admin.Jobs.DeActiveJob',compact('get_jobs'));
    }

    public function FiltredeactiveJobde(Request $request){


        $get_jobs = ActiveJob::where('start_job', '>=', $request->start)->where('end_job', '<=', $request->end)->where('status', 3)->paginate(10);

        $start_date = $request->start;
        $end_date = $request->end;
        $count = $get_jobs->count();
        return view('admin.Jobs.DeActiveJob',compact('get_jobs', 'start_date', 'end_date', 'count'));
    }

    public function downloadExele(Request $request)
    {
        return Excel::download(new ExportUser, 'История.xlsx');

    }


}
