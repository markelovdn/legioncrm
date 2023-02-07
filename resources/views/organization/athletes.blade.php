@extends('layouts.main')

@section('content')
    <div class="card card-info">

        <div class="card-header">
            Все спортсмены организации: {{$organization->shorttitle}}
        </div>
        @if(!empty($organization_athlete))
        <div class="card-body">
            @foreach($organization_athlete as $athlete)
                {{-- Данные спортсмена--}}
                <div class="card collapsed-card">
                    <div class="card-header">
                        <span data-toggle="modal" data-target="#photo{{$athlete->user->id}}" ><img class="direct-chat-img" src="@if(!$athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{$athlete->photo}}@endif" alt="message user image"></span>
                        <div class="ml-5 mt-2 position-relative">{{$athlete->user->secondname}} {{$athlete->user->firstname}}
                            <br>
                            @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14 and !$athlete->passport)
                                <span class="description font-italic ml-3">(Необходимо заполнить паспортные данные)</span>
                                <br>
                            @endif
                            @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() < 14 and !$athlete->birthcertificate)
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
                    {{-- / Общие данные--}}
                    {{-- Свидетельство о рождении/паспорт--}}
                        @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14)
                            @if(!$athlete->passport_id)
                                @include('documents.passport-blank-for-athlete')
                            @else
                                 @include('documents.passport-athlete')
                            @endif
                        @else
                            @if(!$athlete->birthcertificate_id)
                                @include('documents.birthcertificate-blank')
                            @else
                                @include('documents.birthcertificate')
                            @endif
                        @endif
                    {{--/ Свидетельство о рождении/паспорт--}}

                    {{--Место учебы--}}
                        @if(!$athlete->studyplace_id)
                            @include('athletes.athlete-blank-study-place')
                        @else
                            @include('athletes.athlete-study-place')
                        @endif
                    {{-- / Место учебы--}}
                    {{-- Адресс по прописке--}}
                        @if(count($athlete->user->address) == 0)
                            @include('documents.address-registration-blank')
                        @else
                            @include('documents.address-registration')
                        @endif
                    {{-- / Адресс по прописке--}}
                    {{-- Ежегодный взнос--}}
                        @include('athletes.athlete-year-payment')
                    {{-- / Ежегодный взнос--}}
                        @switch(\App\Models\User::getRoleCode())
                            @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
                            @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
                            @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
                            <div class="row">
                                <div class="col-auto mr-auto">
                                    <span class="badge badge-danger" data-toggle="modal" style="cursor: pointer" data-target="#modal-inactive-athlete{{$athlete->user->id}}"><i class="far fa-clock"></i> деактивировать</span>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-destoy-athlete{{$athlete->user->id}}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>

                            {{--modal edit active-athlete--}}
                            <div class="modal fade" id="modal-inactive-athlete{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form method="POST" action="{{route('athlete.update', [$athlete->id])}}">
                                                @method('PUT')
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Подтвердить<i class="fas fa-check"></i></button>
                                                <input type="text" style="display:none" name="athlete_id" value="{{$athlete->id}}">
                                                <input type="text" style="display:none" name="user_id" value="{{$athlete->user->id}}">
                                                <input type="text" style="display:none" name="status" value="{{\App\Models\Athlete::INACTIVE}}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--modal edit parent-birthsertificate-trash--}}
                            <div class="modal fade" id="modal-destoy-athlete{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Для удаления данных введите код</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endswitch
                    </div>
                </div>
                {{--/ Данные спортсмена--}}

                {{--modal photo--}}
                <div class="modal fade" id="photo{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img class="img-fluid" src="{{$athlete->photo}}" alt="message user image">
                            </div>
                        </div>
                    </div>

                </div>
                {{-- / modal photo--}}


            @endforeach
        </div>
        @else
           {{'Нет спортсменов'}}
        @endif
        {{$organization_athlete->links()}}
    </div>
@endsection
