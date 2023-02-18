<?php

namespace App\Http\Controllers;

use App\BusinessProcess\GetEventUsers;
use App\Filters\UserFilter;
use App\Http\Requests\StoreEventsRequest;
use App\Http\Requests\StoreEventUsersRequest;
use App\Models\Event;
use App\Models\User;
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

        if ($users == null && $user->isParented($user) ||
            $users != null && $user->isParented($user) && $users->count() < 1) {
            session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
            return view('events.event-users',
                ['event'=>$event , 'users'=>$users]);
        }

        if($users!= null && $users->count() >= 1 && $user->isParented($user)) {
            foreach ($users as $athlete_parent) {
                $ids[] = $athlete_parent->user_id;
            }
            $users = $event->users()
                ->whereIn('user_id', $ids)
                ->get();

            if($users->count() < 1) {
                session()->flash('status', 'Вы не добавляли спортсменов на данное мероприятие');
                return view('events.event-users', ['event'=>$event, 'users'=>$users]);
            }
            return view('events.event-users', ['event'=>$event, 'users'=>$users]);
        }

        $users = $event->users()
            ->orderBy('id', 'DESC')
            ->get();

        return view('events.event-users', ['event'=>$event, 'users'=>$users]);
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

        if ($eventUsers && $eventUsers->count() >= 1) {
            return view('events.addusers',
                [
                    'event'=>$event,
                    'eventUsers'=>$eventUsers,
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

        if (Event::find($request->event_id) == null)
        {
            throw new \Exception('Не найдено  мероприятия');
        }

        if (Event::hasUsers($request->event_id, $user->id)) {
            session()->flash('error', 'Данный пользователь уже добавлен на мероприятие');
            return back();
        }

        $user->events()->attach($request->event_id, ['approve'=> Event::APPROVE, 'payment_id' => 0]);

        session()->flash('status', 'Пользователь успешно добавлен на мероприятие');

        return back();
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

        DB::table('event_user')
            ->where('event_id', $id)
            ->where('user_id', $request->user_id)->update([
                'approve' => $request->approve,
                'payment_id' => $request->payment_id]);

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
