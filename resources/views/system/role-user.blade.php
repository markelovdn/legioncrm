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

                                <a href="/loginAs?id={{$user->id}}" class="nav-link"><i class="fas fa-sign-in-alt"></i>
                                    <span>{{$user->secondname}}</span>
                                </a>
                            </div>
                            @foreach($roles as $role)
                                <input type="text" style="display:none" name="user_id" value="{{$user->id}}">
                                <div class="col align-content-center">
                                    <input type="checkbox"
                                           @if(\App\Models\User::hasRole($role->code, $user->id)) checked @endif
                                           name="role_id[]" value="{{$role->id}}" class="form-check-input"
                                           @if($role->code == \App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
                                           data-toggle="modal" data-target="#organizations_chairmain"
                                           @endif

                                    @if($role->code == \App\Models\Role::ROLE_ORGANIZATION_ADMIN)
                                           data-toggle="modal" data-target="#organizations_admin"
                                        @endif>
                                    {{--    modal organization chairman--}}
                                        <div class="modal fade" id="organizations_chairmain" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Руководитель организации</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <select class="custom-select" name="orgs[]" multiple>
                                                            @foreach($orgs as $org)
                                                                <option value="{{$org->id}}">{{$org->shorttitle}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                    {{--    modal organization admin--}}
                                        <div class="modal fade" id="organizations_admin" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Администратор организации</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <select class="custom-select" name="orgs[]" multiple>
                                                            @foreach($orgs as $org)
                                                                <option value="{{$org->id}}">{{$org->shorttitle}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>


                                </div>
                            @endforeach
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-check"></i></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col"></div>
                            </div>
                        </div>
                        <hr>
                    </form>
                @endforeach
    {{$users->links()}}
            </div>
        </div>
    </div>
@endsection
