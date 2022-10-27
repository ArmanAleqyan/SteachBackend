<?php

namespace App\Exports;

use App\Models\User;
use App\Models\HistoryTransfers;
use App\Models\ActiveJob;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportUser implements  FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
//    public function collection()
//    {
//        return User::all();
//    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {

        $sum =  HistoryTransfers::sum('pracient');

        $history =  ActiveJob::with('ActiveJobSender','ActiveJobReceiver','ActiveJobTender','ActiveJobHistory')->where('status',3)->get();




        return view('ExportExele.History', compact('history', 'sum'));
    }
}
