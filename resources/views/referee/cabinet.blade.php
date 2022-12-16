@extends('layouts.main')

@section('content')
    <div class="card card-info">
        <div class="card-header">Личный кабинет судьи</div>
        <div class="card-body">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form class="needs-validation" method="POST" action="{{route('grade.store')}}">
                @csrf
                <div class="row g-3">
                    <div class="col-sm-12">
                        <label for="grade" class="form-label">Оценка</label>
                        <input type="number" class="form-control" name="grade" id="grade" step="0.1">
                    </div>
                </div>
                <hr class="my-4">
                <button class="w-100 btn btn-primary btn-lg" type="submit">Отправить оценку</button>
            </form>

        </div>

    </div>
@endsection
