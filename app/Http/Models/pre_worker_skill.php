<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pre_worker_skill extends Model
{
  protected $table = 'pre_worker_skill';
  protected $guarded = ['id'];
  public $timestamps = false;
  
  /*
   * 削除
   */
  public static function del($email)
  {
    \DB::table('pre_worker_skill')
      ->where('email', $email)->delete();
  }
}
