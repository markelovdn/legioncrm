@extends('layouts.main')

@section('content')
    <div class="card card-info">
       @if(isset($coach_athletes))
        <div class="card-header">
            Все спортсмены тренера: {{$coach->user->secondname}} {{$coach->user->firstname}} {{$coach->user->patronymic}} ({{$count_coach_athletes}})
        </div>
        <div class="card-body">
            @foreach($coach_athletes as $athlete)
                {{-- Данные спортсмена--}}
                <div class="card collapsed-card">
                    <div class="card-header">
                        <span><img class="direct-chat-img" src="@if(!$athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{$athlete->photo}}@endif" alt="message user image"></span>
                        <div class="ml-5 mt-2 position-relative">{{$athlete->user->secondname}} {{$athlete->user->firstname}}
                            @if($athlete->status == \App\Models\Athlete::INACTIVE)
                                <span class="badge badge-danger"><i class="far fa-clock"></i>не активный</span>
                            @endif
                            <br>
                            @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14 and !$athlete->passport)
                                <span class="description font-italic ml-3">(Необходимо заполнить паспортные данные)</span>
                                <br>
                            @endif
                            @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() < 14 and !$athlete->birthcertificate_id)
                                <span class="description font-italic ml-3">(Необходимо заполнить данные свидетельства о рождении)</span>
                                <br>
                            @endif
                            @if(!$athlete->studyplace_id)
                                <span class="description font-italic ml-3">(Необходимо заполнить данные о месте учебы)</span>
                                <br>
                            @endif
                            @if(count($athlete->user->address) == 0)
                                <span class="description font-italic ml-3">(Необходимо заполнить данные об адресе по месту прописки)</span>
                            @endif
                        </div>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        {{-- Общие данные--}}
                        @include('athletes.athlete-maindata')
                        {{--/ Общие данные--}}
                        {{-- Свидетельство о рождении/паспорт--}}
                        @if(Carbon\Carbon::parse($athlete->date_of_birth)->diffInYears() >= 14)
                            @if($athlete->passport_id)
                                @include('documents.passport-athlete')
                            @endif
                        @else
                            @if($athlete->birthcertificate_id)
                                @include('documents.birthcertificate')
                            @endif
                        @endif
                        {{--/ Свидетельство о рождении/паспорт--}}

                        {{-- Место учебы --}}
                        @if($athlete->studyplace_id)
                            @include('athletes.athlete-study-place')
                        @endif
                        {{--/ Место учебы --}}
                        {{-- Адресс по прописке--}}

                        @if(count($athlete->user->address) > 0)
                            @include('documents.address-registration')
                        @endif
                        {{-- / Адресс по прописке--}}

                        {{-- Тренеры--}}
                        @include('athletes.athlete-coaches')
                        {{-- / Тренеры--}}

                        {{-- Тренеры--}}
                        @include('athletes.athlete-tehkvals')
                        {{-- / Тренеры--}}

                        <div class="row">
                            @switch(\App\Models\User::getRoleCode())
                                @case(\App\Models\Role::ROLE_COACH)
                                @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
                                <div class="col-auto mr-auto">
                                    @if($athlete->status == \App\Models\Athlete::ACTIVE)
                                        <span class="badge badge-danger" data-toggle="modal" style="cursor: pointer" data-target="#modal-inactive-athlete{{$athlete->user->id}}"><i class="far fa-clock"></i>деактивировать</span>
                                    @else
                                        <span class="badge badge-success" data-toggle="modal" style="cursor: pointer" data-target="#modal-inactive-athlete{{$athlete->user->id}}"><i class="far fa-clock"></i>ативировать</span>
                                    @endif
                                    {{--modal edit active-athlete--}}
                                    <div class="modal fade" id="modal-inactive-athlete{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    @if($athlete->status == \App\Models\Athlete::ACTIVE)
                                                        <form method="POST" action="{{route('athlete.update', [$athlete->id])}}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Подтвердить<i class="fas fa-check"></i></button>
                                                            <input type="text" style="display:none" name="athlete_id" value="{{$athlete->id}}">
                                                            <input type="text" style="display:none" name="user_id" value="{{$athlete->user->id}}">
                                                            <input type="text" style="display:none" name="status" value="{{\App\Models\Athlete::INACTIVE}}">
                                                        </form>
                                                    @else
                                                        <form method="POST" action="{{route('athlete.update', [$athlete->id])}}">
                                                            @method('PUT')
                                                            @csrf
                                                            <button type="submit" class="btn btn-success">Подтвердить<i class="fas fa-check"></i></button>
                                                            <input type="text" style="display:none" name="athlete_id" value="{{$athlete->id}}">
                                                            <input type="text" style="display:none" name="user_id" value="{{$athlete->user->id}}">
                                                            <input type="text" style="display:none" name="status" value="{{\App\Models\Athlete::ACTIVE}}">
                                                        </form>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endswitch
                        </div>

                    </div>
                </div>
                {{--/ Данные спортсмена--}}
            @endforeach
        </div>
        @else
           {{'Нет спортсменов'}}
        @endif
           {{$coach_athletes->links()}}
    </div>
@endsection
