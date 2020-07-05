<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class zoom_meeting extends Model
{
  //
  protected $fillable = [
    'title',
    'description',
    'meeting_url',
    'join_url',
    'create_user_id',
  ];
  public function create_user(){
    return $this->belongsTo('App\User', 'create_user_id');
  }

  /*
   * 面談情報取得
   * 現状として先日以前の面談情報は取得しない
   */
  public static function get($data){
    $select = "
                 room_id
                ,zoom_meeting_id
                ,user_company_id
                ,worker_id
                ,title
                ,description
                ,meeting_url
                ,interview_date
                ,join_url
                ,event_id
                 ";
    $room = DB::table('zoom_meeting')
      ->select(DB::raw($select))
      ->where('worker_id', $data['worker_id'])
      ->where('interview_date', '>=', date('Y-m-d'))
      ->orderBy('update_date','desc')
      ->limit(1)
      ->get();

    if(count($room) < 1){
      return false;
    }

    return $room[0];
  }

  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('zoom_meeting')
      ->where('zoom_meeting_id', $data['zoom_meeting_id'])
    ;

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public static function insert($data)
  {
    $record = \DB::table('zoom_meeting');
    $record->insert($data);
  }

  public static function up($data){
    DB::table('zoom_meeting')
      ->where('zoom_meeting_id', $data['zoom_meeting_id'])
      ->lockForUpdate()
      ->update($data);
  }

}
