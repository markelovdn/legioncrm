@extends('layouts.main')

@section('content')
    <div class="card card-info">
       @if(isset($coach))
        <div class="card-header">
            Все спортсмены тренера: {{$coach->user->secondname}} {{$coach->user->firstname}} {{$coach->user->patronymic}}
        </div>
        <div class="card-body">
            @foreach($coach->athletes as $athlete)
                {{-- Данные спортсмена--}}
                <div class="card collapsed-card">
                    <div class="card-header">
                        <span><img class="direct-chat-img" src="@if(!$athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{$athlete->photo}}@endif" alt="message user image"></span>
                        <div class="ml-5 mt-2 position-relative">{{$athlete->user->secondname}} {{$athlete->user->firstname}}
                            <br>
                            @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14 and !$athlete->passport)
                                <span class="description font-italic ml-3">(Необходимо заполнить паспортные данные)</span>
                                <br>
                            @endif
                            @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() <= 14 and !$athlete->birthcertificate)
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
                        @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14)
                            @if(!$athlete->passport_id)

                            @else
                                {{--                            @include('documents.passport')--}}
                                <div class="card collapsed-card">
                                    <div class="card-header">
                                        <h3 class="card-title">Паспортные данные</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="display: none;">
                                        <div class="card-body">
                                            <dl class="row">
                                                <dt class="col-sm-4">Серия номер:</dt>
                                                <dd class="col-sm-8">{{$athlete->passport->series}} {{$athlete->passport->number}}</dd>
                                                <dt class="col-sm-4">Выдан:</dt>
                                                <dd class="col-sm-8">{{$athlete->passport->dateissue}}, {{$athlete->passport->issuedby}}</dd>
                                                <dt class="col-sm-4">Код подразделения:</dt>
                                                <dd class="col-sm-8">{{$athlete->passport->code}}</dd>
                                                <dt class="col-sm-4">Скачать скан копию:</dt>
                                                <dd class="col-sm-8"><a href="{{$athlete->passport->scanlink}}">Скачать</a></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            @if(!$athlete->birthcertificate_id)

                            @else
                                @include('documents.birthcertificate')
                            @endif
                        @endif
                        {{--/ Свидетельство о рождении/паспорт--}}

                        {{-- Место учебы --}}
                        @if(!$athlete->studyplace_id)

                        @else
                            @include('athletes.athlete-study-place')
                        @endif
                        {{--/ Место учебы --}}
                        {{-- Адресс по прописке --}}
                        @if(count($athlete->user->address) == 0)

                        @else
                            @include('documents.address-registration')
                        @endif
                        {{--/ Адресс по прописке --}}

                    </div>
                </div>
                {{--/ Данные спортсмена--}}
            @endforeach
        </div>
        @else
           {{'Нет спортсменов'}}
        @endif
    </div>
@endsection
