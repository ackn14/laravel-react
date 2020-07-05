<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class message_detail extends Model
{
  static $project_count = null;
  static $project_disp_count = null;
  protected $table = 'message_room';
  protected $guarded = ['room_id'];
  public $timestamps = false;


  /*
   * メッセージ全て取得
   */

  public static function getMessages($room_id) {
    $select = "md.message_id
            ,md.room_id
            ,md.sender_id
            ,md.sender_type
            ,md.message
            ,md.read_flag
            ,md.create_date
            ,md.original_file_name
            ,DATE_FORMAT(md.create_date, \"%m/%d %H:%i\") AS sendDateTime
            ";

    $data = DB::table('message_detail as md')
            ->select(DB::raw($select))
            ->where('md.del_flag', 0)
            ->where('md.room_id', $room_id)
            ->orderby('md.create_date', 'asc')
            ->get();

    return $data;
  }

  /*
   * メッセージ登録
   */
  public static function insertMessage($data) {

    DB::table('message_detail')->insert([
            'room_id' => $data['room_id'],
            'sender_id' => $data['sender_id'],
            'sender_type' => $data['sender_type'],
            'message' => $data['message'],
            'file_name' => $data['file_name'],
            'original_file_name' => $data['original_file_name']
    ]);

    return DB::getPdo()->lastInsertId();
  }

  /*
 * メッセージ表示につき既読フラグアップデート
 */

  public static function updateReadFlg($room_id, $sender_type) {

    DB::table('message_detail')
            ->where('room_id', $room_id)
            ->where('sender_type', '!=', $sender_type)
            ->update(['read_flag' => 1]);
  }

  public static function getFileInfo($room_id,$message_id){

    $file = DB::table('message_detail')
            ->select('original_file_name','file_name')
            ->where('room_id', $room_id)
            ->where('message_id', '=', $message_id)
            ->where('del_flag', '=', 0)
            ->get();

    if(count($file) > 0){
      return $file[0];
    }
    return false;
  }

  public static function getNewMessageFlag($sender_id,$sender_type,$user_engineer_id){
    $record = DB::table('message_detail');

    if($sender_type == 1){
      //企業側の新着取得
      $record = $record->join('message_room','message_room.room_id', '=', 'message_detail.room_id')
                       ->where('message_room.company_id', '=', $sender_id)
                       ->where('sender_id', '!=', $user_engineer_id)
      ;
    }else{
      //エンジニア
      $record = $record->join('message_room','message_room.room_id', '=', 'message_detail.room_id')
              ->where('message_room.worker_id','=', $sender_id)
              ->where('sender_id', '!=', $sender_type)
      ;
    }


    $record = $record
            ->where('sender_type', '!=', $sender_type)
            ->where('read_flag', '=', 0)
            ->where('message_room.del_flag', '=', 0)
            ->where('message_detail.del_flag', '=', 0)

    ;

    if($record->exists()){
      return true;
    }
    return false;
  }
}
