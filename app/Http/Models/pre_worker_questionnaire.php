<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class pre_worker_questionnaire extends Model
{
  protected $table = 'pre_worker_questionnaire';
  protected $guarded = ['id'];
  public $timestamps = false;
  
  /*
   * アドレスから取得
   */
  public static function getByEmail($email)
  {
    return DB::table('worker_questionnaire')->where('email', $email)->first();
  }
  
  /*
   * 削除
   */
  public static function del($email)
  {
    DB::table('pre_worker_questionnaire')
      ->where('email', $email)->delete();
  }
}
