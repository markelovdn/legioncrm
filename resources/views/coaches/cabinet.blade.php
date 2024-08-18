@extends('layouts.main')

@section('content')
<div class="card card-info">
    <div class="card-header">Личный кабинет тренера123</div>
    <div class="card-body">
        {{-- <form method="POST" action="{{route('coach', ['id' => $coach->id])}}">--}}
        <form method="POST" action="/coach/{{$coach->id}}">
            @method('PUT')
            <input type="text" name="url" style="display: none" value="{{url()->current()}}">
            <input type="text" name="role_code" style="display: none" value="coach">
            @csrf
            <dl class="row">
                <dt class="col-sm-4">ФИО</dt>
                <dd class="col-sm-8">{{$coach->user->secondname}} {{$coach->user->firstname}} {{$coach->user->patronymic}}</dd>
            </dl>
            <div class="row mb-3">
                <label for="coach_code" class="col-md-4 col-form-label text-md-end">Код тренера<span class="text-danger">*</span></label>
                <div class="col-md-6">
                    <input type="number" class="form-control" id="coach_code" name="coach_code" value="{{$coach->code}}">
                    @error('coach_code')<p class="text-danger">{{$errors->first('coach_code')}}</p>@enderror
                    @if (session('status'))<p class="text-danger">{{ session('status') }}</p>@endif
                    @if (!$coach->code)<p class="text-danger">Введите код тренера и нажмите отправить</p>@endif
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
        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Сообщение для родителей</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">

                @if ($coach->code)
                <div class="callout callout-danger">
                    <h5>Сообщение для регистрации родителей и спортсменов</h5>
                    <p>Уважаемые родители!</p>
                    <p>Прошу пройти по ссылке ниже и зарегистрироваться в нашем клубе.</p>
                    <p>При регистрации необходимо выбрать тренера: {{$coach->user->secondname}} {{$coach->user->firstname}} {{$coach->user->patronymic}}</p>
                    <p>Ввести код тренера: {{$coach->code}}</p>
                    <p>После регистрации, в личном кабинет необходимо будет заполнить следющу информацию:</p>
                    <p>- загрузить фото занимающегося на белом фоне как на паспорт</p>
                    <p>- паспортные данные родителя</p>
                    <p>- данные свидетельства о рождении или паспорта ребенка</p>
                    <p>Загрузить копии следующих документов:</p>
                    <p>- свидетельство о рождении ребенка</p>
                    <p>- прописка по месту жительства</p>
                    <p>Ссылка для регистрации: {{url('/user/create?parent')}}</p>
                </div>
                @endif
            </div>
        </div>
    </div>



</div>
@endsection