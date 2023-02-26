<?php

namespace App\Http\Controllers;

use App\BusinessProcess\GetEventUsers;
use App\BusinessProcess\uploadFile;
use App\Filters\UserFilter;
use App\Http\Requests\StoreEventsRequest;
use App\Http\Requests\StoreEventUsersRequest;
use App\Models\Event;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id, Request $request, GetEventUsers $eventUsers, UserFilter $userFilter)
    {
        $user = \auth()->user();

        $event = Event::where('id', $event_id)->first();
        $users = $eventUsers->getUsers(auth()->user()->id);
        $users_main_list = Event::getCountMainList($event->id);
        $users_waiting_list = Event::getCountWaitingList($event->id);
        $paymenttitle_id = DB::table('payments_titles')->where('title', $event->title.'-'.$event->date_start)->first()->id;
        $event_cost = Event::getCost($event->id);

        if ($users == null && $user->isParented($user) || $users != null && $user->isParented($user) && $users->count() < 1) {
            session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
            return back();
        }

        if($users != null && $users->count() >= 1 && $user->isParented($user)) {
            foreach ($users as $athlete_parent) {
                $ids[] = $athlete_parent->user_id;
            }
            $users = $event->users()->whereIn('user_id', $ids)->get();

            return view('events.event-users', [
                'event'=>$event,
                'users'=>$users,
                'users_main_list' => $users_main_list,
                'users_waiting_list' => $users_waiting_list,
                'paymenttitle_id' => $paymenttitle_id,
                'event_cost' => $event_cost,
            ]);
        }

        if (!$eventUsers->changeUserList($event, $users)) {
            $users = $event->users()->orderBy('id', 'DESC')->get();
        } else {
            $users = $eventUsers->changeUserList($event, $users);
        }
//        TODO:надо добавить автообновление счетчика

        return view('events.event-users', [
            'event'=>$event,
            'users'=>$users,
            'users_main_list' => $users_main_list,
            'users_waiting_list' => $users_waiting_list,
            'paymenttitle_id' => $paymenttitle_id,
            'event_cost' => $event_cost,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($event_id, GetEventUsers $eventUsers)
    {
        $event = Event::find($event_id);
        $eventUsers = $eventUsers->getUsers(auth()->user()->id);
        $bookingWithoutPay = Event::isBookingWithoutPay($event->id);
        $free_place = $event->users_limit - Event::getCountMainList($event->id);
        $event_cost = Event::getCost($event->id);
        $payment = DB::table('payments_titles')->where('title', $event->title.'-'.$event->date_start)->first();

        if ($eventUsers && $eventUsers->count() >= 1) {
            return view('events.addusers',
                [
                    'event' => $event,
                    'eventUsers' => $eventUsers,
                    'event_cost' => $event_cost,
                    'bookingWithoutPay' => $bookingWithoutPay,
                    'free_place' => $free_place,
                    'payment' => $payment
                ]);

        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventUsersRequest $request)
    {
        $request->validated();

        $user = User::where('id', $request->user_id)->first();
        $event = Event::with('users')->where('id', $request->event_id)->first();

        if (Event::find($request->event_id) == null)
        {
            throw new \Exception('Не найдено  мероприятия');
        }

        if (Event::hasUsers($request->event_id, $user->id)) {
            session()->flash('error', 'Данный пользователь уже добавлен на мероприятие');
            return back();
        }

        if ($event->users_limit - Event::getCountMainList($request->event_id) <= 0) {
            $waiting_number = Event::getCountWaitingList($request->event_id) + 1;

            $user->events()->attach($request->event_id,
                [
                    'approve'=> Event::APPROVE,
                    'payment_id' => 0,
                    'list' => Event::WAITING_LIST,
                    'created_at' => Carbon::now(),
                ]);

            session()->flash('warning', 'На данное мероприятие нет свободных мест, мы вынуждены добавить участника в очередь под номером ' . $waiting_number);

            return redirect(route('events.users.index',[$event->id]));
        }

        if ($request->paymenttitle_id && $request->hasFile('scan_payment_document')) {
            $path_scanlink = uploadFile::uploadFile($request->user_id, $user->secondname, $user->firstname,
                'scan_payment_document_'.$event->title, $request->file('scan_payment_document'));

            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->sum = $request->sum_payment;
            $payment->date = Carbon::now();
            $payment->paymenttitle_id = $request->paymenttitle_id;
            $payment->scan_payment_document =  $path_scanlink;
            $payment->approve = Payment::DECLINED;
            $payment->save();

            $user->events()->attach($request->event_id,
                [
                    'approve'=> Event::APPROVE,
                    'payment_id' => $payment->id,
                    'list' => Event::MAIN_LIST,
                    'created_at' => Carbon::now()
                ]);
            session()->flash('status', 'Пользователь успешно добавлен на мероприятие');

            return redirect(route('events.users.index',[$event->id]));
        }

        $user->events()->attach($request->event_id,
            [
                'approve'=> Event::APPROVE,
                'payment_id' => 0,
                'list' => Event::MAIN_LIST,
                'created_at' => Carbon::now()
            ]);

        session()->flash('status', 'Пользователь успешно добавлен на мероприятие');

        return redirect(route('events.users.index',[$event->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEventUsersRequest $request, $id)
    {
        $request->validated();

        $user = User::where('id', $request->user_id)->first();
        $event = Event::with('users')->where('id', $request->event_id)->first();

        if ($request->paymenttitle_id && $request->hasFile('scan_payment_document') && Event::getCost($event->id) > $request->sum_payment) {
            $path_scanlink = uploadFile::uploadFile($request->user_id, $user->secondname, $user->firstname,
                'scan_prepayment_document_'.$event->title, $request->file('scan_payment_document'));

            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->sum = $request->sum_payment;
            $payment->date = Carbon::now();
            $payment->paymenttitle_id = $request->paymenttitle_id;
            $payment->scan_payment_document =  $path_scanlink;
            $payment->approve = Payment::PAYMENT_AWAIT_APPROVE;
            $payment->save();

            DB::table('event_user')
                ->where('event_id', $id)
                ->where('user_id', $request->user_id)->update([
                    'payment_id' => $payment->id]);

            session()->flash('status', 'Данные обновленны');

            return redirect('/events/'.$id.'/users');
        }

        DB::table('event_user')
            ->where('event_id', $id)
            ->where('user_id', $request->user_id)->update([
                'approve' => $request->approve]);

        session()->flash('status', 'Данные обновленны');

        return redirect('/events/'.$id.'/users');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $event = Event::where('id', $request->input('event_id'))->first();

        $event->users()->detach($request->input('user_id'));

        session()->flash('status', 'Пользователь удален из участников мероприятия');

        return redirect('/events/'.$request->input('event_id').'/users');
    }
}