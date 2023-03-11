@extends('layouts.main')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="card collapsed-card">
            <div class="card-header">
                <h1 class="card-title">{{$event->title}} {{ \Carbon\Carbon::parse($event->date_start)->format('d.m.Y')}}</h1>
                <div class="card-tools">
                    <span class="badge badge-success">{{$users_main_list}}</span>/<span class="badge badge-warning">{{$users_waiting_list}}</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                @if(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_ORGANIZATION_ADMIN || \App\Models\User::getRoleCode() == \App\Models\Role::ROLE_SYSTEM_ADMIN)
                <p><strong>по 6500: </strong>{{$payments->where('sum', 6500)->sum('sum')}}/{{$payments->where('sum', 6500)->sum('sum')/6500}}</p>
                <p><strong>по 6475: </strong>{{$payments->where('sum', 6475)->sum('sum')}}/{{$payments->where('sum', 6475)->sum('sum')/6475}}</p>
                <p><strong>по 12000: </strong>{{$payments->where('sum', 12000)->sum('sum')}}/{{$payments->where('sum', 12000)->sum('sum')/12000}}</p>
                <p><strong>по 18500: </strong>{{$payments->where('sum', 18500)->sum('sum')}}/{{$payments->where('sum', 18500)->sum('sum')/18500}}</p>
                <hr>
                <p><strong>ИТОГО: </strong>{{$payments->sum('sum')}}</p>

                @if (isset($coachAthleteCount))
                    @foreach($coachAthleteCount as $coach => $athlete)
                        <p><strong>{{$coach}}</strong> - {{$athlete}} человек</p>
                    @endforeach
                    @endif
                @endif
                    <p>Фильтр</p>
                    <hr>
                    <div class="p-3 control-sidebar-content">
                        <form method="GET" action="{{url()->current()}}">
                            <h6>Тренер</h6>
                            <div class="d-flex">
                                <select class="custom-select mb-3 text-light border-0 bg-white" name="coach_id">
                                        <option>Все</option>
                                    @if(isset($coaches) && \App\Models\User::getRoleCode() != \App\Models\Role::ROLE_COACH)
                                    @foreach($coaches as $coach)
                                            <option value="{{$coach->id}}">{{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0, 1)}}.{{mb_substr($coach->user->patronymic, 0, 1)}}.</option>
                                    @endforeach
                                    @elseif(\App\Models\User::getRoleCode() == \App\Models\Role::ROLE_COACH)
                                        <option value="{{$coach->id}}">
                                            {{$coach->user->secondname}} {{mb_substr($coach->user->firstname, 0, 1)}}.{{mb_substr($coach->user->patronymic, 0, 1)}}.
                                        </option>
                                        @endif

                                </select>
                            </div>
                            {{--TODO: падает тест competition_index--}}
                            <div class="d-flex">
                                <button type="submit" class="btn btn-info">Выбрать</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>

    </div>
    <!-- /.content-header -->
    <section class="content">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @foreach ($users as $user)
                <?php $payment = \App\Models\Payment::getUserEventPayment($user->id, $event->id)?>
            <div class="card card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">{{$user->secondname}} {{$user->firstname}} {{$user->patronymic}}</h3><br>
                    @if($user->pivot->list == \App\Models\Event::MAIN_LIST)
                        <span class="badge badge-success">основной список</span>
                    @else
                    <span class="badge badge-warning"><i class="far fa-clock"></i> очередь</span>
                    @endif

                    @if($payment)
                        @if($payment->approve == \App\Models\Payment::PAYMENT_AWAIT_APPROVE || $payment->approve == 0)
                            @if(\App\Models\Event::getOwner($event->id))
                            <span class="badge badge-warning"
                                  data-toggle="modal" data-target="#approved{{$user->id}}">Ожидается подтверждение платежа</span>
                                {{--modal approve--}}
                                <form method="POST" action="{{route('payment.update', [$payment->id])}}">
                                    @method('PUT')
                                    @csrf
                                        <div class="modal fade" id="approved{{$user->id}}" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="text" style="display: none" class="form-control" id="approve" name="approve"
                                                               value="@if($payment->sum == $event_cost) full_payment @else {{\App\Models\Payment::PREPAYMENT}} @endif">
                                                        <img class="img-fluid" src="{{$payment->scan_payment_document}}" alt="message user image">
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Проверено<i class="fas fa-check"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                                {{-- / modal approve--}}
                            @else
                                <span class="badge badge-warning">Ожидается подтверждение платежа</span>
                        @endif

                        @elseif ($payment->approve == \App\Models\Payment::APPROVED)
                            @if(\App\Models\Event::getOwner($event->id))
                                <span class="badge badge-success"
                                      data-toggle="modal" data-target="#not_approved{{$user->id}}">Оплачено полностью</span>
                                {{--modal not_approve--}}
                                <div class="modal fade" id="not_approved{{$payment->users->id}}" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{route('payment.destroy', [$payment->id])}}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Отменить проверку<i class="fas fa-check"></i></button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                {{-- / modal not_approve--}}

                            @else
                                <span class="badge badge-success">Оплачено полностью</span>
                            @endif

                        @elseif($payment->approve == \App\Models\Payment::PREPAYMENT)
                            <span class="badge badge-primary"
                                  data-toggle="modal" data-target="#modal-payment_event{{$user->id}}">Оплатить полностью до: {{Carbon\Carbon::parse($event->last_date_payment)->format('d.m.Y')}} загрузить чек</span>
                        @endif
                    @elseif($user->pivot->list == \App\Models\Event::MAIN_LIST)
                        <span class="badge badge-danger"
                              data-toggle="modal" data-target="#modal-payment_event{{$user->id}}">Необходимо оплатить до: {{Carbon\Carbon::parse($user->pivot->created_at)->addRealDays($event->booking_without_payment_before)->format('d.m.Y')}} загрузить чек</span>
                    @endif

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <b>Дата рождения: </b> {{ \Carbon\Carbon::parse($user->date_of_birth)->format('d.m.Y')}}<br>
                </div>
                @if(\App\Models\Event::getOwner($event->id))
                <div class="card-footer">
                    <div class="row row-cols-2">
                        <div class="col text-left">
                            {{-- \одобрить участие--}}
                        </div>
                        <div class="col text-right">
                            <form method="POST" action="{{route('userEventDestroy', ['event_id', $event->id, 'user_id', $user->id])}}">
                                @method('DELETE')
                                @csrf
                                <input type="number" style="display: none" class="form-control" id="event_id" name="event_id" value="{{$event->id}}">
                                <input type="number" style="display: none" class="form-control" id="user_id" name="user_id" value="{{$user->id}}">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>

                {{--modal--}}
                <div class="modal fade" id="modal-payment_event{{$user->id}}" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{$event->title}}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @if(!$payment)
                                <form method="POST" action="{{route('payment.store', [$user->id])}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <input type="text" style="display: none" name="user_id" value="{{$user->id}}">
                                        <input type="text" style="display: none" name="event_id" value="{{$event->id}}">
                                        <input type="text" style="display: none" name="paymenttitle_id" value="{{$paymenttitle_id}}">
                                        <input type="text" style="display: none" name="date_payment" value="{{\Carbon\Carbon::now()}}">
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
                                                           name="scan_payment_document" id="scan_payment_document" value="file">
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
                                @endif

                                @if($payment &&
                                    $payment->approve == \App\Models\Payment::PREPAYMENT)
                                    <form method="POST" action="{{route('payment.update', [$payment->id])}}" enctype="multipart/form-data">
                                    @csrf
                                        @method('PUT')
                                    <div class="row mb-3">
                                        <input type="text" style="display: none" name="user_id" value="{{$user->id}}">
                                        <input type="text" style="display: none" name="event_id" value="{{$event->id}}">
                                        <input type="text" style="display: none" name="paymenttitle_id" value="{{$paymenttitle_id}}">
                                        <input type="text" style="display: none" name="approve" value="{{\App\Models\Payment::APPROVED}}">
                                    </div>
                                    <div class="row mb-3">
                                        <label for="sum_payment" class="col-md-4 col-form-label text-md-end">Сумма платежа<span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-6">
                                            <input id="sum_payment" type="number"
                                                   class="form-control @error('sum_payment') is-invalid @enderror" name="sum_payment"
                                                   value="{{$event_cost - $payment->sum}}">
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
                                                           name="scan_payment_document" id="scan_payment_document" value="file">
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
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
        @endforeach
    </section>

@endsection

