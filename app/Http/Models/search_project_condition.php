<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class search_project_condition extends Model
{

  protected $table = 'search_project_condition';
  protected $guarded = ['user_engineer_id','category','code'];
  public $timestamps = false;

  public static function get ($user_engineer_id, $category = null)
  {
    $select = "*";

    $data = DB::table('search_project_condition')
            ->select(DB::raw($select))
            ->where('user_engineer_id', $user_engineer_id);

    if (is_string($category)) {
      $data = $data->where('category', $category);
    } elseif (is_array($category) && count($category) > 0) {
      $data = $data->whereIn('category', $category);
    }

    return $data->get();
  }

  public static function getCodeCategory ($user_engineer_id, $category = null)
  {
    $select = "code, category";

    $data = DB::table('search_project_condition')
            ->select(DB::raw($select))
            ->where('user_engineer_id', $user_engineer_id);

    if (is_string($category)) {
      $data = $data->where('category', $category);
    } elseif (is_array($category) && count($category) > 0) {
      $data = $data->whereIn('category', $category);
    }

    return $data->get();
  }

  public static function getCodeCategoryArray ($user_engineer_id, $category = null)
  {
    $select = "code, category";

    $data = DB::table('search_project_condition')
            ->select(DB::raw($select))
            ->where('user_engineer_id', $user_engineer_id);

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

  public static function del ($user_engineer_id)
  {
    \DB::table('search_project_condition')
            ->where('user_engineer_id', $user_engineer_id)->delete();
  }

  public static function ins ($data)
  {
    return \DB::table('search_project_condition')->insert($data);
  }
}

