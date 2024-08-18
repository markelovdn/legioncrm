<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    public const DECLINED = 0;
    public const APPROVED = 1;
    public const PREPAYMENT = 2;
    public const PAYMENT_AWAIT_APPROVE = 3;
    public const TYPE_YEAR_PAYMENT = 'year_payment';
    public const ID_YEAR_PAYMENT = 1;

    public function title()
    {
        return $this->hasOne(PaymentsTitle::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isCurrentYearPayment($user_id): bool
    {
        $payments = Payment::where('user_id', $user_id)->where('paymenttitle_id', self::ID_YEAR_PAYMENT)->get();

        $result = false;
        foreach ($payments as $payment) {
            if (Carbon::parse($payment->date)->year == Carbon::parse(date('Y'))->year) {
                $result = true;
            }
        }
        return $result;
    }

    public function isCurrentYearPaymentApproved($user_id): bool
    {
        $payments = Payment::where('user_id', $user_id)->where('paymenttitle_id', self::ID_YEAR_PAYMENT)->get();

        $result = false;
        foreach ($payments as $payment) {
            if (Carbon::parse($payment->date)->year == Carbon::parse(date('Y'))->year && $payment->approve == Payment::APPROVED) {
                $result = true;
            }
        }
        return $result;
    }

    public function getUserEventPayment($user_id, $event_id)
    {
        $event_user_payment_id = DB::table('event_user')->where('user_id', $user_id)
            ->where('event_id', $event_id)->first('payment_id');
        $payment = Payment::where('id', $event_user_payment_id->payment_id)->first();
        if ($payment) {
            return $payment;
        } else {
            return false;
        }
//        $payment = Payment::where('id', $event_user_payment_id->payment_id)->first();
//
//        if ($payment && $payment->approve == Payment::PAYMENT_AWAIT_APPROVE) {
//            return Payment::PAYMENT_AWAIT_APPROVE;
//        }
//
//        if ($payment && $payment->approve == Payment::APPROVED) {
//            return Payment::APPROVED;
//        }
//
//        if ($payment && $payment->approve == Payment::PREPAYMENT) {
//            return Payment::PREPAYMENT;
//        }
//
//        return false;
    }

}
