<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventsRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::getEvents();

        return view('events.events', compact(['events', $events]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = User::getUserOrganizations(auth()->user()->id);

        return view('events.addevents', compact(['organizations', $organizations]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventsRequest $request)
    {
        $request->validated();

        $event = new Event();

        $event->title = $request->title;
        $event->address = $request->address;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->info_link = $request->info_link;
        $event->organization_id = $request->org_id;
        $event->users_limit = $request->users_limit;
        $event->users_limit = $request->users_limit;
        $event->access = $request->access;

        $event->save();
        session()->flash('status', 'Мероприятие успешно добавлено');

        return redirect('events');
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
        $organizations = User::getUserOrganizations(auth()->user()->id);
        $event = Event::where('id', $id)->first();

        return view('events.editevents', compact(['organizations', $organizations, 'event', $event]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreEventsRequest $request, $id)
    {
        $request->validated();

        $event = Event::where('id', $id)->first();

        $event->title = $request->title;
        $event->address = $request->address;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->info_link = $request->info_link;
        $event->organization_id = $request->org_id;
        $event->users_limit = $request->users_limit;
        $event->access = $request->access;
        $event->open = $request->open ?? Event::OPEN_REGISTRATION ;
        $event->deleted_at = $request->deleted_at;

        $event->save();

        session()->flash('status', 'Данные обновленны');

        return redirect('events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = DB::table('event_user')->where('event_id', $id)->get();
        if (count($users) > 0) {
            session()->flash('error', 'Мероприятие не может быть удалено пока в нем есть участники');
            return back();
        }

        Event::destroy($id);
        session()->flash('status', 'Мероприятие удалено');

        return redirect('events');
    }
}
