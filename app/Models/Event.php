<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public const OPEN_REGISTRATION = 1;
    public const CLOSE_REGISTRATION = 2;
}
