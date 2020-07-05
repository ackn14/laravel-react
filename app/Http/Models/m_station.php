<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_station extends Model
{
  protected $table = 'm_station';
  protected $guarded = [];
  public $timestamps = false;
  
  public static function getLinesByAreaId($search)
  {
    $select = "m.line_id
              ,m.line_name
                 ";
  
    $lines = DB::table('m_station as m')
      ->select(DB::raw($select))
      ->groupby('m.line_id');
    
    if(isset($search['prefecture_id']) && $search['prefecture_id']) {
      $lines->where('m.prefecture_id', '=', $search['prefecture_id']);
    }
    
    if(isset($search['city_id']) && $search['city_id']) {
      $lines->where('m.city_id', '=', $search['city_id']);
    }
  
    $lines = $lines->get();
    
    return $lines;
  }
  
  public static function getLinesByCityId($city_id)
  {
    $select = "m.line_id
              ,m.line_name
                 ";
  
    $lines = DB::table('m_station as m')
      ->select(DB::raw($select))
      ->where('m.city_id', '=', $city_id)
      ->groupby('m.line_id')
      ->get();
  
    return $lines;
  }
  
  public static function getByLineId($line_id)
  {
    $select = "m.*
                 ";
  
    $stations = DB::table('m_station as m')
      ->select(DB::raw($select))
      ->where('m.line_id', '=', $line_id)
      ->get();
  
    return $stations;
  }
}
