<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_another_feature extends Model
{

  protected $table = 'm_another_feature';
  protected $guarded = ['another_feature_id'];
  public $timestamps = false;

  public static function get()
  {
    $select = "m_another_feature.another_feature_id
                 ,m_another_feature.another_feature_name
                 ,m_another_feature.display_order
                 ";

    $anotherFeatures = DB::table('m_another_feature')
      ->select(DB::raw($select))
      ->orderByRaw('m_another_feature.display_order')
      ->get();

    return $anotherFeatures;
  }

  public static function getArrayData()
  {
    $data = self::get();
    $arr = array();
    foreach ($data as $val) {
      $arr[$val->another_feature_id] = $val->another_feature_name;
    }

    return $arr;
  }

  public static function getFeatureNames($feature_ids)
  {
    $select = "m_another_feature.another_feature_name
                 ";

    $anotherFeatures = DB::table('m_another_feature')
      ->select(DB::raw($select))
      ->whereIn("another_feature_id", $feature_ids)
      ->get();

    return $anotherFeatures;
  }
}
