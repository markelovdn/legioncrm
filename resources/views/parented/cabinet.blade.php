@extends('layouts.main')

@section('content')
    <div class="card card-info">
        <div class="card-header">Личный кабинет родителя</div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                {{-- Данные родителя--}}
            <div class="card collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Родитель: {{$parented->user->secondname}} {{$parented->user->firstname}}</h3>
                        @if(!$parented->passport)
                            <span class="description font-italic ml-3">(Необходимо заполнить паспортные данные)</span>
                        @endif
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        @include('parented.main-data')
                        <form method="POST" action="/passport">
                            <input type="text" name="parented_id" style="display: none" value="{{url()->current()}}">
                            @csrf
                            @if(!$parented->passport)
                                @include('documents.passport-blank')
                            @else
                                @include('documents.passport-parent')
                            @endif
                        </form>
                    </div>
                </div>
            {{--/ Данные родителя--}}
            <h5>Занимающиеся в секции:</h5>
                @if(session('error_unique_user'))
                <div class="alert alert-danger">
                    <p>{{ session('error_unique_user') }}</p>
                </div>
                @endif
        @foreach($parented->athletes as $athlete)
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

                    {{-- Тренеры--}}
                    @include('athletes.athlete-coaches')
                    {{-- / Тренеры--}}
                </div>
            </div>
            {{--/ Данные спортсмена--}}
            @endforeach
                   @include('athletes.athlete-blank')
        </div>
    </div>
@endsection




