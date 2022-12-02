@extends('layouts.main')
@section('content')
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Внесите данные участника соревнований {{$competition->title}}</h3>
		</div>
		<!-- /.card-header -->
		<!-- form start -->
    </div>

    @foreach($competitors as $competitor)
    <form class="form-horizontal" method="POST" action="{{route('competitions.competitors.store', [$competition->id])}}">
        @csrf
        <div class="container-fluid d-flex flex-column text-center">
            <div class="row mt-1 mb-1" style="background: white">
                <div class="col">{{$competitor->user->secondname}} {{$competitor->user->firstname}} {{$competitor->user->patronymic}}</div>
                <label for="weight">Вес<span class="text-danger">*</span></label>
                <div class="col">
                    <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{old('weight')}}">
                    <input type="number" style="display: none" class="form-control" id="athlete_id" name="athlete_id" value="{{$competitor->id}}">
                    <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="{{$competition->id}}">
                    @error('weight')<p class="text-danger">{{$errors->first('weight')}}</p>@enderror
                    @if (session('error'))<p class="text-danger">{{ session('error') }}</p>@endif
                    <p class="text-danger">{{ session('error_unique_competitor') }}</p>
                </div>
                <div class="col">
                    <button id="submit" type="submit" onclick="blocked()" class="btn btn-info">Добавить</button>
                    <div class="spinner-border" id="loader" style="display: none" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach
    <!-- /.card-footer -->

@endsection

