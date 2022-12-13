@extends('layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="card collapsed-card">
            <div class="card-header">
                <h1 class="card-title">{{$competition->title}}</h1>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                Дата начала:{{ \Carbon\Carbon::parse($competition->date_start)->format('d.m.Y')}}
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
        @foreach ($competitors as $competitor)
            <div @if($competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE)class="card card-primary collapsed-card" @else class="card card-danger collapsed-card" @endif>
                <div class="card-header">
                    <span><img class="direct-chat-img" src="@if(!$competitor->athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{asset('/storage/'.$competitor->athlete->photo)}}@endif" alt="message user image"></span>
                    <h3 class="card-title">{{$competitor->athlete->user->secondname}} {{$competitor->athlete->user->firstname}} {{$competitor->athlete->user->patronymic}}</h3><br>
                    @if($competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE)
                        <i class="fas fa-male"></i>
                    @else
                        <i class="fas fa-female"></i>
                    @endif - {{$competitor->agecategory->title}},
                    @foreach($competitor->athlete->coaches as $coaches)
                        Тренер: {{$coaches->user->secondname}} {{substr($coaches->user->firstname, 0,2)}}. {{substr($coaches->user->patronymic, 0, 2)}}.
                    @endforeach
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <b>Дата рождения: </b> {{ \Carbon\Carbon::parse($competitor->athlete->user->date_of_birth)->format('d.m.Y')}}<br>
                    <b>Вес: </b>{{$competitor->weight}}<br>
                        <b>Техническая квалификация: </b>{{$competitor->athlete->tehkval->min('title')}}<br>
                        <b>Спортивная квалификация: </b>{{$competitor->athlete->sportkval->min('short_title')}}<br>
                </div>
                @if(\App\Models\Competitor::isCoachAthlete($competitor->athlete->id))
                <div class="card-footer">
                    <div class="row row-cols-2">
                        <div class="col text-left">
                            <a class="btn btn-primary" href="{{route('competitors.edit',[$competitor->id])}}"><i class="fas fa-cog"></i></a>
                        </div>
                        <div class="col text-right">
                            <form method="POST" action="{{route('competitors.destroy',$competitor->athlete->id)}}">
                                @method('DELETE')
                                @csrf
                                <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="{{$competition->id}}">
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

