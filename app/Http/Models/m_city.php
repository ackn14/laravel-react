<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_city extends Model
{

    protected $table = 'm_city';
    protected $guarded = ['city_id'];
    public $timestamps = false;

    public static function get($prefecture_id = null) {
        $select = "m_city.city_id
                 ,m_city.prefecture_id
                 ,m_city.city_name
                 ,m_city.display_order
                 ";

      $cities = DB::table('m_city')
            ->select(DB::raw($select));

      if($prefecture_id) {
        $cities = $cities->where('prefecture_id', $prefecture_id);
      }

      $cities = $cities->orderByRaw('m_city.display_order')
            ->get();

        return $cities;
    }

  /*
* 都道府県IDと市区町村IDにひもづく市区町村を取得
*/

  public static function getCity($prefecture_id,$city_id) {
    if ($prefecture_id && $city_id) {
      $city = DB::table('m_city')
              ->select('*')
              ->where('prefecture_id', intval($prefecture_id))
              ->where('city_id', intval($city_id))
              ->get();

      return $city;
    }
  }

  public static function getCityId($prefecture_id = null,$city_name = '') {
    if ($prefecture_id && $city_name) {
      $city = DB::table('m_city')
              ->select('*');
      
      if($prefecture_id) {
        $city = $city->where('prefecture_id', intval($prefecture_id));
      }
      
      $city = $city->where('city_name', $city_name)->get();

      if(count($city) <= 0){
        return null;
      }

      return $city[0]->city_id;
    }
  }

}
