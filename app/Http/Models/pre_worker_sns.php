<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class pre_worker_sns extends Model
{
  protected $table = 'pre_worker_sns';
  protected $guarded = ['id'];
  public $timestamps = false;
  
  /*
   * アドレスから取得
   */
  public static function getByEmail($email)
  {
    return DB::table('pre_worker_sns')->where('email', $email)->get();
  }
  
  /*
   * 削除
   */
  public static function del($email)
  {
    DB::table('pre_worker_sns')
      ->where('email', $email)->delete();
  }
}
