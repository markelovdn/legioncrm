@extends('layouts.main')

@section('content')

<div class="card card-info">
    <div class="card-header">{{ __('auth.Register_parented') }}</div>
    @if(session('error_unique_user'))
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> Внимание</h5>
            {{session('error_unique_user')}}
        </div>
    @endif
    <div class="card-body">
        <form method="POST" action="{{route('user.store')}}">
            <input type="text" name="url" style="display: none" value="{{url()->current()}}">
            <input type="text" name="role_code" style="display: none" value="{{\App\Models\Role::ROLE_PARENTED}}">
            @csrf

            <div class="row mb-3">
                <label for="secondname" class="col-md-4 col-form-label text-md-end">Фамилия<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="secondname" type="text" class="form-control @error('secondname') is-invalid @enderror" name="secondname" value="{{ old('secondname') }}">

                    @error('secondname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="firstname" class="col-md-4 col-form-label text-md-end">Имя<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}">

                    @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="patronymic" class="col-md-4 col-form-label text-md-end">Отчество<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="patronymic" type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ old('patronymic') }}">

                    @error('patronymic')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">Дата рождения<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}">

                    @error('date_of_birth')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <strong><p class="text-danger">{{session('error')}}</p></strong>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="phone" class="col-md-4 col-form-label text-md-end">Мобильный телефон<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="coach_id" class="col-md-4 col-form-label text-md-end">Тренер<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <select type="text" class="form-control" name="coach_id" id="coach_id">
                        <option></option>
                        @foreach($coaches as $coach)
                            <option value="{{$coach->id}}" @if(old('coach_id') == $coach->id) selected @endif>{{$coach->user->secondname}} {{$coach->user->firstname}} {{$coach->user->patronymic}}</option>
                        @endforeach
                    </select>
                    @error('coach_id')<p class="text-danger">{{$errors->first('coach_id')}}</p>@enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="reg_code" class="col-md-4 col-form-label text-md-end">Код тренера<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input type="number" class="form-control"  id="reg_code" name="reg_code" value="{{old('reg_code')}}">
                    @error('reg_code')<p class="text-danger">{{$errors->first('reg_code')}}</p>@enderror
                    <strong><p class="text-danger">{{session('status')}}</p></strong>
                </div>
            </div>
            <div class="row mb-3">
                <label for="password" class="col-md-4 col-form-label text-md-end">Пароль для входа в личный кабинет<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Подтверждение пароля<span class="text-danger">*</span></label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-md-6 offset-md-4 mb-4">
                    <button id="submit" type="submit" onclick="blocked()" class="btn btn-primary">
                        Зарегистрироваться</button>
                    <div class="spinner-border" id="loader" style="display: none" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
