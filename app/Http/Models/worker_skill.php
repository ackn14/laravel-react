<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_skill extends Model
{

  protected $table = 'worker_skill';
  protected $guarded = ['id'];
  public $timestamps = false;
  
  /*
   * スキル取得
   */
  public static function getSkillByWorkerId($worker_id)
  {
      // worker_idに紐づくスキルセットを取得
      $select = " w.worker_id
                 ,w.skill_id
                 ,(CASE
                    WHEN w.experience_id IS NULL THEN ''
                    ELSE w.experience_id
                  END) AS experience_id
                 ,m_code.display_name as experience_display_name
                 ,skill.skill_name
                 ";

      $skill = DB::table('worker_skill AS w')
          ->select(DB::raw($select))
          ->leftjoin('m_skill AS skill', 'skill.skill_id', "=", "w.skill_id")
          ->leftjoin('m_code', function ($join) {
            $join->on('m_code.code', '=', 'w.experience_id')
            ->where('category', '=', 'ex_skill');
          })
          ->where('worker_id', $worker_id)
          ->get();

      return $skill;
  }

  public static function getProfileScoreData($worker_id) {
    // worker_idに紐づくスキルセットを取得
    $select = "
        ws.skill_id
        ,(CASE
          WHEN ws.experience_id IS NULL THEN ''
          ELSE ws.experience_id
        END) AS experience_id
        ,msw.skill_weight
        ,GROUP_CONCAT(DISTINCT msc.skill_class_id) AS skill_class_id
    ";

    $data = DB::table('worker_skill AS ws')
        ->select(DB::raw($select))
        ->leftjoin('m_skill_class AS msc', 'msc.skill_id', '=', 'ws.skill_id')
        ->leftjoin('m_skill_weight AS msw', 'msw.skill_id', '=', 'ws.skill_id')
        ->where('worker_id', $worker_id)
        ->groupby('ws.skill_id')
        ->get();

    return $data;
  }

  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('worker_skill')
            ->where('worker_id', $data['worker_id'])
            ->where('skill_id', $data['skill_id']);

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public static function del($worker_id){
    \DB::table('worker_skill')
            ->where('worker_id', $worker_id)->delete();
  }

  public static function insert($skill)
  {
    $record = \DB::table('worker_skill')
            ->where('worker_id', $skill['worker_id'])
            ->where('skill_id', $skill['skill_id']);

    $record->insert($skill);
  }

  /*
   * 仮登録から移動
   */
  public static function insertFromPreSignUp($email)
  {
    $insert = '
      INSERT INTO `worker_skill`(
        worker_id,
        skill_id,
        experience_id
      )
      SELECT
        w.worker_id,
        pws.skill_id,
        pws.experience_id
      FROM `pre_worker_skill` AS pws
      LEFT JOIN `worker` AS w
      ON w.email = pws.email
      WHERE w.email = ?
      ON DUPLICATE KEY UPDATE
        skill_id = pws.skill_id,
        worker_id = w.worker_id
    ';
    
    DB::insert($insert, [$email]);
  }

}

