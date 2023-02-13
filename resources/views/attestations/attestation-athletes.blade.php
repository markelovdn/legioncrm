@extends('layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="card collapsed-card">
            <div class="card-header">
                <h1 class="card-title">{{$attestation->title}} {{ \Carbon\Carbon::parse($attestation->date)->format('d.m.Y')}}</h1>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
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
        @foreach ($athletes as $athlete)
            <div @if($athlete->gender == \App\Models\Athlete::GENDER_MALE)class="card card-primary collapsed-card" @else class="card card-danger collapsed-card" @endif>
                <div class="card-header">
                    <span><img class="direct-chat-img" src="@if(!$athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{$athlete->photo}}@endif" alt="message user image"></span>
                    <h3 class="card-title">{{$athlete->user->secondname}} {{$athlete->user->firstname}} {{$athlete->user->patronymic}}</h3><br>
                    <h3 class="card-title">{{$athlete->tehkval->last()->title}} <i class="fas fa-arrow-right"></i> {{\App\BusinessProcess\GetAttestationAthletes::getNextTehkval($athlete->id)}}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <b>Дата рождения: </b> {{ \Carbon\Carbon::parse($athlete->user->date_of_birth)->format('d.m.Y')}}<br>
                    <b>Техническая квалификация: </b>
                    <span @if(\App\Models\Athlete::isCoachAthlete($athlete->id)) data-toggle="modal" data-target="#modal-tehkval-{{$athlete->id}}" @endif>
                        {{$athlete->tehkval->last()->title}}
                    </span><br>
                </div>
                @if(\App\Models\Athlete::isCoachAthlete($athlete->id))
                <div class="card-footer">
                    <div class="row row-cols-2">
                        <div class="col text-left">
{{--                            <a class="btn btn-primary" href="{{route('attestation.athlete.edit',[$athlete->id])}}"><i class="fas fa-cog"></i></a>--}}
                        </div>
                        <div class="col text-right">
                            <form method="POST" action="">
                                @method('DELETE')
                                @csrf
                                <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="{{$athlete->id}}">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
{{--                @include('athletes.tehkval-history-modal')--}}
        @endforeach
    </section>

@endsection

