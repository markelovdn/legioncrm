<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeCategory extends Model
{
    use HasFactory;

    public function competitor()
    {
        return $this->hasOne(Competitor::class);
    }

    public function tehkvalgroup()
    {
        return $this->hasMany(TehkvalGroup::class, 'agecategory_id');
    }

    public function competitions()
    {
        return $this->belongsToMany(Competition::class,
            'competition_agecategory',
            'competition_id',
            'agecategory_id');
    }
}
