@extends('layouts.main')
@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Новое мероприятие</h3>
        </div>

        <!-- /.card-header -->
        <!-- form start -->
        <form class="form-horizontal" method="POST" action="{{route('events.store')}}">
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
                    <label for="address" class="col-sm-2 col-form-label">Адрес места проведения<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">
                        @error('address')<p class="text-danger">{{$errors->first('address')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="users_limit" class="col-sm-2 col-form-label">Количество мест<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="users_limit" name="users_limit" value="{{old('users_limit')}}">
                        @error('users_limit')<p class="text-danger">{{$errors->first('users_limit')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="access" class="col-sm-2 col-form-label">Доступ на регистрацию<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="access" id="status" class="form-control">
                                <option value="{{\App\Models\Event::ACCESS_ALL}}">Доступно всем</option>
                                <option value="{{\App\Models\Event::ACCESS_ORGANIZATION_USER}}" selected>Доступно только в моей организации</option>
                        </select>
                        @error('access')<p class="text-danger">{{$errors->first('access')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="info_link" class="col-sm-2 col-form-label">Ссылка на подробную информацию<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="info_link" name="info_link" value="{{old('info_link')}}">
                        @error('info_link')<p class="text-danger">{{$errors->first('info_link')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="early_cost" class="col-sm-2 col-form-label">Предзаказ<span class="text-danger">*</span></label>
                    <label for="early_cost" class="col-sm-1 col-form-label">Цена:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="early_cost" name="early_cost" value="{{old('early_cost')}}">
                        @error('early_cost')<p class="text-danger">{{$errors->first('early_cost')}}</p>@enderror
                    </div>
                    <label for="early_cost_before" class="col-sm-1 col-form-label">До даты:<span class="text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="early_cost_before" name="early_cost_before" value="{{old('early_cost_before')}}">
                        @error('early_cost_before')<p class="text-danger">{{$errors->first('early_cost_before')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="regular_cost" class="col-sm-2 col-form-label">Обычная цена<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="regular_cost" name="regular_cost" value="{{old('regular_cost')}}">
                        @error('regular_cost')<p class="text-danger">{{$errors->first('regular_cost')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="minimum_prepayment_percent" class="col-sm-2 col-form-label">Минимальный процент предоплаты<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="minimum_prepayment_percent" name="minimum_prepayment_percent" value="{{old('minimum_prepayment_percent')}}">
                        @error('minimum_prepayment_percent')<p class="text-danger">{{$errors->first('minimum_prepayment_percent')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="booking_without_payment_before" class="col-sm-2 col-form-label">Бронирование без предоплаты до:<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="booking_without_payment_before" name="booking_without_payment_before" value="{{old('booking_without_payment_before')}}">
                        @error('booking_without_payment_before')<p class="text-danger">{{$errors->first('booking_without_payment_before')}}</p>@enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="payment_control" class="col-sm-2 col-form-label">Контроль оплаты<span class="text-danger">*</span></label>
                    <div class="col-sm-10">
                        <select name="payment_control" id="payment_control" class="form-control">
                            <option value="{{\App\Models\Event::PAYMENT_CONTROL_COACH}}">Тренер</option>
                            <option value="{{\App\Models\Event::PAYMENT_CONTROL_ORGANIZATION}}" selected>Организация</option>
                        </select>
                        @error('payment_control')<p class="text-danger">{{$errors->first('payment_control')}}</p>@enderror
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

