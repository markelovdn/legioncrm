<?php

namespace App\BusinessProcess;

use App\Models\Payment;

class GetPaymentInfo
{
    public function getPaymentInfo(int $user_id)
    {
        $payment = Payment::where('user_id', $user_id)->get();

        if (!$payment->isEmpty())
        {
            return $payment;
        } else {
            return false;
        }
    }
}
