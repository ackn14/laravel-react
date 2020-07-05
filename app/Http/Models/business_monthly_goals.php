<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class business_monthly_goals extends Model
{
  protected $table = 'business_monthly_goals';
  protected $guarded = [];
  public $timestamps = false;
  
  /**
   * データを取得
   * @param $user_company_id
   * @return mixed
   */
  public static function get($user_company_id)
  {
    $select = "
      user_company_id
      ,target_month
      ,sales
      ,matching
    ";
  
    return DB::table('business_monthly_goals')
      ->select(DB::raw($select))
      ->where('user_company_id', $user_company_id)
      ->get();
  }
  
  /**
   * 指定月のデータを取得
   * @param $user_company_id
   * @param $month
   * @return mixed
   */
  public static function getByMonth($month, $company_id, $user_company_id = null)
  {
    $select = "
      user_company_id
      ,target_month
    ";
    if($user_company_id){
      $select .= "
      ,sales
      ,matching
      ,profit";
    }else{
      $select .= "
      ,SUM(sales) AS sales
      ,SUM(matching) AS matching
      ,SUM(profit) AS profit";
    }
  
    $data = DB::table('business_monthly_goals')
      ->select(DB::raw($select))
      ->where('target_month', $month)
      ->where('company_id', $company_id);

    if($user_company_id){
      $data = $data
        ->where('user_company_id', $user_company_id);
    }
    return $data->get()->first();
  }

  public static function getMonthly($base_month, $diff_num, $company_id, $user_company_id = null){
    $select = 'target_month'
    ;
    if($user_company_id){
      $select .= "
      ,sales/10000 AS sales";
    }else{
      $select .= "
      ,SUM(sales)/10000 AS sales";
    }

    $data = DB::table('business_monthly_goals')
          ->select(DB::raw($select))
          ->where('company_id', $company_id)
          ->whereRaw("PERIOD_DIFF('".$base_month."', target_month) between 0 and ".($diff_num-1))
          ->groupby('target_month');

    if($user_company_id){
      $data = $data
        ->where('user_company_id', $user_company_id);
    }

    return $data->get()->toArray();
  }

  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = DB::table('business_monthly_goals')
      ->where('user_company_id', $data['user_company_id'])
      ->where('target_month', $data['target_month']);
    
    $record->exists() ? $record->update($data) : $record->insert($data);
  }
  
  public static function del($user_company_id){
    DB::table('business_monthly_goals')
      ->where('user_company_id', $user_company_id)->delete();
  }
  
//  public static function insert($goal)
//  {
//    $record = DB::table('business_monthly_goals')
//      ->where('user_company_id', $goal['user_company_id'])
//      ->where('target_month', $goal['target_month']);
//
//    $record->insert($goal);
//  }
}
