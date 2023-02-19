@extends('layouts.main')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Список актуальных мероприятий</h1>
                </div><!-- /.col -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @foreach ($events as $event)
            <div class="card card-info collapsed-card shadow-lg">
                <div class="card-header">
                    <h3 class="card-title"><b>{{$event->title}}</b></h3><br>
                    <p>Начало: {{ \Carbon\Carbon::parse($event->date_start)->format('d.m.Y')}}</p>
                    Участники:
                        <a href="{{route('events.users.index',[$event->id])}}"><i class="nav-icon fas fa-users"></i></a>
                    <br>
                    Регистрация:
                    @if($event->open == \App\Models\Event::CLOSE_REGISTRATION || $event->users_limit - $event->users->count() <=0)
                        <span class="badge badge-danger">закрыта</span>
                    @else
                    <a href="{{route('events.users.create',[$event->id])}}"><i class="nav-icon fas fa-user-plus"></i></a><br>
                    @endif

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body" style="display: none;">
                    <b>Место проведения: </b>{{$event->address}}
                    <br>
                    <b>Даты проведения: </b>{{ \Carbon\Carbon::parse($event->date_start)->format('d.m.Y').'-'.\Carbon\Carbon::parse($event->date_end)->format('d.m.Y')}}<br>
                    <b>Зарегестированно всего: </b>{{$event->users->count()}}<br>
                    <b>Осталось свободных мест: </b>{{$event->users_limit - $event->users->count()}}<br>
                    <b><a href="{{$event->info_link}}">Подробная информация</a></b><br>
                </div>

                <div class="card-footer">
                    <div class="row row-cols-2">
                        @if(\App\Models\Competition::getOwner($event->id))
                            <div class="col text-left">
                                <a class="btn btn-primary" href="{{route('events.edit',[$event->id])}}"><i class="fas fa-cog"></i></a>
                            </div>
                            <div class="col text-right">
                                <form method="POST" action="{{route('events.destroy', [$event->id])}}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
    @endforeach
    <!-- /.card-body -->
        </div>
        <!-- /.card -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

