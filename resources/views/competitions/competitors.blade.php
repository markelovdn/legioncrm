@extends('layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="card collapsed-card">
            <div class="card-header">
                <h1 class="card-title">{{$competition->title}} ({{ \App\Models\Competition::competitorsCount($competition->id)}})</h1>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;">
                <a class="btn btn-default" href="{{$competition->linkreport}}">Положение и отчеты</a>

                <div class="p-3 control-sidebar-content">
                    <form method="GET" action="{{url()->current()}}">
                        <h6>Тренер</h6>
                        <div class="row">
                            <div class="col-9">
                                <select class="custom-select mb-3 text-light border-0 bg-white" name="coach_id">
                                    <option value="">Все</option>
                                    @if(isset($coaches) && \App\Models\User::getRoleCode() != \App\Models\Role::ROLE_COACH)
                                        @foreach($coaches as $coach)
                                            <option value="{{$coach->id}}" @if(\Illuminate\Support\Facades\Request::input('coach_id') == $coach->id) selected @endif>
                                                {{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0, 1)}}.{{mb_substr($coach->user->patronymic, 0, 1)}}.</option>
                                        @endforeach
                                    @elseif(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_COACH)
                                        <option value="{{$coach->id}}" @if(\Illuminate\Support\Facades\Request::input('coach_id') == $coach->id) selected @endif>
                                            {{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0, 1)}}.{{mb_substr($coach->user->patronymic, 0, 1)}}.
                                        </option>
                                    @endif

                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>
                            </div>
                        </div>
                        <h6>Возраст</h6>
                        <div class="row">
                            <div class="col-9">
                                <select class="custom-select mb-3 text-light border-0 bg-white" name="agecategory_id">
                                    <option value="">Все</option>
                                    @if(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_COACH || \App\Models\Competition::getOwner($competition->id))
                                        @foreach($agecategories as $agecategory)
                                        <option value="{{$agecategory->id}}" @if(\Illuminate\Support\Facades\Request::input('agecategory_id') == $agecategory->id) selected @endif>
                                            {{$agecategory->title}} ({{ \App\Models\Competition::competitorsCountAgecategory($competition->id, $agecategory->id)}} человек)
                                        </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>
                            </div>
                        </div>
                        <h6>Весовая категория</h6>
                        <div class="row">
                            <div class="col-9">
                                <select class="custom-select mb-3 text-light border-0 bg-white" name="weightcategory_id">
                                    <option value="">Все</option>
                                    @if(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_COACH || \App\Models\Competition::getOwner($competition->id))
                                        @foreach($weightcategories as $weightcategory)
                                            <option value="{{$weightcategory->id}}" @if(\Illuminate\Support\Facades\Request::input('weightcategory_id') == $weightcategory->id) selected @endif>
                                                {{$weightcategory->title}} ({{ \App\Models\Competition::competitorsCountWeightcategory($competition->id, $weightcategory->id)}} человек)
                                                @if($weightcategory->gender == \App\Models\Athlete::GENDER_MALE)
                                                    м.
                                                @else
                                                    ж.
                                                    @endif
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>
                            </div>
                        </div>
                        <h6>Группа</h6>
                        <div class="row">
                            <div class="col-9">
                                <select class="custom-select mb-3 text-light border-0 bg-white" name="tehkvalgroup_id">
                                    <option value="">Все</option>
                                    @if(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_COACH || \App\Models\Competition::getOwner($competition->id))
                                        @foreach($tehkvalgroups as $tehkvalgroup)
                                            <option value="{{$tehkvalgroup->id}}" @if(\Illuminate\Support\Facades\Request::input('tehkvalgroup_id') == $tehkvalgroup->id) selected @endif>
                                                {{$tehkvalgroup->title}} ({{ \App\Models\Competition::competitorsCountTehkvalgroup($competition->id, \Illuminate\Support\Facades\Request::input('weightcategory_id'), $tehkvalgroup->id)}} человек)
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
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
                    <span><img class="direct-chat-img" src="@if(!$competitor->athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{$competitor->athlete->photo}}@endif" alt="message user image"></span>
                    <h3 class="card-title">{{$competitor->athlete->user->secondname}} {{$competitor->athlete->user->firstname}} {{$competitor->athlete->user->patronymic}}</h3><br>
                    @if($competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE)
                        <i class="fas fa-male"></i>
                    @else
                        <i class="fas fa-female"></i>
                    @endif - {{$competitor->agecategory->title}} {{$competitor->tehkvalgroup->title}},
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
                        <b>Техническая квалификация: </b>
                    <span
                        @if(\App\Models\Competitor::isCoachAthlete($competitor->athlete->id))
                            data-toggle="modal" data-target="#modal-tehkval-{{$competitor->athlete->id}}"
                        @endif
                    >{{$competitor->athlete->tehkval->last()->title}}</span><br>
                        <b>Спортивная квалификация: </b>{{$competitor->athlete->sportkval->min('short_title')}}<br>
                </div>
                @if(\App\Models\Competitor::isCoachAthlete($competitor->athlete->id))
                <div class="card-footer">
                    <div class="row row-cols-2">
                        <div class="col text-left">
                            <form method="GET" action="{{route('competitors.edit',[$competitor->id])}}">
                                @csrf
                                <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="{{$competition->id}}">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-cog"></i></button>
                            </form>
                        </div>
                        <div class="col text-right">
                            <form method="POST" action="{{route('competitors.destroy',$competitor->id)}}">
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

