<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public static function checkTehkvalGroup($competition_id, $agecategory_id, $startgyp_id, $finishgyp_id, $id = null)
    {
        if($startgyp_id >= $finishgyp_id) {
            session()->flash('error', 'Не верный диапазон');
            return false;
        }

        $tehKvalGroups = TehkvalGroup::
        whereRaw('competition_id = '.$competition_id.
                ' and agecategory_id = '.$agecategory_id.
                ' and finishgyp_id >= '.$startgyp_id
                )
                ->first();

        if ($tehKvalGroups) {
            session()->flash('error', 'Выбранный диапазон технических квалификаций уже используется');
            return false;
        } else {
            session()->flash('status', 'Диапазон технических квалификаций добавлен');
            return true;
        }
    }

    public static function getNameTehKvalGroup($startgyp_id, $finishgyp_id)
    {
        $startgyp_title = Tehkval::where('id', $startgyp_id)->first();
        $finishgyp_title = Tehkval::where('id', $finishgyp_id)->first();

        if ($startgyp_title->id == 1 and $finishgyp_title->id < 12) {
            return ' (до '.Str::beforeLast($finishgyp_title->title, ' гып'). ' гыпа)';
        } elseif ($startgyp_title->id == 1 and $finishgyp_title->id >= 12) {
            return ' (до '.Str::beforeLast($finishgyp_title->title, ' пум'). ' пум/дана)';
        } else {
            return ' (от '.Str::beforeLast($startgyp_title->title, ' гып').
                ' до '.Str::beforeLast($finishgyp_title->title, ' гып'). ' гыпа)';
        }
    }

}
