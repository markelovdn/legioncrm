@extends('layouts.main')
@section('content')
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Новое соревнование</h3>
		</div>

		<!-- /.card-header -->
		<!-- form start -->
		<form class="form-horizontal" method="POST" action="{{route('competitions.store')}}">
			@csrf
			<div class="card-body">
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Название<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
                        @error('title')<p class="text-danger">{{$errors->first('title')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="org_id" class="col-sm-2 col-form-label">Проводящая организация<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="org_id" id="status" class="form-control">
                            @foreach($organizations as $organization)
                                <option value="{{$organization->id}}">{{$organization->shorttitle}}</option>
                            @endforeach
                        </select>
                        @error('org_id')<p class="text-danger">{{$errors->first('org_id')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Статус<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            @foreach($statuses as $status)
                                <option value="{{$status->id}}">{{$status->title}}</option>
                            @endforeach
                        </select>
                        @error('status_id')<p class="text-danger">{{$errors->first('status_id')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_start" class="col-sm-2 col-form-label">Дата начала<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_start" name="date_start" value="{{old('date_start')}}">
                        @error('date_start')<p class="text-danger">{{$errors->first('date_start')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Дата окончания<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_end" name="date_end" value="{{old('date_end')}}">
                        @error('date_end')<p class="text-danger">{{$errors->first('date_end')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Страна<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                            <select name="country_id" id="country_id" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->title}}</option>
                                @endforeach
                            </select>
                        @error('country_id')<p class="text-danger">{{$errors->first('country_id')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Округ<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="district_id" id="district" class="form-control">
                            @foreach($districts as $district)
                                <option value="{{$district->id}}">{{$district->fulltitle}}</option>
                            @endforeach
                        </select>
                        @error('district_id')<p class="text-danger">{{$errors->first('district_id')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Регион<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="region_id" id="region_id" class="form-control">
                            @foreach($regions as $region)
                                <option value="{{$region->id}}">{{$region->title}}</option>
                            @endforeach
                        </select>
                        @error('region_id')<p class="text-danger">{{$errors->first('region_id')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Адрес места проведения<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">
                        @error('address')<p class="text-danger">{{$errors->first('address')}}</p>@enderror
                    </div>
                </div>
				<div class="form-group row">
					<label for="date_end" class="col-sm-2 col-form-label">Возрастные категории<span class="text-danger">*</span></label>
					<div class="col-sm-10">
						<div class="form-check">
							@foreach($agecategories as $agecategory)
							<input class="form-check-input" type="checkbox" name="agecategory[]" value="{{$agecategory->id}}">
							<label class="form-check-label">{{$agecategory->title}}</label><br>
							@endforeach
						</div>
						@error('agecategory_id')<p class="text-danger">{{$errors->first('agecategory_id')}}</p>@enderror
					</div>
				</div>
                <div class="form-group row">
                    <label for="linkreport" class="col-sm-2 col-form-label">Ссылка на папку соревнований<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="linkreport" name="linkreport" value="{{old('linkreport')}}">
                        @error('linkreport')<p class="text-danger">{{$errors->first('linkreport')}}</p>@enderror
                    </div>
                </div>
            </div>
			<!-- /.card-body -->
			<div class="card-footer">
				<button type="submit" class="btn btn-info">Добавить</button>
				<a href="/" type="submit" class="btn btn-default float-right">Отменить</a>
			</div>
			<!-- /.card-footer -->
		</form>
	</div>

@endsection

