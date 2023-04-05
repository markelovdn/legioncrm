@extends('layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <competitors-index
        :competition_id="{{$competition->id}}"
        :coach_constant="{{json_encode(\App\Models\Coach::TYPE)}}"></competitors-index>
{{--        :coach_constant="{{json_encode((new ReflectionClass(\App\Models\Coach::class))->getConstants())}}"></competitors-index>--}}
{{--    <div class="content-header">--}}
{{--        <div class="card collapsed-card">--}}
{{--            <div class="card-header">--}}
{{--                <h1 class="card-title">{{$competition->title}} ({{ \App\Models\Competition::competitorsCount($competition->id)}} человек)</h1>--}}
{{--                <div class="card-tools">--}}
{{--                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">--}}
{{--                        <i class="fas fa-plus"></i>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-body" style="display: block;">--}}
{{--                @if(!\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_PARENTED--}}
{{--                    || \App\Models\User::getRoleCode() == \App\Models\Role::ROLE_COACH--}}
{{--                    || \App\Models\User::getRoleCode() == \App\Models\Role::ROLE_REFEREE--}}
{{--                    || \App\Models\Competition::getOwner($competition->id))--}}
{{--                <a class="btn btn-default" href="{{$competition->linkreport}}">Положение и отчеты</a>--}}
{{--                <div class="p-3 control-sidebar-content">--}}
{{--                    <form method="GET" action="{{url()->current()}}">--}}
{{--                        <h6>Тренер</h6>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-9">--}}
{{--                                <select class="custom-select mb-3 text-light border-0 bg-white" name="coach_id">--}}
{{--                                    <option value="">Все</option>--}}
{{--                                    @if(isset($coaches) && \App\Models\User::getRoleCode() != \App\Models\Role::ROLE_COACH)--}}
{{--                                        @foreach($coaches as $coach)--}}
{{--                                            <option value="{{$coach->id}}" @if(\Illuminate\Support\Facades\Request::input('coach_id') == $coach->id) selected @endif>--}}
{{--                                                {{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0, 1)}}.{{mb_substr($coach->user->patronymic, 0, 1)}}.</option>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
{{--                                        <option value="{{$coach->id}}" @if(\Illuminate\Support\Facades\Request::input('coach_id') == $coach->id) selected @endif>--}}
{{--                                            {{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0, 1)}}.{{mb_substr($coach->user->patronymic, 0, 1)}}.--}}
{{--                                        </option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <h6>Возраст</h6>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-9">--}}
{{--                                <select class="custom-select mb-3 text-light border-0 bg-white" name="agecategory_id">--}}
{{--                                    <option value="">Все</option>--}}
{{--                                        @foreach($agecategories as $agecategory)--}}
{{--                                        <option value="{{$agecategory->id}}" @if(\Illuminate\Support\Facades\Request::input('agecategory_id') == $agecategory->id) selected @endif>--}}
{{--                                            {{$agecategory->title}} ({{ \App\Models\Competition::competitorsCountAgecategory($competition->id, $agecategory->id)}} человек)--}}
{{--                                        </option>--}}
{{--                                        @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <h6>Весовая категория</h6>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-9">--}}
{{--                                <select class="custom-select mb-3 text-light border-0 bg-white" name="weightcategory_id">--}}
{{--                                    <option value="">Все</option>--}}
{{--                                        @foreach($weightcategories as $weightcategory)--}}
{{--                                            <option value="{{$weightcategory->id}}" @if(\Illuminate\Support\Facades\Request::input('weightcategory_id') == $weightcategory->id) selected @endif>--}}
{{--                                                {{$weightcategory->title}} ({{ \App\Models\Competition::competitorsCountWeightcategory($competition->id, $weightcategory->id)}} человек)--}}
{{--                                                @if($weightcategory->gender == \App\Models\Athlete::GENDER_MALE)--}}
{{--                                                    м.--}}
{{--                                                @else--}}
{{--                                                    ж.--}}
{{--                                                    @endif--}}
{{--                                            </option>--}}
{{--                                        @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <h6>Группа</h6>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-9">--}}
{{--                                <select class="custom-select mb-3 text-light border-0 bg-white" name="tehkvalgroup_id">--}}
{{--                                    <option value="">Все</option>--}}
{{--                                        @foreach($tehkvalgroups as $tehkvalgroup)--}}
{{--                                            <option value="{{$tehkvalgroup->id}}" @if(\Illuminate\Support\Facades\Request::input('tehkvalgroup_id') == $tehkvalgroup->id) selected @endif>--}}
{{--                                                {{$tehkvalgroup->title}} ({{ \App\Models\Competition::competitorsCountTehkvalgroup($competition->id, \Illuminate\Support\Facades\Request::input('weightcategory_id'), $tehkvalgroup->id)}} человек)--}}
{{--                                            </option>--}}
{{--                                        @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="col">--}}
{{--                                <button type="submit" class="btn btn-info"><i class="fas fa-check"></i></button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--    <!-- /.content-header -->--}}
{{--    <section class="content">--}}
{{--        @if (session('status'))--}}
{{--            <div class="alert alert-success">--}}
{{--                {{ session('status') }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--            <competitors-list :competition_id="{{$competition->id}}"></competitors-list>--}}
{{--        @foreach ($competitors as $competitor)--}}
{{--            <div @if($competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE)class="card card-primary collapsed-card" @else class="card card-danger collapsed-card" @endif>--}}
{{--                <div class="card-header">--}}
{{--                    <span><img class="direct-chat-img" src="@if(!$competitor->athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{$competitor->athlete->photo}}@endif" alt="message user image"></span>--}}
{{--                    <h3 class="card-title">{{$competitor->athlete->user->secondname}} {{$competitor->athlete->user->firstname}} {{$competitor->athlete->user->patronymic}}</h3>--}}

{{--                    @if(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_ORGANIZATION_ADMIN)--}}
{{--                        <span class="badge badge-success" data-toggle="modal" style="cursor: pointer" data-target="#modal-competitior-result{{$competitor->id}}">--}}
{{--                                внести результаты</span>--}}

{{--                        modal edit active-athlete--}}
{{--                        <div class="modal fade" id="modal-competitior-result{{$competitor->id}}" style="display: none;" aria-hidden="true">--}}
{{--                            <div class="modal-dialog modal-sm">--}}
{{--                                <div class="modal-content">--}}
{{--                                    <div class="modal-body">--}}
{{--                                        <form method="POST" action="{{route('competitors.update', [$competitor->athlete->id])}}">--}}
{{--                                            <input type="number" style="display: none" class="form-control" name="competition_id" value="{{$competition->id}}">--}}
{{--                                            <input type="number" class="form-control" name="count_winner" placeholder="Количество побед">--}}
{{--                                            <input type="number" class="form-control" name="place" placeholder="Занятое место">--}}
{{--                                            @csrf--}}
{{--                                            @method('PUT')--}}

{{--                                            <div class="modal-footer justify-content-between">--}}

{{--                                                <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>--}}
{{--                                                <button type="submit" class="btn btn-primary">Сохранить</button>--}}
{{--                                            </div>--}}
{{--                                        </form>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                    <br>--}}

{{--                    @if($competitor->athlete->gender == \App\Models\Athlete::GENDER_MALE)--}}
{{--                        <i class="fas fa-male"></i>--}}
{{--                    @else--}}
{{--                        <i class="fas fa-female"></i>--}}
{{--                    @endif - {{$competitor->agecategory->title}} {{$competitor->tehkvalgroup->title}},--}}
{{--                    @foreach($competitor->athlete->coaches as $coaches)--}}
{{--                        Тренер: {{$coaches->user->secondname}} {{substr($coaches->user->firstname, 0,2)}}. {{substr($coaches->user->patronymic, 0, 2)}}.--}}
{{--                    @endforeach--}}
{{--                    <div class="card-tools">--}}
{{--                        <button type="button" class="btn btn-tool" data-card-widget="collapse">--}}
{{--                            <i class="fas fa-plus"></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body" style="display: none;">--}}
{{--                    <b>Дата рождения: </b> {{ \Carbon\Carbon::parse($competitor->athlete->user->date_of_birth)->format('d.m.Y')}}<br>--}}
{{--                    <b>Вес: </b>{{$competitor->weight}}<br>--}}
{{--                        <b>Техническая квалификация: </b>--}}
{{--                    <span--}}
{{--                        @if(\App\Models\Competitor::isCoachAthlete($competitor->athlete->id))--}}
{{--                            data-toggle="modal" data-target="#modal-tehkval-{{$competitor->athlete->id}}"--}}
{{--                        @endif--}}
{{--                    >{{$competitor->athlete->tehkval->last()->title}}</span><br>--}}
{{--                        <b>Спортивная квалификация: </b>{{$competitor->athlete->sportkval->min('short_title')}}<br>--}}
{{--                </div>--}}
{{--                @if(\App\Models\Competitor::isCoachAthlete($competitor->athlete->id)--}}
{{--                    && $competition->open_registration != \App\Models\Competition::REGISTRATION_CLOSE)--}}
{{--                    @elseif(\App\Models\Competition::getOwner($competition->id))--}}
{{--                    <div class="card-footer">--}}
{{--                    <div class="row row-cols-2">--}}
{{--                        <div class="col text-left">--}}
{{--                            <form method="GET" action="{{route('competitors.edit',[$competitor->id])}}">--}}
{{--                                @csrf--}}
{{--                                <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="{{$competition->id}}">--}}
{{--                                <button type="submit" class="btn btn-primary"><i class="fas fa-cog"></i></button>--}}
{{--                            </form>--}}
{{--                            <div class="col text-left">--}}
{{--                                <a target="_blank" href="{{route('printCompetitorsСertificate', ['competitor_id' => $competitor->id, 'competition_id' => $competition->id])}}"><i class="fas fa-file-contract"></i></a>--}}
{{--                            </div>--}}
{{--                            @if(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_REFEREE)--}}
{{--                                <form method="POST" action="{{route('setNamePoomsaeTablo')}}">--}}
{{--                                @csrf--}}
{{--                                <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="{{$competition->id}}">--}}
{{--                                <button type="submit" class="btn btn-danger"><i class="fas fa-tv"></i></button>--}}
{{--                            </form>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="col text-right">--}}
{{--                            <form method="POST" action="{{route('competitors.destroy',$competitor->id)}}">--}}
{{--                                @method('DELETE')--}}
{{--                                @csrf--}}
{{--                                <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="{{$competition->id}}">--}}
{{--                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endif--}}
{{--                @if(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_REFEREE)--}}
{{--                <div class="card-footer">--}}
{{--                    <div class="row row-cols-2">--}}
{{--                        <div class="col text-left">--}}
{{--                            <form method="POST" action="{{route('setNamePoomsaeTablo')}}">--}}
{{--                                    @csrf--}}
{{--                                    <input type="number" style="display: none" class="form-control" id="competitor_id" name="competitor_id" value="{{$competitor->id}}">--}}
{{--                                    <button type="submit" class="btn btn-danger"><i class="fas fa-tv"></i></button>--}}
{{--                                </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </section>--}}

@endsection
