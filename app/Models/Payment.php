<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const APPROVE_FALSE = 0;
    public const APPROVE_TRUE = 1;
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
}
