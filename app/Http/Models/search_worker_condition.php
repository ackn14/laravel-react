<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class search_worker_condition extends Model
{

  protected $table = 'search_worker_condition';
  protected $guarded = ['user_company_id','category','code'];
  public $timestamps = false;
  const CONDITION_CATEGORY = ['job', 'desired_job', 'prefecture', 'skill', 'monthly_income', 'contract_type'];


  public static function get($user_company_id){
    $select = "*
                 ";

    $data = DB::table('search_worker_condition')
            ->select(DB::raw($select))
            ->where('user_company_id', $user_company_id)
            ->get();

    return $data;
  }


  public static function getCodeCategoryArray ($user_company_id)
  {
    $select = "code, category";

    $data = DB::table('search_worker_condition')
            ->select(DB::raw($select))
            ->where('user_company_id', $user_company_id);


    $category = self::CONDITION_CATEGORY;

    if (is_string($category)) {
      $data = $data->where('category', $category);
    } elseif (is_array($category) && count($category) > 0) {
      $data = $data->whereIn('category', $category);
    }

    $data = $data->get();
    $spcList = \App\Logic\GeneralLogic::collection2ArrayConversion($data);

    // category毎に抽出
    $conditionCategoryList = array();
    foreach ($spcList as $index => $data) {
      if (!isset($conditionCategoryList[$data['category']])) {
        $conditionCategoryList[$data['category']] = array();
      }
      $conditionCategoryList[$data['category']][] = $data['code'];
    }

    return $conditionCategoryList;
  }


  public static function del($user_company_id){

    \DB::table('search_worker_condition')
            ->where('user_company_id', $user_company_id)->delete();
  }

  public static function ins($data){
    return \DB::table('search_worker_condition')->insert($data);
  }

}

