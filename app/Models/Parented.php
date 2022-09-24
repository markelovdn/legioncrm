<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Parented extends Model
{
    use HasFactory;

    public function athletes()
    {
        return $this->belongsToMany(Athlete::class)->with('birthcertificate', 'passport', 'studyplace');
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class);
    }

    public function snils()
    {
        return $this->belongsTo(Snils::class);
    }

    public function workplace()
    {
        return $this->belongsTo(WorkPlace::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getParentedId() {
        $parented = Parented::where('user_id', auth()->user()->id)->with('user')->first();

        return $parented->id;
    }
}
