<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TehkvalGroup extends Model
{
    use HasFactory;

    protected $table = 'tehkvals_groups';

    public function competitor()
    {
        return $this->hasOne(Competitor::class);
    }

    public function agecategory()
    {
        return $this->belongsTo(AgeCategory::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

}
