<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_questionnaire extends Model
{
  protected $table = 'worker_questionnaire';
  protected $guarded = ['id'];
  public $timestamps = false;




  public static function getProfileScoreData($worker_id){
    $select = "
        wq.ans_capital
        ,wq.ans_experience
        ,wq.ans1
        ,wq.ans2
        ,wq.ans3
        ,MAX(wsns.follow_user_num) AS follow_user_num
        ,MAX(wsns.follower_user_num) AS follower_user_num
        ,GROUP_CONCAT(DISTINCT wskill.experience_id) AS experience_id
        ";

    $data = DB::table('worker AS w')
        ->select(DB::raw($select))
        ->leftjoin('worker_questionnaire AS wq', 'wq.worker_id', '=', 'w.worker_id')
        ->leftjoin('worker_sns AS wsns', function ($join) {
          $join->on('wsns.worker_id', '=', 'w.worker_id')
          ->where("wsns.del_flag", 0);
        })
        ->leftjoin('worker_skill AS wskill', function ($join) {
          $join->on('wskill.worker_id', '=', 'w.worker_id')
          ->where("wskill.del_flag", 0);
        })
        ->where("w.worker_id", $worker_id)
        ->get();

    return $data[0];
  }


  /*
   * 仮登録から移動
   */
  public static function insertFromPreSignUp($email)
  {
    $insert = '
      INSERT INTO `worker_questionnaire`(
        worker_id,
        ans_capital,
        ans_experience,
        ans1,
        ans2,
        ans3
      )
    SELECT
      w.worker_id,
      pwq.capital,
      pwq.working_experience,
      pwq.ans1,
      pwq.ans2,
      pwq.ans3
    FROM `pre_worker_questionnaire` AS pwq
    LEFT JOIN `worker` AS w
    ON w.email = pwq.email
    WHERE w.email = ?
    ON DUPLICATE KEY UPDATE
        worker_id = w.worker_id
    ';
    
    DB::insert($insert, [$email]);
  }
  
  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('worker_questionnaire')
      ->where('worker_id', $data['worker_id']);
    
    $record->exists() ? $record->update($data) : $record->insert($data);
  }
  
  public static function del($worker_id){
    \DB::table('worker_questionnaire')
      ->where('worker_id', $worker_id)->delete();
  }
  
  public static function insert($skill)
  {
    $record = \DB::table('worker_questionnaire')
      ->where('worker_id', $skill['worker_id']);
    
    $record->insert($skill);
  }
}
