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
                    <input type="text" style="display: none"  class="form-control" id="sportkval_id" name="sportkval_id" value="{{$competitor->sportkval->max('id') ?? 1}}">
                    <input type="text" style="display: none"  class="form-control" id="tehkval_id" name="tehkval_id" value="{{$competitor->tehkval->max('id') ?? 1}}">
                    @error('weight')<p class="text-danger">{{$errors->first('weight')}}</p>@enderror

                    <p class="text-danger">{{ session('error_age') }}</p>
                    <p class="text-danger">{{ session('error_weight') }}</p>
                    <p class="text-danger">{{ session('error_tehkval') }}</p>
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

    <!--modal-new-athlete-user-->
    <div class="modal fade" id="modal-competitor-user-add" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <strong>
                        Новый спортсмен
                    </strong>
                </div>
                <form method="POST" action="{{route('competitors-new-user', [$competition->id])}}" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="competition_id" value="{{$competition->id}}" style="display: none">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="photo" class="col-md-4 col-form-label text-md-end">Фото<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input  @error('photo') is-invalid @enderror" name="photo" id="photo" value="{{ old('photo') }}">
                                    <label class="custom-file-label" for="photo"></label>
                                </div>
                            </div>
                            <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gender" class="col-md-4 col-form-label text-md-end">Пол<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <select type="text" class="form-control @error('gender') is-invalid @enderror"  name="gender" id="gender" value="{{ old('gender') }}">
                                <option></option>
                                <option value="{{\App\Models\Athlete::GENDER_MALE}}" @if(old('gender') == \App\Models\Athlete::GENDER_MALE) selected @endif>Мужской</option>
                                <option value="{{\App\Models\Athlete::GENDER_FEMALE}}" @if(old('gender') == \App\Models\Athlete::GENDER_FEMALE) selected @endif>Женский</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="secondname" class="col-md-4 col-form-label text-md-end">Фамилия<span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input id="secondname" type="text" class="form-control @error('secondname') is-invalid @enderror" name="secondname" value="{{ old('secondname') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="firstname" class="col-md-4 col-form-label text-md-end">Имя<span class="text-danger">*</span></label>

                        <div class="col-md-6">
                            <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="patronymic" class="col-md-4 col-form-label text-md-end">Отчество<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input id="patronymic" type="text" class="form-control @error('patronymic') is-invalid @enderror" name="patronymic" value="{{ old('patronymic') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">Дата рождения<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="weight" class="col-md-4 col-form-label">Вес<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input type="number" name="weight" step="0.01" class="form-control" id="weight">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tehkval_id" class="col-md-4 col-form-label">Пояс<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <select type="text" class="form-control" name="tehkval_id" id="tehkval_id">
                                @foreach($tehkvals as $tehkval)
                                <option value="{{$tehkval->id}}">{{$tehkval->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sportkval_id" class="col-md-4 col-form-label">Разряд<span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <select type="text" class="form-control" name="sportkval_id" id="sportkval_id">
                                @foreach($sportkvals as $sportkval)
                                    <option value="{{$sportkval->id}}">{{$sportkval->short_title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

