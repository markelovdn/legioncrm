<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
