@extends('layouts.main')

@section('content')

<div class="card card-info">
    <div class="card-header">Ежегодные взносы</div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="container-fluid d-flex flex-column text-center">
            @foreach($payments as $payment)
            <form method="POST" action="{{route('payment.update', [$payment->id])}}">
                @method('PUT')
                @csrf
                <div class="row align-content-center">
                    <div class="col align-content-center">
                        <p>{{$payment->users->id}} {{$payment->users->secondname}} {{$payment->users->firstname}} {{$payment->users->patronymic}}</p>
                    </div>
                    <input type="text" style="display:none" name="user_id" value="{{$payment->users->id}}">
                    <div class="col align-content-center">
                        @if($payment->approve == \App\Models\Payment::DECLINED)
                        <span style="cursor: pointer" class="badge bg-warning" data-toggle="modal" data-target="#approved{{$payment->users->id}}">Ожидает проверки</span>
                        @else
                        <span style="cursor: pointer" class="badge bg-success" data-toggle="modal" data-target="#not_approved{{$payment->users->id}}">Оплачен</span>
                        @endif
                    </div>


                    {{--modal approve--}}
                    <div class="modal fade" id="approved{{$payment->users->id}}" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img class="img-fluid" src="{{$payment->scan_payment_document}}" alt="message user image">
                                </div>
                                <button type="submit" class="btn btn-success">Проверено<i class="fas fa-check"></i></button>
                            </div>
                        </div>

                    </div>
                    {{-- / modal approve--}}
                </div>
                <hr>
            </form>
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

            @endforeach
            {{$payments->links()}}
        </div>
    </div>
</div>


@endsection