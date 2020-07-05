<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;

class user_engineer extends Model implements AuthenticatableContract, CanResetPasswordContract
{

  use Authenticatable,
          CanResetPassword;

  protected $table = 'user_engineer';
  protected $primaryKey = 'user_engineer_id';
  public $timestamps = false;
  protected $fillable = [
          'email', 'password',
  ];

  /*
   * ユーザー登録
   */
  public static function insertUser($data)
  {
      // userテーブルに人材情報を登録
        DB::table('user_engineer')->insert([
            // 'initial_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            // 'line_id' => $data['line_id'],
            'google_id' => $data['google_id'],
            'facebook_id' => $data['facebook_id'],
            'authenticated_flag' => $data['authenticated_flag'],
        ]);

    return DB::getPdo()->lastInsertId();
  }

  /*
   * ユーザ情報を更新する
   */
  public static function updateUserEngineer($user_engineer_id, $data, $updateList)
  {

      $record = array();

      foreach ($data as $key => $value) {
          if (in_array($key, $updateList)) {
              $record[$key] = $value;
          }
      }

      // 更新する対象がなければ処理を終了する
      if (empty($record)) {
          return;
      }

      $data = DB::table('user_engineer')
          ->where('user_engineer_id', $user_engineer_id)
          ->update($record);
  }

  /*
   * user_engineer_idからユーザ情報とプロフィール情報を取得
   */
  public static function getUserEngineerById($user_engineer_id)
  {

      $select = '
         u.user_engineer_id
        ,u.email
        ,u.registration_phase
        ,w.phone_number
        ,w.logo_image
        ,w.worker_id
        ,w.worker_type
        ,w.initial_name
        ,w.last_name
        ,w.first_name
        ,w.last_name_ruby
        ,w.first_name_ruby
        ,w.nearest_station
        ,w.operation_date
        ,w.age
        ,w.sex
        ,CASE
           WHEN w.sex = 0 THEN \'非公開\'
           WHEN w.sex = 1 THEN \'男性\'
           WHEN w.sex = 2 THEN \'女性\'
           ELSE \'非公開\'
         END AS sex_str  
      ';

      $data = DB::table('user_engineer AS u')
          ->select(DB::RAW($select))
          ->leftjoin('worker AS w', 'w.user_engineer_id', "=", "u.user_engineer_id")
          ->where('u.user_engineer_id', $user_engineer_id)
          ->where('u.del_flag', '0')
          ->get();

      return $data[0];
  }

  /*
   * ユーザ情報とプロフィール情報の一覧を取得
   */
  public static function getUserEngineer4minColumn ()
  {
      $select = '
         u.user_engineer_id
        ,u.email
        ,w.worker_id
        ,w.last_name
        ,w.first_name
        ,w.last_name_ruby
        ,w.first_name_ruby
      ';

      $data = DB::table('user_engineer AS u')
          ->select(DB::RAW($select))
          ->leftjoin('worker AS w', 'w.user_engineer_id', "=", "u.user_engineer_id")
          ->where('u.mail_receiving_flag', 1)
          ->where('u.del_flag', 0)
          ->where('w.del_flag', 0)
          ->get();

      return $data;
  }

  /*
   * トークン存在(重複)チェック
   */
  public static function checkDuplicationToken($token)
  {
      $user = DB::table('user_engineer')
          ->select('token')
          ->where('token', $token)
          ->get();

      return $user;
  }
 /*
 * ワンタイムトークン存在(重複)チェック
 */
  public static function checkDuplicationOneTimeToken($token)
  {
    $user = DB::table('user_engineer')
            ->select('one_time_token')
            ->where('one_time_token', $token)
            ->get();

    return $user;
  }
  /*
   * メールアドレスに紐付くトークンがあるかチェック
   */
  public static function checkOneTimeToken($email, $one_time_token)
  {
      $user_engineer = DB::table('user_engineer')
          ->select('user_engineer_id')
          ->where('email', $email)
          ->where('one_time_token', $one_time_token)
          ->where('del_flag', 0)
          ->get();

      if (count($user_engineer) == 0)
          return false;

      return $user_engineer[0];
  }

  /*
   * ユーザIDに紐付くトークンがあるかチェック
   */
  public static function checkToken($id, $token)
  {
    return DB::table('user_engineer')
            ->select('user_engineer_id')
            ->where('user_engineer_id', $id)
            ->where('token', $token)
            ->where('del_flag', 0)
            ->exists();

  }

  /*
   * ワンタイムトークンを設定
   */
  public static function setOneTimeToken($user_engineer_id, $one_time_token)
  {
      DB::table('user_engineer')
          ->where('user_engineer_id', $user_engineer_id)
          ->update(['one_time_token' => $one_time_token]);
  }

  /*
   * トークンを設定
   */
  public static function setToken($user_engineer_id, $token)
  {
      DB::table('user_engineer')
          ->where('user_engineer_id', $user_engineer_id)
          ->update(['token' => $token]);
  }
  
  /*
   * 最終ログイン日時を更新
   */
  public static function setLastLoginDate($user_engineer_id)
  {
      DB::table('user_engineer')
          ->where('user_engineer_id', $user_engineer_id)
          ->update(['last_login_date' => DB::raw('CURRENT_TIMESTAMP')]);
  }

  /*
   * パスワードを再設定
   */
  public static function updatePassword($user_engineer_id, $password)
  {
      DB::table('user_engineer')
          ->where('user_engineer_id', $user_engineer_id)
          ->update(['password' => $password, 'one_time_token' => null]);
  }

  public static function getUserByEmail($email) {
    $select = '
    u.user_engineer_id
    ,u.email
    ,u.token
    ,w.initial_name
    ,w.last_name
    ,w.first_name
    ,w.last_name_ruby
    ,w.first_name_ruby
    ,w.logo_image
    ,w.worker_id
    ';
    $data = DB::table('user_engineer AS u')
        ->select(DB::RAW($select))
        ->leftjoin('worker AS w', 'w.user_engineer_id', "=", "u.user_engineer_id")
        ->where('u.email', $email)
        ->where('u.del_flag', '0')
        ->first();
    return $data;
  }
}
