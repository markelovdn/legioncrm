@extends('layouts.main')

@section('content')
    <div class="card card-info">
        <div class="card-header">Вывод на табло</div>
        <div class="card-body">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                <form class="needs-validation" method="POST" action="{{route('setNamePoomsaeTablo')}}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="grade" class="form-label">Выбрать участника</label>
                            <select class="form-control" name="competitor_id" id="">
                                @foreach($competitors as $competitor)
                                    <option value="{{$competitor->id}}">{{$competitor->athlete->user->secondname}} {{$competitor->athlete->user->firstname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr class="my-4">
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Отправить на табло</button>
                </form>
        </div>

    </div>
@endsection
