<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalPolicy extends Model
{
    use HasFactory;

    public function athlete()
    {
        return $this->hasOne(Athlete::class);
    }
}
