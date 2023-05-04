@extends('layouts.main')

@section('content')
    <div class="card card-info">

        <div class="card-header">
            Все спортсмены организации: {{$organization->shorttitle}} ({{$count_athletes}})
        </div>
        @if(!empty($organization_athlete))
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @foreach($organization_athlete as $athlete)
                {{-- Данные спортсмена--}}
                <div class="card collapsed-card">
                    <div class="card-header">
                        <span data-toggle="modal" data-target="#photo{{$athlete->user->id}}" >
                            <img class="direct-chat-img"
                                 src="@if(!$athlete->photo){{asset('/storage/images/no_photo.jpg')}}@else{{$athlete->photo}}@endif"
                                 alt="message user image">
                        </span>
                        <div class="ml-5 mt-2 position-relative">{{$athlete->user->secondname}} {{$athlete->user->firstname}}
                            @if($athlete->status == \App\Models\Athlete::INACTIVE)
                                <span class="badge badge-danger"><i class="far fa-clock"></i>не активный</span>
                            @endif
                            <br>
                            @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14 and !$athlete->passport)
                                <span class="description font-italic ml-3">(Необходимо заполнить паспортные данные)</span>
                                <br>
                            @endif
                            @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() < 14 and !$athlete->birthcertificate)
                                <span class="description font-italic ml-3">(Необходимо заполнить данные свидетельства о рождении)</span>
                                <br>
                            @endif
                            @if(!$athlete->studyplace_id)
                                <span class="description font-italic ml-3">(Необходимо заполнить данные о месте учебы)</span>
                                <br>
                            @endif
                            @if(count($athlete->user->address) == 0)
                                <span class="description font-italic ml-3">(Необходимо заполнить данные об адресе по месту прописки)</span>
                            @endif
                        </div>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                    {{-- Общие данные--}}
                        @include('athletes.athlete-maindata')
                    {{-- / Общие данные--}}
                    {{-- Свидетельство о рождении/паспорт--}}
                        @if(Carbon\Carbon::parse($athlete->user->date_of_birth)->diffInYears() >= 14)
                            @if(!$athlete->passport_id)
                                @include('documents.passport-blank-for-athlete')
                            @else
                                 @include('documents.passport-athlete')
                            @endif
                        @else
                            @if(!$athlete->birthcertificate_id)
                                @include('documents.birthcertificate-blank')
                            @else
                                @include('documents.birthcertificate')
                            @endif
                        @endif
                    {{--/ Свидетельство о рождении/паспорт--}}

                    {{--Место учебы--}}
                        @if(!$athlete->studyplace_id)
                            @include('athletes.athlete-blank-study-place')
                        @else
                            @include('athletes.athlete-study-place')
                        @endif
                    {{-- / Место учебы--}}
                    {{-- Адресс по прописке--}}
                        @if(count($athlete->user->address) == 0)
                            @include('documents.address-registration-blank')
                        @else
                            @include('documents.address-registration')
                        @endif
                    {{-- / Адресс по прописке--}}
                    {{-- Ежегодный взнос--}}
                        @include('athletes.athlete-year-payment')
                    {{-- / Ежегодный взнос--}}
                    {{-- Тренеры--}}
                        @include('athletes.athlete-coaches')
                    {{-- / Тренеры--}}

                    {{-- Техническая квалификация--}}
                    @include('athletes.athlete-tehkvals')
                    {{-- / Техническая квалификация--}}
                            <div class="row">
                                @switch(\App\Models\User::getRoleCode())
                                    @case(\App\Models\Role::ROLE_SYSTEM_ADMIN)
                                    @case(\App\Models\Role::ROLE_ORGANIZATION_CHAIRMAN)
                                    @case(\App\Models\Role::ROLE_ORGANIZATION_ADMIN)
                                    <div class="col-auto mr-auto">
                                        @if($athlete->status == \App\Models\Athlete::ACTIVE)
                                            <span class="badge badge-danger" data-toggle="modal" style="cursor: pointer" data-target="#modal-inactive-athlete{{$athlete->user->id}}"><i class="far fa-clock"></i>деактивировать</span>
                                        @else
                                            <span class="badge badge-success" data-toggle="modal" style="cursor: pointer" data-target="#modal-inactive-athlete{{$athlete->user->id}}"><i class="far fa-clock"></i>ативировать</span>
                                        @endif
                                        {{--modal edit active-athlete--}}
                                        <div class="modal fade" id="modal-inactive-athlete{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        @if($athlete->status == \App\Models\Athlete::ACTIVE)
                                                            <form method="POST" action="{{route('athlete.update', [$athlete->id])}}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger">Подтвердить<i class="fas fa-check"></i></button>
                                                                <input type="text" style="display:none" name="athlete_id" value="{{$athlete->id}}">
                                                                <input type="text" style="display:none" name="user_id" value="{{$athlete->user->id}}">
                                                                <input type="text" style="display:none" name="status" value="{{\App\Models\Athlete::INACTIVE}}">
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{route('athlete.update', [$athlete->id])}}">
                                                                @method('PUT')
                                                                @csrf
                                                                <button type="submit" class="btn btn-success">Подтвердить<i class="fas fa-check"></i></button>
                                                                <input type="text" style="display:none" name="athlete_id" value="{{$athlete->id}}">
                                                                <input type="text" style="display:none" name="user_id" value="{{$athlete->user->id}}">
                                                                <input type="text" style="display:none" name="status" value="{{\App\Models\Athlete::ACTIVE}}">
                                                            </form>
                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endswitch
                                @if(\App\Models\User::getRoleCode() == 'system_admin')
                                <div class="col-auto">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-destoy-athlete{{$athlete->user->id}}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    {{--modal athlete-destroy--}}
                                    <div class="modal fade" id="modal-destoy-athlete{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Для удаления данных введите код</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{route('athlete.destroy',[$athlete->id])}}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <input type="text" name="user_id" style="display: none" value="{{$athlete->user->id}}">
                                                        <div class="row mb-3">
                                                            <label for="code" class="col-md-4 col-form-label text-md-end">Код<span class="text-danger">*</span></label>
                                                            <div class="col-md-6">
                                                                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{old('code')}}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                            <button type="submit" class="btn btn-danger">Удалить</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                    </div>
                </div>
                {{--/ Данные спортсмена--}}

                {{--modal photo--}}
                <div class="modal fade" id="photo{{$athlete->user->id}}" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <img class="img-fluid" src="{{$athlete->photo}}" alt="message user image">
                                <form method="POST" action="{{route('athlete.update',[$athlete->id])}}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="id" style="display: none" value="{{$athlete->id}}">
                                    <input type="text" name="user_id" style="display: none" value="{{$athlete->user->id}}">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input  @error('photo') is-invalid @enderror" name="photo" id="photo">
                                        <label class="custom-file-label" for="photo"></label>
                                        <button type="submit" class="btn btn-primary">Поменять фото</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- / modal photo--}}
            @endforeach
        </div>
        @else
           {{'Нет спортсменов'}}
        @endif
        {{$organization_athlete->links()}}
    </div>

    <!--modal-new-athlete-user-->
{{--    <div class="modal fade" id="modal-athlete-user-add" style="display: none;" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-md">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <strong>--}}
{{--                        Новый спортсмен--}}
{{--                    </strong>--}}
{{--                </div>--}}
{{--                <form method="POST" action="{{route('athlete.store')}}" enctype="multipart/form-data">--}}
{{--                    @csrf--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="photo" class="col-md-4 col-form-label text-md-end">Фото<span class="text-danger"></span></label>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="input-group">--}}
{{--                                    <div class="custom-file">--}}
{{--                                        <input type="file" class="custom-file-input  @error('photo') is-invalid @enderror" name="photo" id="photo" value="{{ old('photo') }}">--}}
{{--                                        <label class="custom-file-label" for="photo"></label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="gender" class="col-md-4 col-form-label text-md-end">Пол<span class="text-danger">*</span></label>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <select type="text" class="form-control @error('gender') is-invalid @enderror"  name="gender" id="gender" value="{{ old('gender') }}">--}}
{{--                                    <option></option>--}}
{{--                                    <option value="{{\App\Models\Athlete::GENDER_MALE}}" @if(old('gender') == \App\Models\Athlete::GENDER_MALE) selected @endif>Мужской</option>--}}
{{--                                    <option value="{{\App\Models\Athlete::GENDER_FEMALE}}" @if(old('gender') == \App\Models\Athlete::GENDER_FEMALE) selected @endif>Женский</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="secondname" class="col-md-4 col-form-label text-md-end">Фамилия<span class="text-danger">*</span></label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="secondname" type="text" class="form-control @error('secondname') is-invalid @enderror" name="secondname" value="{{ old('secondname') }}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="firstname" class="col-md-4 col-form-label text-md-end">Имя<span class="text-danger">*</span></label>--}}

{{--                            <div class="col-md-6">--}}
{{--                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="patronymic" class="col-md-4 col-form-label text-md-end">Отчество<span class="text-danger">*</span></label>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <input id="patronymic" type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ old('patronymic') }}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">Дата рождения<span class="text-danger">*</span></label>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group row">--}}
{{--                            <label for="gender" class="col-md-4 col-form-label text-md-end">Тренер<span class="text-danger">*</span></label>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <select type="text" class="form-control" name="coach_id" id="coach_id">--}}
{{--                                    <option></option>--}}
{{--                                    @foreach($coaches as $coach)--}}
{{--                                    <option value="{{$coach->id}}">{{$coach->user->secondname}} {{$coach->user->firstname}} {{$coach->user->patronymic}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}


{{--                    </div>--}}
{{--                    <div class="modal-footer justify-content-between">--}}
{{--                        <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>--}}
{{--                        <button type="submit" class="btn btn-primary">Отправить</button>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

