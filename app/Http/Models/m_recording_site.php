<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_recording_site extends Model
{

  protected $table = 'm_recording_site';
  protected $guarded = ['recording_site_id'];
  public $timestamps = false;

  public static function get()
  {
    $select = "m_recording_site.recording_site_id
                 ,m_recording_site.recording_site_name
                 ,m_recording_site.url
                 ,m_recording_site.display_order
                 ";

    $jobs = DB::table('m_recording_site')
            ->select(DB::raw($select))
            ->orderByRaw('m_recording_site.display_order')
            ->get();

    return $jobs;
  }
}
