<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_timeline extends Model
{
  protected $table = 'worker_timeline';
  protected $guarded = ['id'];
  public $timestamps = false;


  /*
   * worker_idから取得
   */
  public static function get($worker_id)
  {
    $select = '
         worker_timeline.worker_id
        ,worker_timeline.user_company_id
        ,worker_timeline.message
        ,CASE
          WHEN DATEDIFF(NOW(), worker_timeline.create_date) < 1 THEN "24時間以内"
          WHEN DATEDIFF(NOW(), worker_timeline.create_date) between 1 AND 7 THEN CONCAT(FORMAT(DATEDIFF(NOW(), worker_timeline.create_date),0),"日前")
          WHEN DATEDIFF(NOW(), worker_timeline.create_date) between 8 AND 30 THEN CONCAT(TRUNCATE(DATEDIFF(NOW(), worker_timeline.create_date)/7,0),"週間前")
          WHEN DATEDIFF(NOW(), worker_timeline.create_date) between 31 AND 360 THEN CONCAT(TRUNCATE(DATEDIFF(NOW(), worker_timeline.create_date)/30,0),"ヶ月前")
          WHEN DATEDIFF(NOW(), worker_timeline.create_date) > 360 THEN CONCAT(TRUNCATE(DATEDIFF(NOW(), worker_timeline.create_date)/360,0),"年前")
        ELSE 0 END AS post_date
        ,concat(user_company.last_name,user_company.first_name) as name
        ,user_company.logo_image        
    ';

    return DB::table('worker_timeline')
      ->select(DB::RAW($select))
      ->join('user_company','user_company.user_company_id','=','worker_timeline.user_company_id')
      ->where('worker_timeline.worker_id', $worker_id)
      ->where('worker_timeline.del_flag', 0)
      ->orderby('worker_timeline.update_date', 'DESC')
      ->get();
  }

  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('worker_timeline')
      ->where('worker_id', $data['worker_id'])
      ->where('sns_id', $data['sns_id'])
      ->where('sns_account', $data['sns_account']);

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public static function del($worker_id){
    \DB::table('worker_timeline')
      ->where('worker_id', $worker_id)->delete();
  }

  public static function insert($data)
  {
    $record = \DB::table('worker_timeline')
      ->where('worker_id', $data['worker_id']);

    $record->insert($data);
  }
}
