@extends('layouts.main')

@section('content')
    <div class="card card-info">
        <div class="card-header">Роли пользователей</div>
        <div class="card-body">
            <div class="container-fluid d-flex flex-column text-center">
                <div class="row">
                    <div class="col align-content-center"><h6>ФИО</h6></div>
                    @foreach($roles as $role)
                        <div class="col align-content-center">{{$role->name}}</div>
                    @endforeach
                    <span>Выбор</span>
                </div>
                <hr>
            @foreach($users as $user)
                    <form method="POST" action="/role-user">
                        @csrf
                        <div class="row align-content-center">
                            <div class="col align-content-center">
                                <h6>{{$user->secondname}}</h6>
                                <a href="/loginAs?id={{$user->id}}" class="nav-link"><i class="fas fa-door-open"></i>
                                    </a>
                            </div>
                            @foreach($roles as $role)
                                <input type="text" style="display:none" name="user_id" value="{{$user->id}}">
                                <div class="col align-content-center">
                                    <input type="checkbox"
                                           @if(\App\Models\User::hasRole($role->id, $user->id)) checked @endif
                                           name="role_id[]" value="{{$role->id}}" class="form-check-input">
                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col"><button type="submit" class="btn btn-danger"><i class="fas fa-check"></i></button></div>
                            </div>
                            <div class="row">
                                <div class="col"></div>
                            </div>
                        </div>
                        <hr>
                    </form>
                @endforeach

            </div>
        </div>
    </div>
@endsection
