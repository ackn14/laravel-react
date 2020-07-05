<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class user_company_specialty extends Model
{
  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('user_company_specialty')
      ->where('user_company_id', $data['user_company_id'])
      ->where('specialty_id', $data['specialty_id']);
    
    $record->exists() ? $record->update($data) : $record->insert($data);
  }
  
  public static function del($user_company_id){
    \DB::table('user_company_specialty')
      ->where('user_company_id', $user_company_id)->delete();
  }
  
  public static function insert($specialty)
  {
    $record = \DB::table('user_company_specialty')
      ->where('user_company_id', $specialty['user_company_id'])
      ->where('specialty_id', $specialty['specialty_id']);
    
    $record->insert($specialty);
  }
  
  public static function getSpecialtyByUserCompanyId($user_company_id) {
    // user_company_idに紐づく得意分野を取得
    $select = "
              u.user_company_id
              ,u.specialty_id
              ,job.job_id
              ,job.job_name
              ";
    
    $specialty = \DB::table('user_company_specialty AS u')
      ->select(\DB::raw($select))
      ->leftjoin('m_job AS job', 'job.job_id', "=", "u.specialty_id")
      ->where('u.user_company_id', $user_company_id)
      ->get();
    
    return $specialty;
  }
}
