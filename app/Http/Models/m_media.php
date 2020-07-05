<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_media extends Model
{
  protected $table = 'm_media';
  protected $guarded = [];
  public $timestamps = false;
  
  public static function confirmExistenceOfMediaId($media_id)
  {
    $select = "m.media_id
                 ";

    $media = DB::table('m_media as m')
      ->select(DB::raw($select))
      ->where('m.media_id', $media_id)
    ;

    $media = $media->exists();
    
    return $media;
  }

}
