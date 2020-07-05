<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class skill_name_identification extends Model
{

  protected $table = 'm_skill';
  protected $guarded = ['skill_id'];
  public $timestamps = false;

  /*
   * スキルマスタのデータ取得
   */
  public static function searchSkillId($skill_name)
  {
    $select = "skill_id
              ";

    $skill = DB::table('skill_name_identification')
            ->select(DB::raw($select))
            ->where('skill_name', 'like', $skill_name . '%')
            ->get();

    if(count($skill) == 0){
      return false;
    }

    return $skill[0]->skill_id;
  }

}
