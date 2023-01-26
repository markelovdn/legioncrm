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
                        <span><img class="direct-chat-img" src="@if(!$athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{$athlete->photo}}@endif" alt="message user image"></span>
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
                        {{--/ Общие данные--}}
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

                        {{-- Место учебы --}}
                        @if(!$athlete->studyplace_id)
                            @include('athletes.athlete-blank-study-place')
                        @else
                            @include('athletes.athlete-study-place')
                        @endif
                        {{--/ Место учебы --}}
                        {{-- Адресс по прописке --}}
                        @if(count($athlete->user->address) == 0)
                            @include('documents.address-registration-blank')
                        @else
                            @include('documents.address-registration')
                        @endif
                        {{--/ Адресс по прописке --}}
                        {{-- Ежегодный взнос --}}
                        @include('athletes.athlete-year-payment')
                        {{--/ Ежегодный взнос --}}
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
