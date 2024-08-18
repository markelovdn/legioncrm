<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    use HasFactory;

    protected $fillable = [
        'series',
        'number',
        'dateissue',
        'issuedby',
        'code',
        'scanlink',
    ];

    public function athlete()
    {
        return $this->hasOne(Athlete::class);
    }

    public function parent()
    {
        return $this->hasOne(ParentAthlete::class);
    }
}
