<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const DECLINED = 0;
    public const APPROVED = 1;
    public const PREPAYMENT = 2;
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
}
