@extends('layouts.main')

@section('content')
    <div class="card card-info">
       @if(isset($coach_athletes))
        <div class="card-header">
            Все спортсмены тренера: {{$coach->user->secondname}} {{$coach->user->firstname}} {{$coach->user->patronymic}} ({{$count_coach_athletes}})
        </div>
        <div class="card-body">
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

                        {{-- Техническая квалификация--}}
                        @include('athletes.athlete-tehkvals')
                        {{-- / Техническая квалификация--}}

                        {{-- Ежегодный взнос--}}
                        @include('athletes.athlete-year-payment')
                        {{-- / Ежегодный взнос--}}

                        <change-status-button :athlete_id="{{$athlete->id}}"></change-status-button>
                        <div class="row">
                            <a target="_blank" href="{{route('printCscaCard',['id' => $athlete->id])}}"><i class="fas fa-file-contract"></i></a>
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
