@extends('layouts.main')
@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Добавить участников {{$attestation->title}} {{ \Carbon\Carbon::parse($attestation->date)->format('d.m.Y')}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
</div>
@if (session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif
@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif
{{-- TODO:сделать всплывающие окна--}}

@foreach($attestationAthletes as $attestationAthlete)
<form class="form-horizontal" method="POST" action="{{route('attestation.athletes.store', [$attestation->id])}}">
    @csrf
    <div class="container-fluid d-flex flex-column text-center">
        <div class="row mt-1 mb-1">

            <div class="col-5">{{$attestationAthlete->user->secondname}} {{$attestationAthlete->user->firstname}} {{$attestationAthlete->user->patronymic}}</div>
            <div class="col-3">{{$attestationAthlete->tehkval->last()->title}} <i class="fas fa-arrow-right"></i> {{$GetattestationAthletes->getNextTehkval($attestationAthlete->id)}}</div>
            <div class="col-4"><button id="submit" type="submit" onclick="blocked()" class="btn btn-info">Добавить</button>
                <div class="spinner-border" id="loader" style="display: none" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div class="col">
                <input type="number" style="display: none" class="form-control" id="athlete_id" name="athlete_id" value="{{$attestationAthlete->id}}">
                <input type="number" style="display: none" class="form-control" id="attestation_id" name="attestation_id" value="{{$attestation->id}}">

            </div>
            <div class="col">
            </div>
        </div>
    </div>
</form>
@endforeach
<!-- /.card-footer -->

@endsection