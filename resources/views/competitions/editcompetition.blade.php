@extends('layouts.main')
@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{$competition->name}}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" method="POST" action="{{route('competitions.update',[$competition->id])}}">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Название<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{$competition->title}}">
                        @error('title')<p class="text-danger">{{$errors->first('title')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Статус<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            @foreach($statuses as $status)
                                <option value="{{$status->id}}"
                                        @if($competition->status == $status->id) selected @endif>{{$status->title}}</option>
                            @endforeach
                        </select>
                        @error('status_id')<p class="text-danger">{{$errors->first('status_id')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="addres" class="col-sm-2 col-form-label">Место проведения<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address"
                               value="{{$competition->address}}">
                        @error('address')<p class="text-danger">{{$errors->first('address')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_start" class="col-sm-2 col-form-label">Дата начала<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_start" name="date_start"
                               value="{{$competition->date_start}}">
                        @error('date_start')<p class="text-danger">{{$errors->first('date_start')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Дата окончания<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_end" name="date_end"
                               value="{{$competition->date_end}}">
                        @error('date_end')<p class="text-danger">{{$errors->first('date_end')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Страна<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="country_id" id="country_id" class="form-control">
                            @foreach($countries as $country)
                                <option value="{{$country->id}}"
                                        @if($competition->country_id == $country->id) selected @endif>{{$country->title}}</option>
                            @endforeach
                        </select>
                        @error('country_id')<p class="text-danger">{{$errors->first('country_id')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Округ<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="district_id" id="district" class="form-control">
                            @foreach($districts as $district)
                                <option value="{{$district->id}}"
                                        @if($competition->district_id == $district->id) selected @endif>{{$district->fulltitle}}</option>
                            @endforeach
                        </select>
                        @error('district_id')<p class="text-danger">{{$errors->first('district_id')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Регион<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="region_id" id="region_id" class="form-control">
                            @foreach($regions as $region)
                                <option value="{{$region->id}}"
                                        @if($competition->region_id == $region->id) selected @endif>{{$region->title}}</option>
                            @endforeach
                        </select>
                        @error('region_id')<p class="text-danger">{{$errors->first('region_id')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="linkreport" class="col-sm-2 col-form-label">Ссылка на папку соревнований<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="linkreport" name="linkreport"
                               value="{{$competition->linkreport}}">
                        @error('linkreport')<p class="text-danger">{{$errors->first('linkreport')}}</p>@enderror
                    </div>
                </div>
                <div class="card collapsed-card">
                    <div class="card-header">
                        <label for="linkreport" class="col-sm-2 col-form-label">Возрастные категории<span
                                class="text-danger">*</span></label>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="col-sm-10">
                            <ul>
                                @foreach($agecategories as $agecategory)
                                    <li>
                                        <input class="form-check-input" type="checkbox" name="agecategory[]"
                                               value="{{$agecategory->id}}"
                                               @foreach($competition->agecategories as $agecat) @if($agecat->id == $agecategory->id) checked @endif @endforeach>
                                        <label class="form-check-label">{{$agecategory->title}}</label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @error('date_end')<p class="text-danger">{{$errors->first('date_end')}}</p>@enderror
                    </div>
                    <div class="card-footer">
                        {{----}}
                    </div>
                </div>
                <div class="card collapsed-card">
                    <div class="card-header">
                        <label for="linkreport" class="col-sm-10 col-form-label">Группы по технической квалификации<span
                                class="text-danger">*</span></label>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="row">
                            @foreach($agecategories as $agecategory)
                                <div class="col-sm-4">
                                    <strong>{{$agecategory->title}}</strong>
                                    <ul>
                                        @foreach($tehkvalgroups as $tehkvalgroup)
                                            @if($agecategory->id == $tehkvalgroup->agecategory_id)
                                                <li>{{$tehkvalgroup->title}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                        @error('date_end')<p class="text-danger">{{$errors->first('date_end')}}</p>@enderror
                    </div>
                    <div class="card-footer">
                        <a href="{{route('competitions.tehkvalgroups.index',[$competition->id])}}" class="m-3">
                            <i class="fas fa-wrench"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Сохранить</button>
                <a href="/" type="submit" class="btn btn-default float-right">Отменить</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>
@endsection

