@extends('layouts.main')

@section('content')
    <div class="card card-info">
        <div class="card-header">Личный кабинет организации</div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card-body">
            <form method="POST" action="/organization/{{$org->id}}" enctype="multipart/form-data">
                @method('PUT')
                <input type="text" name="url" style="display: none" value="{{url()->current()}}">
                <input type="text" name="role_code" style="display: none" value="organization_chairman">
                <input type="text" name="org_id" style="display: none" value="{{$org->id}}">
                @csrf
                <dl class="row">
                    <dt class="col-sm-4">ФИО руководителя</dt>
                    <dd class="col-sm-8">{{$chairman_name}}</dd>
                </dl>
                <div class="row mb-3">
                    <label for="fulltitle" class="col-md-4 col-form-label text-md-end">Полное наименование организации<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <textarea  class="form-control"  id="fulltitle" name="fulltitle">{{$org->fulltitle}}</textarea>
                        @error('fulltitle')
                        <p class="text-danger">{{$errors->first('fulltitle')}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="shorttitle" class="col-md-4 col-form-label text-md-end">Краткое наименование организации<span class="text-danger"></span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control"  id="shorttitle" name="shorttitle" value="{{$org->shorttitle}}">
                        @error('shorttitle')
                        <p class="text-danger">{{$errors->first('shorttitle')}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="address" class="col-md-4 col-form-label text-md-end">Юр. адрес организации<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control"  id="address" name="address" value="{{$org->address}}">
                        @error('address')
                        <p class="text-danger">{{$errors->first('address')}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">Email организации<span class="text-danger"></span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control"  id="email" name="email" value="{{$org->email}}">
                        @error('email')
                        <p class="text-danger">{{$errors->first('email')}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Телефон организации<span class="text-danger"></span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control"  id="phone" name="phone" value="{{$org->phone}}">
                        @error('phone')
                        <p class="text-danger">{{$errors->first('phone')}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inn" class="col-md-4 col-form-label text-md-end">ИНН организации<span class="text-danger"></span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control"  id="inn" name="inn" value="{{$org->inn}}">
                        @error('inn')
                        <p class="text-danger">{{$errors->first('inn')}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="ogrn" class="col-md-4 col-form-label text-md-end">ОГРН организации<span class="text-danger"></span></label>
                    <div class="col-md-6">
                        <input type="text" class="form-control"  id="ogrn" name="ogrn" value="{{$org->ogrn}}">
                        @error('ogrn')
                        <p class="text-danger">{{$errors->first('ogrn')}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="primary_activity" class="col-md-4 col-form-label text-md-end">Основная деятельность<span class="text-danger"></span></label>
                    <div class="col-md-6">
                        <textarea  class="form-control"  id="primary_activity" name="primary_activity">{{$org->primary_activity}}</textarea>
                        @error('primary_activity')
                        <p class="text-danger">{{$errors->first('primary_activity')}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="code" class="col-md-4 col-form-label text-md-end">Код организации<span class="text-danger">*</span></label>
                    <div class="col-md-6">
                        <input type="number" class="form-control"  id="code" name="code" value="{{$org->code}}">
                        @error('code')<p class="text-danger">{{$errors->first('code')}}</p>@enderror
                        @if (!$org->code)<p class="text-danger">Введите код выданный системным администратором и нажмите отправить</p>@endif
                    </div>
                </div>
                <div class="row mb-3">
                    @if(!$org->logo)
                    <label for="logo" class="col-md-4 col-form-label text-md-end">Логотип<span class="text-danger">нет логотипа</span></label>
                    @else
                        <span class="col-md-4">
                        <img class="direct-chat-img" src="{{$org->logo}}" alt="message user image">
                        </span>
                    @endif
                    <div class="col-md-6">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input  @error('logo') is-invalid @enderror" name="logo" id="logo" value="{{ old('logo') }}">
                                <label class="custom-file-label" for="logo"></label>
                            </div>
                        </div>
                        <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Отправить
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
