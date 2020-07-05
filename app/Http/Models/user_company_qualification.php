<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class user_company_qualification extends Model
{
  
  public static function getQualificationByUserCompanyId($user_company_id)
  {
    // user_company_idに紐づく得意分野を取得
    $select = "
              u.user_company_id
              ,u.qualification_name
              ,u.certified_date
              ";
  
    $qualification = \DB::table('user_company_qualification AS u')
      ->select(\DB::raw($select))
      ->where('u.user_company_id', $user_company_id)
      ->get();
  
    return $qualification;
  }
  
  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('user_company_qualification')
//      ->where('id', $data['id'])
      ->where('qualification_name', $data['qualification_name'])
    ;
    
    $record->exists() ? $record->update($data) : $record->insert($data);
  }
  
  public static function del($user_company_id){
    \DB::table('user_company_qualification')
      ->where('user_company_id', $user_company_id)->delete();
  }
  
  public static function insert($qualification)
  {
    $record = \DB::table('user_company_qualification')
      ->where('user_company_id', $qualification['user_company_id'])
      ->where('qualification_name', $qualification['qualification_name']);
    
    $record->insert($qualification);
  }
}
