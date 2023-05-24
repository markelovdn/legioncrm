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
        <?php $GetPaymentInfo = new \App\BusinessProcess\GetPaymentInfo();?>
        @if(!$GetPaymentInfo->getPaymentInfo($athlete->user->id))
            @if(\Illuminate\Support\Facades\Auth::user()->getRoleCode() != \App\Models\Role::ROLE_COACH)
            @include('finance.forms.form-year-payment')
                @endif
        @else
            @foreach($GetPaymentInfo->getPaymentInfo($athlete->user->id) as $payment)
                @if(!$payment->isCurrentYearPayment($athlete->user->id))
                    @if(\Illuminate\Support\Facades\Auth::user()->getRoleCode() != \App\Models\Role::ROLE_COACH)
                    @include('finance.forms.form-year-payment')
                        @endif
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
        @endif
    </div>
</div>
