<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class pre_signup_company extends Model implements AuthenticatableContract
{
  use Authenticatable;
  
  protected $table = 'pre_signup_company';
  protected $primaryKey = ['email', 'one_time_token'];
  public $timestamps = false;
  protected $fillable = [
    'email',
  ];
  
  /*
 * ユーザー仮登録
 */
  public static function preInsertUser($data)
  {
    // userテーブルに人材情報を登録
    ($data['email'] == 'email'){
    DB::table('pre_signup_company')
      ->select('email')
      ->where('email', $data['email'])
      ->delete()
    };
    DB::table('pre_signup_company')
      ->insert($data);
    return DB::getPdo()->lastInsertId();
  }
  
  /*
 * トークン存在(重複)チェック
 */
  public static function checkDuplicationToken($one_time_token)
  {
    $one_time_token = DB::table('pre_signup_company')
      ->select('one_time_token')
      ->get();
    
    return $one_time_token;
  }
  
  public static function getOneTimeToken($email)
  {
    
    
    $data = DB::table('pre_signup_company')
      ->select('one_time_token')
      ->where('email', $email)
      ->get();
    
    return $data[0];
  }
  
  /*
  * ワンタイムトークンを設定
  */
  public static function setOneTimeToken($email, $one_time_token)
  {
    DB::table('pre_signup_company')
      ->where('email', $email)
      ->update(['one_time_token' => $one_time_token]);
    
  }
  
  /*
   * メールアドレスからユーザ情報を取得
   */
  public static function getEmail($email)
  {
    $data = DB::table('pre_signup_company')
      ->select('email', $email)
      ->get();
    
    return $data[0];
  }
  
  /*
  * メールアドレスに紐付くトークンがあるかチェック
  */
  public static function checkOneTimeToken($email, $one_time_token)
  {
    $user_company = DB::table('pre_signup_company')
      ->where('email', $email)
      ->where('one_time_token', $one_time_token)
      ->get();
    
    if (count($user_company) == 0)
      return false;
    
    return $user_company[0];
  }
  
  /*
   * 削除
   */
  public static function del($email)
  {
    DB::table('pre_signup_company')
      ->where('email', $email)
      ->delete();
  }
}
