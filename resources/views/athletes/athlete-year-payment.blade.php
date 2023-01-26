<div class="card collapsed-card">
    <div class="card-header">
        <h3 class="card-title">Ежегодный взнос</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <div class="card-body" style="display: none;">
            @foreach(\App\BusinessProcess\GetPaymentInfo::getPaymentInfo($athlete->user_id) as $payment)
{{--                TODO:Делать запросы из вьюх это плохо--}}
                @if(!$payment->isCurrentYearPayment()
                    || !$payment->isYearPayment())
                    @include('finance.forms.form-year-payment')
                @elseif ($payment->sum > 0
                     && !$payment->approve)
                    <span class="badge bg-warning">
                        Взнос за {{Carbon\Carbon::parse(date('Y'))->year}} ожидает проверки
                    </span>
                @else
                    <span class="badge bg-success">
                       Взнос за {{Carbon\Carbon::parse(date('Y'))->year}} оплачен
                   </span>
                @endif
            @endforeach
    </div>
</div>
