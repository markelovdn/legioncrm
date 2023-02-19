@extends('layouts.main')
@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Новая аттестация</h3>
        </div>

        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" method="POST" action="{{route('attestations.store')}}">
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
                    <label for="date_start" class="col-sm-2 col-form-label">Дата проведения<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_start" name="date" value="{{old('date')}}">
                        @error('date')<p class="text-danger">{{$errors->first('date')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Адрес места проведения<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">
                        @error('address')<p class="text-danger">{{$errors->first('address')}}</p>@enderror
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

