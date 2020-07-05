<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;

class line_tmporary_registration extends Model implements AuthenticatableContract, CanResetPasswordContract
{

  use Authenticatable,
          CanResetPassword;

  protected $table = 'line_tmporary_registration';
  protected $primaryKey = 'idd';
  public $timestamps = false;
  protected $fillable = [
  ];

  /*
 * ユーザー登録
 */
  public static function insertUserId($data)
  {
    // userテーブルに人材情報を登録
    DB::table('line_tmporary_registration')->insert([
            'line_id' => $data['line_id'],
            'regist_id' => $data['regist_id'],
    ]);
    return DB::getPdo()->lastInsertId();
  }

  public static function del($line_id){
    \DB::table('line_tmporary_registration')
            ->where('line_id', $line_id)->delete();
  }


  /*
   * データの存在確認
   */
  public static function checkExist($id, $regist_id){
    $user = DB::table('line_tmporary_registration')
            ->select('line_id')
            ->where('id', $id)
            ->where('regist_id', $regist_id)
            ->get();

    if (count($user) == 0)
      return false;

    return $user[0];
  }

}
