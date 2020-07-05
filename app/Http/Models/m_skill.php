<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_skill extends Model
{

  protected $table = 'm_skill';
  protected $guarded = ['skill_id'];
  public $timestamps = false;

  /*
   * スキルマスタのデータ取得
   */
  public static function get()
  {
    $select = "m_skill.skill_id
                 ,m_skill.skill_category_id
                 ,m_skill.skill_name
                 ,m_skill.display_order
                 ";

    $skills = DB::table('m_skill')
            ->select(DB::raw($select))
            ->orderByRaw('m_skill.display_order')
            ->get();

    return $skills;
  }

  public static function getArrayData(){
    $skills = self::get();
    $arrSkills = array();
    foreach($skills as $val){
        $arrSkills[$val->skill_id] = $val->skill_name;
    }

    return $arrSkills;
  }

  public static function getIdName()
  {
    $select = "m_skill.skill_id
                 ,m_skill.skill_name
                 ";

    $skills = DB::table('m_skill')
            ->select(DB::raw($select))
            ->orderByRaw('m_skill.display_order')
            ->get();

    return $skills;
  }
  
  public static function getSkillName($skill_id)
  {
    $select = "m_skill.skill_name
                 ";

    $skill = DB::table('m_skill')
            ->select(DB::raw($select))
            ->orderByRaw('m_skill.display_order')
            ->where('skill_id', $skill_id)
            ->get();

    if (count($skill) == 0) {
      return;
    }

    return $skill[0]->skill_name;
  }

  public static function getSkillNames($skill_ids)
  {
    $select = "m_skill.skill_name
                 ";

    $skills = DB::table('m_skill')
            ->select(DB::raw($select))
            ->orderByRaw('m_skill.display_order')
            ->whereIn('skill_id', $skill_ids)
            ->get();


    return $skills;
  }

  public static function getSkillId($skill_name)
  {
    $select = "
                 m_skill.skill_id
                 ";

    $skill_id = DB::table('m_skill')
            ->select(DB::raw($select))
            ->where('skill_name', $skill_name)
            ->get();

    if (count($skill_id) == 0) {
      return "";
    }

    return $skill_id[0]->skill_id;

  }
}
