<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_sns extends Model
{
  protected $table = 'worker_sns';
  protected $guarded = ['id'];
  public $timestamps = false;
  
  /*
   * 仮登録から移動
   */
  public static function insertFromPreSignUp($email)
  {
    $insert = 'INSERT INTO `worker_sns`(
      worker_id,
      sns_id,
      sns_account,
      follow_user_num,
      follower_user_num
    )
    SELECT
      w.worker_id,
      pws.sns_id,
      pws.sns_account,
      pws.follow_user_num,
      pws.follower_user_num
    FROM `pre_worker_sns` AS pws
    LEFT JOIN `worker` AS w
    ON w.email = pws.email
    WHERE w.email = ?
    ';
    
    DB::insert($insert, [$email]);
  }
  
  /*
   * worker_idから取得
   */
  public static function getByWorkerId($worker_id)
  {
    $select = '
        worker_id
        ,sns_id
        ,sns_account
        ,follow_user_num
        ,follower_user_num
    ';
    
    return DB::table('worker_sns')
      ->select(DB::RAW($select))
      ->where('worker_id', $worker_id)
      ->where('del_flag', 0)
      ->orderby('sns_id', 'ASC')
      ->orderby('update_date', 'DESC')
      ->get();
  }
  
  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('worker_sns')
      ->where('worker_id', $data['worker_id'])
      ->where('sns_id', $data['sns_id'])
      ->where('sns_account', $data['sns_account']);
    
    $record->exists() ? $record->update($data) : $record->insert($data);
  }
  
  public static function del($worker_id){
    \DB::table('worker_sns')
      ->where('worker_id', $worker_id)->delete();
  }
  
  public static function insert($sns)
  {
    $record = \DB::table('worker_sns')
      ->where('worker_id', $sns['worker_id'])
      ->where('sns_id', $sns['sns_id']);
    
    $record->insert($sns);
  }
}
