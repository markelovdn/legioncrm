@extends('layouts.main')
@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">{{$competition->name}}</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" method="POST" action="/storecompetition?competition_id={{$competition->id}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{$competition->name}}">
                        @error('name')<p class="text-danger">{{$errors->first('name')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="place" class="col-sm-2 col-form-label">Место проведения<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="place" name="place" value="{{$competition->place}}">
                        @error('place')<p class="text-danger">{{$errors->first('place')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_start" class="col-sm-2 col-form-label">Дата начала<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_start" name="date_start" value="{{$competition->date_start}}">
                        @error('date_start')<p class="text-danger">{{$errors->first('date_start')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Дата окончания<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_end" name="date_end" value="{{$competition->date_end}}">
                        @error('date_end')<p class="text-danger">{{$errors->first('date_end')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Возрастные категории<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            @foreach($agecategories as $agecategory)
                                <input class="form-check-input" type="checkbox" name="agecategory[]" value="{{$agecategory->id}}"
                                @foreach($competition->agecategories as $agecat) @if($agecat->id == $agecategory->id) checked @endif @endforeach>
                                <label class="form-check-label">{{$agecategory->name}}</label><br>
                            @endforeach
                        </div>
                        @error('date_end')<p class="text-danger">{{$errors->first('date_end')}}</p>@enderror
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

