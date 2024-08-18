@extends('layouts.main')
@section('content')
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">{{$competitor->athlete->user->secondname}} {{$competitor->athlete->user->firstname}} {{$competitor->athlete->user->patronymic}}</h3>
		</div>
        @if (session('error_unique_user'))
            <p class="text-danger">{{ session('error_unique_user') }}</p>
        @endif
		<!-- /.card-header -->
		<!-- form start -->
		<form class="form-horizontal" method="POST" action="{{route('competitors.update', [$competitor->athlete->id])}}">
            @method('PUT')
			@csrf
			<div class="card-body">
                <input type="text" name="competition_id" style="display: none" value="{{$competition_id}}">
				<div class="form-group row">
					<label for="gender" class="col-sm-2 col-form-label">Пол<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<select type="text" class="form-control" name="gender" id="gender">
                            <option></option>
							<option value="1" @if($competitor->athlete->gender == 1) selected @endif>мужской</option>
							<option value="2" @if($competitor->athlete->gender == 2) selected @endif>женский</option>
						</select>
                        @error('gender')<p class="text-danger">{{$errors->first('gender')}}</p>@enderror
					</div>
				</div>
				<div class="form-group row">
					<label for="date_of_birth" class="col-sm-2 col-form-label">Дата рождения<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{$competitor->athlete->user->date_of_birth}}">
						@error('date_of_birth')<p class="text-danger">{{$errors->first('date_of_birth')}}</p>@enderror
                        @if (session('error_age'))<p class="text-danger">{{ session('error_age') }}</p>@endif
					</div>
				</div>
				<div class="form-group row">
					<label for="weight" class="col-sm-2 col-form-label">Вес<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<input type="number" step="0.01" class="form-control" id="weight" name="weight" value="{{$competitor->weight}}">
						@error('weight')<p class="text-danger">{{$errors->first('weight')}}</p>@enderror
                        @if (session('error_weight'))<p class="text-danger">{{ session('error_weight') }}</p>@endif
                        @if (session('error_unique_competitor'))<p class="text-danger">{{ session('error_unique_competitor') }}</p>@endif
					</div>
				</div>
				<div class="form-group row">
					<label for="tehkval_id" class="col-sm-2 col-form-label">Пояс<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<select type="text" class="form-control" name="tehkval_id" id="tehkval_id">
                            <option></option>
							@foreach($tehkvals as $tehkval)
								<option value="{{$tehkval->id}}" @if($competitor->athlete->tehkval->max('id') == $tehkval->id) selected @endif>{{$tehkval->belt_color}} ({{$tehkval->title}})</option>
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
								<option value="{{$sportkval->id}}" @if($competitor->athlete->sportkval->max('id') == $sportkval->id) selected @endif>{{$sportkval->short_title}}</option>
							@endforeach
						</select>
                        @error('sportkval_id')<p class="text-danger">{{$errors->first('sportkval_id')}}</p>@enderror
					</div>
				</div>

                <p class="text-danger">{{ session('error') }}</p>
                <p class="text-danger">{{ session('error_age') }}</p>
                <p class="text-danger">{{ session('error_weight') }}</p>
                <p class="text-danger">{{ session('error_tehkval') }}</p>
                <p class="text-danger">{{ session('error_unique_competitor') }}</p>
                <p class="text-danger">{{ session('status') }}</p>
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

