@extends('layouts.main')
@section('content')
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Внесите данные участника соревнований {{$competition->name}}</h3>
		</div>
        @if (session('error_unique_user'))
            <p class="text-danger">{{ session('error_unique_user') }}</p>
        @endif
		<!-- /.card-header -->
		<!-- form start -->
		<form class="form-horizontal" method="POST" action="/competitions/{id}/competitors-new-user">
			@csrf
            <input type="number" style="display: none" class="form-control" id="competition_id" name="competition_id" value="{{$competition->id}}">
			<div class="card-body">
				<div class="form-group row">
					<label for="gender" class="col-sm-2 col-form-label">Пол<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<select type="text" class="form-control" name="gender" id="gender">
                            <option></option>
							<option value="1" @if(old('gender') == '1') selected @endif>мужской</option>
							<option value="2" @if(old('gender') == '2') selected @endif>женский</option>
						</select>
                        @error('gender')<p class="text-danger">{{$errors->first('gender')}}</p>@enderror
					</div>
				</div>
				<div class="form-group row">
					<label for="secondname" class="col-sm-2 col-form-label">Фамилия<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="secondname" name="secondname" value="{{old('secondname')}}">
						@error('secondname')<p class="text-danger">{{$errors->first('secondname')}}</p>@enderror
					</div>
				</div>
				<div class="form-group row">
					<label for="firstname" class="col-sm-2 col-form-label">Имя<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="firstname" name="firstname" value="{{old('firstname')}}">
						@error('firstname')<p class="text-danger">{{$errors->first('firstname')}}</p>@enderror
					</div>
				</div>
				<div class="form-group row">
					<label for="patronymic" class="col-sm-2 col-form-label">Отчество<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="patronymic" name="patronymic" value="{{old('patronymic')}}">
						@error('patronymic')<p class="text-danger">{{$errors->first('patronymic')}}</p>@enderror
					</div>
				</div>
				<div class="form-group row">
					<label for="date_of_birth" class="col-sm-2 col-form-label">Дата рождения<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{old('date_of_birth')}}">
						@error('date_of_birth')<p class="text-danger">{{$errors->first('date_of_birth')}}</p>@enderror
                        @if (session('error_age'))<p class="text-danger">{{ session('error_age') }}</p>@endif
					</div>
				</div>
				<div class="form-group row">
					<label for="weight" class="col-sm-2 col-form-label">Вес<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{old('weight')}}">
						@error('weight')<p class="text-danger">{{$errors->first('weight')}}</p>@enderror
                        @if (session('error_weight'))<p class="text-danger">{{ session('error_weight') }}</p>@endif
					</div>
				</div>
				<div class="form-group row">
					<label for="tehkval_id" class="col-sm-2 col-form-label">Пояс<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<select type="text" class="form-control" name="tehkval_id" id="tehkval_id">
                            <option></option>
							@foreach($tehkvals as $tehkval)
								<option value="{{$tehkval->id}}" @if(old('tehkval_id') == $tehkval->id) selected @endif>{{$tehkval->belt_color}} ({{$tehkval->title}})</option>
							@endforeach
						</select>
						@error('tehkval_id')<p class="text-danger">{{$errors->first('tehkval_id')}}</p>@enderror
                        @if (session('error_tehkval'))<p class="text-danger">{{ session('error_tehkval') }}</p>@endif
					</div>
				</div>
				<div class="form-group row">
					<label for="sportkval_id" class="col-sm-2 col-form-label">Разряд<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<select type="text" class="form-control" name="sportkval_id" id="sportkval_id">
                            <option></option>
							@foreach($sportkvals as $sportkval)
								<option value="{{$sportkval->id}}" @if(old('sportkval_id') == $sportkval->id) selected @endif>{{$sportkval->short_title}}</option>
							@endforeach
						</select>
                        @error('sportkval_id')<p class="text-danger">{{$errors->first('sportkval_id')}}</p>@enderror
					</div>
				</div>
				<div class="form-group row">
					<label for="coach_id" class="col-sm-2 col-form-label">Тренер<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<select type="text" class="form-control" name="coach_id" id="coach_id">
                            <option></option>
							@foreach($coaches as $coach)
								<option value="{{$coach->id}}" @if(old('coach_id') == $coach->id) selected @endif>{{$coach->user->secondname}} {{$coach->user->firstname}} {{$coach->user->patronymic}}</option>
							@endforeach
						</select>
                        @error('coach_id')<p class="text-danger">{{$errors->first('coach_id')}}</p>@enderror
					</div>
				</div>
				<div class="form-group row">
					<label for="coach_code" class="col-sm-2 col-form-label">Код тренера<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="number" class="form-control" id="coach_code" name="coach_code" value="{{old('coach_code')}}">
						@error('coach_code')<p class="text-danger">{{$errors->first('coach_code')}}</p>@enderror
						@if (session('status'))<p class="text-danger">{{ session('status') }}</p>@endif
					</div>
				</div>
			</div>
			<!-- /.card-body -->
			<div class="card-footer">
				<button id="submit" type="submit" onclick="blocked()" class="btn btn-info">Добавить</button>
				<a href="/competitions" type="submit" class="btn btn-default float-right">Отменить</a>
                <div class="spinner-border" id="loader" style="display: none" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

			<!-- /.card-footer -->
		</form>
	</div>

@endsection

