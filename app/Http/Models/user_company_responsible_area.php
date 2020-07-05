<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_company_responsible_area extends Model
{
  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('user_company_responsible_area')
      ->where('user_company_id', $data['user_company_id'])
      ->where('prefecture_id', $data['prefecture_id']);
    
    $record->exists() ? $record->update($data) : $record->insert($data);
  }
  
  public static function del($user_company_id){
    \DB::table('user_company_responsible_area')
      ->where('user_company_id', $user_company_id)->delete();
  }
  
  public static function insert($responsible_area)
  {
    $record = \DB::table('user_company_responsible_area')
      ->where('user_company_id', $responsible_area['user_company_id'])
      ->where('prefecture_id', $responsible_area['prefecture_id']);
    
    $record->insert($responsible_area);
  }
  
  public static function getAreaByUserCompanyId($user_company_id) {
    // user_company_idに紐づく県を取得
    $select = "
              u.user_company_id
              ,u.prefecture_id
              ,prefecture.prefecture_name
              ";
  
    $area = \DB::table('user_company_responsible_area AS u')
      ->select(\DB::raw($select))
      ->leftjoin('m_prefecture AS prefecture', 'prefecture.prefecture_id', "=", "u.prefecture_id")
      ->where('u.user_company_id', $user_company_id)
      ->get();
  
    return $area;
  }
}
