@extends('layouts.main')

@section('content')
    <div class="card card-info">
        <div class="card-header">Личный кабинет организации</div>
        <div class="card-body">
{{--            <form method="POST" action="{{route('org', ['id' => $org->id])}}">--}}
            <form method="POST" action="/organization/{{$org->id}}">
                @method('PUT')
                <input type="text" name="url" style="display: none" value="{{url()->current()}}">
                <input type="text" name="role_code" style="display: none" value="organization_chairman">
                @csrf
                <dl class="row">
                    <dt class="col-sm-4">ФИО руководителя</dt>
                    <dd class="col-sm-8">{{$org->user->secondname}} {{$org->user->firstname}} {{$org->user->patronymic}}</dd>
                </dl>
                <div class="row mb-3">
                    <label for="fulltitle" class="col-md-4 col-form-label text-md-end">Полное наименование организации<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <textarea  class="form-control"  id="fulltitle" name="fulltitle">{{$org->fulltitle}}</textarea>
                        @error('fulltitle')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="shorttitle" class="col-md-4 col-form-label text-md-end">Краткое наименование организации<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control"  id="shorttitle" name="shorttitle" value="{{$org->shorttitle}}">
                        @error('shorttitle')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="address" class="col-md-4 col-form-label text-md-end">Адрес организации<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control"  id="address" name="address" value="{{$org->address}}">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="code" class="col-md-4 col-form-label text-md-end">Код организации<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="number" class="form-control"  id="code" name="code" value="{{$org->code}}">
                        @error('code')<p class="text-danger">{{$errors->first('code')}}</p>@enderror
                        @if (session('status'))<p class="text-danger">{{ session('status') }}</p>@endif
                        @if (!$org->code)<p class="text-danger">Введите код тренера и нажмите отправить</p>@endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Изменить код
                        </button>
                    </div>
                </div>
            </form>

        </div>



    </div>
@endsection
