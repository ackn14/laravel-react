<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class reset_email extends Model
{
    protected $table = 'reset_email';
    protected $guarded = [];
    public $timestamps = false;

    /*
     * データ取得
     */
    public static function get($data)
    {
        $record = DB::table('reset_email')
        ->where('email', $data['email'])
        ->where('one_time_token', $data['one_time_token'])
        ->where('user_type', $data['user_type'])
        ->whereRaw('create_date > (CURRENT_TIMESTAMP + INTERVAL - 15 MINUTE)');

        if ($record->count()) {
            return $record->get()[0];
        }
      
        return false;
    }

    /*
     * 既存データを消して再登録
     */
    public static function delInsert($data)
    {
        ($data['email'] == 'email'){
        DB::table('reset_email')
          ->select('email')
          ->where('email', $data['email'])
          ->where('user_type', $data['user_type'])
          ->delete()
        };
        DB::table('reset_email')
          ->insert($data);
        return DB::getPdo()->lastInsertId();
    }

    /*
    * ワンタイムトークン存在(重複)チェック
    */
    public static function checkDuplicationOneTimeToken($token)
    {
        $record = DB::table('reset_email')
            ->select('one_time_token')
            ->where('one_time_token', $token)
            ->get();

        return $record;
    }


    /*
     * 削除
     */
    public static function del($data)
    {
        DB::table('reset_email')
          ->where('email', $data['email'])
          ->where('one_time_token', $data['one_time_token'])
          ->where('user_type', $data['user_type'])
          ->delete();
    }

    /*
     * 削除
     */
    public static function delOldData()
    {
      DB::table('reset_email')
        ->whereRaw('create_date < (CURRENT_TIMESTAMP + INTERVAL - 15 MINUTE)')
        ->delete();
    }
}
