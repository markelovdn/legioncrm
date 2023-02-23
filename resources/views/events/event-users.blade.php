@extends('layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="card collapsed-card">
            <div class="card-header">
                <h1 class="card-title">{{$event->title}} {{ \Carbon\Carbon::parse($event->date)->format('d.m.Y')}}</h1>
                <div class="card-tools">
                    <span class="badge badge-success">{{$users_main_list}}</span>/<span class="badge badge-warning">{{$users_waiting_list}}</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
            </div>
        </div>

    </div>
    <!-- /.content-header -->
    <section class="content">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @foreach ($users as $user)
            <div class="card card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">{{$user->secondname}} {{$user->firstname}} {{$user->patronymic}}</h3><br>
                    @if($user->pivot->list == \App\Models\Event::MAIN_LIST)
                        <span class="badge badge-success">основной список</span>
                    @else
                    <span class="badge badge-warning"><i class="far fa-clock"></i> очередь</span>
                    @endif
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <b>Дата рождения: </b> {{ \Carbon\Carbon::parse($user->date_of_birth)->format('d.m.Y')}}<br>
                </div>
                @if(\App\Models\Event::getOwner($event->id) || \App\Models\Athlete::isParentedAthlete($user->athlete->id))
                <div class="card-footer">
                    <div class="row row-cols-2">
                        <div class="col text-left">
                            {{-- одобрить участие--}}
                        </div>
                        <div class="col text-right">
                            <form method="POST" action="{{route('userEventDestroy', ['event_id', $event->id, 'user_id', $user->id])}}">
                                @method('DELETE')
                                @csrf
                                <input type="number" style="display: none" class="form-control" id="event_id" name="event_id" value="{{$event->id}}">
                                <input type="number" style="display: none" class="form-control" id="user_id" name="user_id" value="{{$user->id}}">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        @endforeach
    </section>

@endsection

