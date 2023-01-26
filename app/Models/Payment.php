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

    public function isYearPayment(): bool
    {
        return $this->paymenttitle_id == \App\Models\Payment::ID_YEAR_PAYMENT;
    }

    public function isCurrentYearPayment(): bool
    {
        return Carbon::parse($this->date)->year == Carbon::parse(date('Y'))->year;
    }
}
