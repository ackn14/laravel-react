<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_region extends Model
{

  protected $table = 'm_region';
  protected $guarded = ['region_id'];
  public $timestamps = false;

  public static function get()
  {
    $select = "
                  m_region.region_id
                 ,m_region.region_name 
                 ,m_prefecture.prefecture_id
                 ,m_prefecture.prefecture_name
                 ";

    $prefectures = DB::table('m_region')
            ->select(DB::raw($select))
            ->leftjoin('m_prefecture', 'm_prefecture.region_id', "=", "m_region.region_id")
            ->where('m_region.region_id', '!=', "0")
            ->orderByRaw('m_region.display_order asc, m_prefecture.prefecture_id asc')
            ->get();

    return $prefectures;
  }


}
