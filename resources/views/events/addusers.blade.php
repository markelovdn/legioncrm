@extends('layouts.main')
@section('content')
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Добавить участников {{$event->title}} {{ \Carbon\Carbon::parse($event->date)->format('d.m.Y')}}</h3>
		</div>
		<!-- /.card-header -->
		<!-- form start -->
    </div>
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif
{{--    TODO:сделать всплывающие окна--}}
    @foreach($eventUsers as $user)
        @csrf
        <div class="container-fluid d-flex flex-column text-center">
            <div class="row mt-1 mb-1">
                    <div class="col-5">{{$user->user->secondname}} {{$user->user->firstname}} {{$user->user->patronymic}}</div>
                    <div class="col-4"><button
                            id="submit" type="submit" class="btn btn-info"
                            data-toggle="modal" data-target="#modal-payment_event{{$user->user->id}}">Добавить</button>
                    </div>
            </div>
        </div>

    {{--modal photo--}}
        <div class="modal fade" id="modal-payment_event{{$user->user->id}}" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{$event->title}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($bookingWithoutPay && $free_place > 0)
                        <form method="POST" action="{{route('events.users.store', [$event->id])}}">
                            @csrf
                            <div class="row mb-3">
                                <input type="text" style="display: none" name="user_id" value="{{$user->user->id}}">
                                <input type="text" style="display: none" name="event_id" value="{{$event->id}}">
                            </div>
                                <div class="row mb-0">
                                    <button id="submit" type="submit" class="btn btn-default">
                                        Оплатить позже
                                    </button>
                                </div>
                        </form>
                        @endif

                        @if($free_place > 0)
                           <form method="POST" action="{{route('events.users.store', [$event->id])}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <input type="text" style="display: none" name="user_id" value="{{$user->user->id}}">
                                        <input type="text" style="display: none" name="event_id" value="{{$event->id}}">
                                        <input type="text" style="display: none" name="paymenttitle_id" value="{{$payment->id}}">
                                    </div>
                                    <div class="row mb-3">
                                        <label for="sum_payment" class="col-md-4 col-form-label text-md-end">Сумма платежа<span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <input id="sum_payment" type="number"
                                                   class="form-control @error('sum_payment') is-invalid @enderror" name="sum_payment"
                                                   value="{{ old('sum_payment') }}">
                                            <span class="description font-italic">Минимальная предоплата {{$event_cost * ($event->minimum_prepayment_percent / 100)}} р.</span><br>
                                            <span class="description font-italic">Полная стоимость {{$event_cost}} р.</span>
                                            <br>
                                            <a href="{{$event->info_link}}" class="btn btn-danger">Скачать реквизиты для оплаты</a>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="scan_payment_document" class="col-md-4 col-form-label text-md-end">Чек об оплате<span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file"
                                                           class="custom-file-input @error('scan_payment_document') is-invalid @enderror"
                                                           name="scan_payment_document" id="scan_payment_document">
                                                    <label class="custom-file-label" for="scan_payment_document"></label>
                                                </div>
                                            </div>
                                            <span class="description font-italic">Принимаются файлы только изображений (jpg,jpeg,png,bmp) размер файла должен быть менее 1 мб</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="row mb-0">
                                            <button id="submit" type="submit" class="btn btn-primary">
                                                Отправить чек
                                            </button>
                                        </div>
                                    </div>
                                </form>
                        @else
                            <form method="POST" action="{{route('events.users.store', [$event->id])}}">
                                @csrf
                                <div class="row mb-3">
                                    <input type="text" style="display: none" name="user_id" value="{{$user->user->id}}">
                                    <input type="text" style="display: none" name="event_id" value="{{$event->id}}">
                                </div>
                                <div class="row mb-0">
                                    <button id="submit" type="submit" class="btn btn-primary">
                                        Подтвердить
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- /.card-footer -->
@endsection

