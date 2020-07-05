<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_prefecture extends Model
{

  protected $table = 'm_prefecture';
  protected $guarded = ['prefecture_id'];
  public $timestamps = false;

  public static function get()
  {
    $select = "m_prefecture.prefecture_id
                 ,m_prefecture.region_id
                 ,m_prefecture.prefecture_name
                 ,m_prefecture.display_order
                 ";

    $prefectures = DB::table('m_prefecture')
            ->select(DB::raw($select))
            ->orderByRaw('m_prefecture.display_order')
            ->get();

    return $prefectures;
  }

  /*
   * 都道府県IDにひもづく都道府県を取得
   */

  public static function getPrefecture($prefecture_id)
  {
    if (isNonEmptyString($prefecture_id)) {
      $prefecture = DB::table('m_prefecture')
              ->select('*')
              ->where('prefecture_id', intval($prefecture_id))
              ->get();

      return $prefecture;
    }
  }


  /*
   * 都道府県IDにひもづく都道府県を未選択をのぞいて取得
   */
  public static function getFromOne()
  {
    $select = "m_prefecture.prefecture_id
                 ,m_prefecture.region_id
                 ,m_prefecture.prefecture_name
                 ,m_prefecture.display_order
                 ";

    $prefectures = DB::table('m_prefecture')
            ->select(DB::raw($select))
            ->where('prefecture_id', '!=', '00')
            ->orderByRaw('m_prefecture.display_order')
            ->get();

    return $prefectures;
  }

  public static function getFromOneArrayData()
  {
    $data = self::getFromOne();

    $arr = array();
    foreach($data as $val){
      $arr[$val->prefecture_id] = $val->prefecture_name;
    }

    return $arr;
  }

  public static function get4searchSelectList()
  {
    $select = "m_prefecture.prefecture_id
                 ,m_prefecture.prefecture_name
                 ";

    $prefectures = DB::table('m_prefecture')
            ->select(DB::raw($select))
            ->where('prefecture_id', '!=', '00')
            ->orderByRaw('m_prefecture.display_order')
            ->get();

    return $prefectures;
  }

  public static function getPrefectureId($prefecture_name){
    if (isNonEmptyString($prefecture_name)) {
      $prefecture = DB::table('m_prefecture')
              ->select('*')
              ->where('prefecture_name', $prefecture_name)
              ->get();

      if(count($prefecture) <= 0){
        return null;
      }
    }

      return $prefecture[0]->prefecture_id;
  }
}
