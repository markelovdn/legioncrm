@extends('layouts.main')
@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Новое мероприятие</h3>
        </div>
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
        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" method="POST" action="{{route('events.update', [$event->id])}}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Название<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{$event->title}}">
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
                    <label for="date_start" class="col-sm-2 col-form-label">Дата начала<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_start" name="date_start" value="{{$event->date_start}}">
                        @error('date_start')<p class="text-danger">{{$errors->first('date_start')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-2 col-form-label">Дата окончания<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="date_end" name="date_end" value="{{$event->date_end}}">
                        @error('date_end')<p class="text-danger">{{$errors->first('date_end')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-2 col-form-label">Адрес места проведения<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address" value="{{$event->address}}">
                        @error('address')<p class="text-danger">{{$errors->first('address')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="info_link" class="col-sm-2 col-form-label">Ссылка на подробную информацию<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="info_link" name="info_link" value="{{$event->info_link}}">
                        @error('info_link')<p class="text-danger">{{$errors->first('info_link')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="open" class="col-sm-2 col-form-label">Закрыть регистрацию<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="checkbox" class="form-control" id="close" name="open" @if($event->open == \App\Models\Event::CLOSE_REGISTRATION) checked @endif value="{{\App\Models\Event::CLOSE_REGISTRATION}}">
                        @error('open')<p class="text-danger">{{$errors->first('open')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="deleted_at" class="col-sm-2 col-form-label">В архив<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="checkbox" class="form-control" id="deleted_at" name="deleted_at" @if($event->deleted_at) checked @endif value="{{\Carbon\Carbon::now()}}">
                        @error('deleted_at')<p class="text-danger">{{$errors->first('deleted_at')}}</p>@enderror
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-info">Изменить</button>
                <a href="/" type="submit" class="btn btn-default float-right">Отменить</a>
            </div>
            <!-- /.card-footer -->
        </form>
    </div>

@endsection

