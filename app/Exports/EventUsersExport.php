<?php


namespace App\Exports;

use App\Models\Athlete;
use App\Models\Competition;
use App\Models\Competitor;
use App\Models\Event;
use App\Models\Payment;
use App\Models\User;
use http\Url;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use function PHPUnit\Framework\isEmpty;


class EventUsersExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $event = Event::where('id', Request::route()->parameters)->first();
        $paymenttitle = DB::table('payments_titles')->where('title', $event->title.'-'.$event->date_start)->first();
        $users = $event->users()
            ->with('athlete', 'payments')
            ->orderBy('id', 'DESC')
            ->get();

        return view('exports.event-users', [
            'users' => $users,
            'event' => $event,
            'paymenttitle' => $paymenttitle,
        ]);
    }
}
