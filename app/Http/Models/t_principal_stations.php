<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class t_principal_stations extends Model
{
  
  public static function get()
  {
    $select = '
      ,s.*
    ';
    
    $station = \DB::table('t_principal_stations AS ps')
      ->select(DB::RAW($select))
      ->leftjoin('m_station AS s', 's.station_id', '=', 'ps.station_id')
      ->get();
    
    return $station;
  }
}
