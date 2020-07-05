<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class message_room extends Model
{
  static $project_count = null;
  static $project_disp_count = null;
  protected $table = 'message_room';
  protected $guarded = ['room_id'];
  public $timestamps = false;
  protected static $partner_worker_select = '
      ,w.worker_id
      ,w.initial_name AS worker_name
      ,w.logo_image AS worker_logo_image
      ,3.0 AS worker_review_rating
      ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS worker_skill
  ';
  protected static $partner_user_company_select = '
      ,uc.user_company_id
      ,uc.last_name AS user_company_last_name
      ,uc.first_name AS user_company_first_name
      ,uc.logo_image AS user_company_logo_image
      ,3.0 AS user_company_review_rating
      ,c.company_id
      ,c.company_name
  ';
  protected static $list_select = '
      ,mr.room_id
      ,mr.company_id
      ,mr.worker_id
      ,mr.user_company_id
      ,COUNT(DISTINCT mdcount.message_id) AS unread_count
      ,mdnew.message AS new_message
      ,mdnew.original_file_name AS new_original_file_name
      ,mdnew.create_date AS new_create_date
  ';
  protected static $list_worker_select = '
      ,w.initial_name AS room_name
      ,w.logo_image AS room_logo_image
  ';
  protected static $list_user_company_select = '
      ,CONCAT(uc.last_name, uc.first_name) AS room_name
      ,uc.logo_image AS room_logo_image
  ';


  /*
   * メッセージルーム取得
   */
  public static function getListForWorker($worker_id){

    // 未読メッセージ数取得用
    $subdata = DB::table('message_detail')
            ->select(DB::RAW('MAX(message_id)'))
            ->where('del_flag', 0)
            ->groupby('room_id');

    $data = DB::table('message_room AS mr')
            ->select(DB::RAW('0 AS room_type'.self::$list_select.self::$list_user_company_select))
            ->join('company as c', function ($join) {
              $join->on('c.company_id', '=', 'mr.company_id')
                      ->where('c.del_flag', 0);
            })
            ->join('user_company AS uc', function ($join) {
              $join->on('uc.user_company_id', '=', 'mr.user_company_id')
                      ->where('uc.del_flag', 0);
            })
            ->leftjoin('message_detail AS mdcount', function ($join) {
              $join->on('mdcount.room_id', '=', 'mr.room_id')
                      ->where('mdcount.sender_type', 1)
                      ->where('mdcount.read_flag', 0)
                      ->where('mdcount.del_flag', 0);
            })
            ->join('message_detail AS mdnew', function ($join) use ($subdata) {
              $join->on("mdnew.room_id", "=", "mr.room_id")
                      ->whereIn('mdnew.message_id', $subdata);
            })
            ->where('mr.worker_id', $worker_id)
            ->where('mr.del_flag', 0)
            ->groupby('mr.room_id')
            ->orderby('mdnew.create_date','desc');

    return $data->get();
  }

  public static function getListForCompany($user_company_id,$company_id){

    // 未読メッセージ数取得用
    $subdata = DB::table('message_detail')
            ->select(DB::RAW('MAX(message_id)'))
            ->where('del_flag', 0)
            ->groupby('room_id');

    $worker_data = DB::table('message_room AS mr')
            ->select(DB::RAW('CASE WHEN w.user_engineer_id IS NOT NULL THEN 1 ELSE 3 END AS room_type'.self::$list_select.self::$list_worker_select))
            ->leftjoin('message_detail AS mdcount', function ($join) {
              $join->on('mdcount.room_id', '=', 'mr.room_id')
                      ->where('mdcount.sender_type', 0)
                      ->where('mdcount.read_flag', 0)
                      ->where('mdcount.del_flag', 0);
            })
            ->join('message_detail AS mdnew', function ($join) use ($subdata) {
              $join->on("mdnew.room_id", "=", "mr.room_id")
                      ->whereIn('mdnew.message_id', $subdata);
            })
            ->join('worker AS w', function ($join) {
              $join->on('w.worker_id', '=', 'mr.worker_id')
                      ->where('w.del_flag', 0);
            })
            ->where('mr.user_company_id', $user_company_id)
            ->where('mr.del_flag', 0)
            ->groupby('mr.room_id');

    $user_company_data = DB::table('message_room AS mr')
            ->select(DB::RAW('2 AS room_type'.self::$list_select.self::$list_user_company_select))
            ->leftjoin('message_detail AS mdcount', function ($join) {
              $join->on('mdcount.room_id', '=', 'mr.room_id')
                      ->where('mdcount.sender_type', 1)
                      ->where('mdcount.read_flag', 0)
                      ->where('mdcount.del_flag', 0);
            })
            ->join('message_detail AS mdnew', function ($join) use ($subdata) {
              $join->on("mdnew.room_id", "=", "mr.room_id")
                      ->whereIn('mdnew.message_id', $subdata);
            })
            ->join('user_company AS uc', function ($join) {
              $join->on('uc.user_company_id', '=', 'mr.user_company_id')
                      ->where('uc.del_flag', 0);
            })
            ->join('company as c', function ($join) {
              $join->on('c.company_id', '=', 'mr.company_id')
                      ->where('c.del_flag', 0);
            })
            ->join('worker AS w', function ($join) {
              $join->on("w.worker_id", "=", "mr.worker_id")
                      ->whereNull('w.user_engineer_id')
                      ->where("w.del_flag", 0);
            })
            ->where('w.worker_manager_id', $user_company_id)
            ->where('mr.del_flag', 0)
            ->groupby('mr.room_id');

    $union_data = $worker_data
    ->union($user_company_data)
    ->orderby('new_create_date','desc')
    ->get();

    return $union_data;
  }

  /*
   * メッセージパートナー情報取得
   */
  public static function getPartnerDataFromWorkerToCompany($room_id){

    $data = DB::table('message_room AS mr')
          ->select(DB::RAW('mr.room_id, 0 AS room_type'.self::$partner_user_company_select))
          ->leftjoin('user_company AS uc', 'uc.user_company_id', 'mr.user_company_id')
          ->leftjoin('company AS c', 'c.company_id', 'uc.company_id')
          ->where('mr.room_id', $room_id)
          ->where('mr.del_flag', 0)
          ->where('c.del_flag', 0)
          ->where('uc.del_flag', 0)->get();

    if($data){
      return $data[0];
    }else{
      return false;
    }
  }

  public static function getPartnerDataFromCompanyToWorker($room_id){

    $data = DB::table('message_room AS mr')
          ->select(DB::RAW('mr.room_id, 1 AS room_type'.self::$partner_worker_select))
          ->leftjoin('worker AS w', 'w.worker_id', 'mr.worker_id')
          ->leftjoin('worker_skill AS ws', "ws.worker_id", "=", "w.worker_id")
          ->leftjoin('m_skill AS m_skill', "ws.skill_id", "=", "m_skill.skill_id")
          ->where('mr.room_id', $room_id)
          ->where('mr.del_flag', 0)
          ->where('w.del_flag', 0)->get();

    if($data){
      return $data[0];
    }else{
      return false;
    }
  }

  public static function getPartnerDataFromCompanyWorkerToCompany($room_id){

    $data = DB::table('message_room AS mr')
          ->select(DB::RAW('mr.room_id, 2 AS room_type'.self::$partner_user_company_select.self::$partner_worker_select))
          ->leftjoin('user_company AS uc', 'uc.user_company_id', 'mr.user_company_id')
          ->leftjoin('company AS c', 'c.company_id', 'uc.company_id')
          ->leftjoin('worker AS w', 'w.worker_id', 'mr.worker_id')
          ->leftjoin('worker_skill AS ws', "ws.worker_id", "=", "w.worker_id")
          ->leftjoin('m_skill AS m_skill', "ws.skill_id", "=", "m_skill.skill_id")
          ->where('mr.room_id', $room_id)
          ->where('mr.del_flag', 0)
          ->where('c.del_flag', 0)
          ->where('uc.del_flag', 0)
          ->where('w.del_flag', 0)->get();

    if($data){
      return $data[0];
    }else{
      return false;
    }
  }

  public static function getPartnerDataFromCompanyToCompanyWorker($room_id){

    $data = DB::table('message_room AS mr')
          ->select(DB::RAW('mr.room_id, 3 AS room_type'.self::$partner_user_company_select.self::$partner_worker_select))
          ->leftjoin('worker AS w', 'w.worker_id', 'mr.worker_id')
          ->leftjoin('worker_skill AS ws', "ws.worker_id", "=", "w.worker_id")
          ->leftjoin('m_skill AS m_skill', "ws.skill_id", "=", "m_skill.skill_id")
          ->leftjoin('user_company AS uc', 'uc.user_company_id', 'w.worker_manager_id')
          ->leftjoin('company AS c', 'c.company_id', 'uc.company_id')
          ->where('mr.room_id', $room_id)
          ->where('mr.del_flag', 0)
          ->where('c.del_flag', 0)
          ->where('uc.del_flag', 0)
          ->where('w.del_flag', 0)->get();

    if($data){
      return $data[0];
    }else{
      return false;
    }
  }

  /*
   * 新規登録
   */
  public static function insert($data){
    return \DB::table('message_room')->insertGetId($data);
  }

  /*
   * 更新
   */
  public static function up($data)
  {

    try {
      \DB::table('message_room')->where("room_id", $data['room_id'])
              ->update($data);
    } catch (\Exception $e) {
      throw $e;
    }

    return true;

  }

  /*
   * データが無ければインサート
   */
  public static function checkAndInsert($data)
  {
    $record = \DB::table('message_room')->select("room_id")
            ->where('company_id', $data['company_id'])
            ->where('worker_id', $data['worker_id'])
            ->where('user_company_id', $data['user_company_id']);


    if ($record->exists()) {
      $data['room_id'] = $record->get()[0]->room_id;
      return $data['room_id'];
    } else {
      return $record->insertGetId($data);
      //return $record->project_id;

    }
  }

  public static function checkExist($room_id, $id, $user_type)
  {
    $data = DB::table('message_room AS r')
            ->select(DB::RAW("*"))
            ->where('r.room_id', $room_id)
            ->where('r.del_flag', 0);
    if ($user_type == config('const.USER_TYPE')['COMPANY']) {
      $data = $data->join('user_company as uc', 'uc.company_id', "=", "r.company_id")
              ->where('uc.user_company_id', $id);
    } elseif ($user_type == config('const.USER_TYPE')['WORKER']) {
      $data = $data->join('worker as w', 'w.worker_id', "=", 'r.worker_id')
                   ->where('w.user_engineer_id', $id);
    } else {
      return false;
    }

    if ($data->exists()) {
      return true;
    } else {
      return false;
    }
  }

  public static function getRoomInfo($room_id)
  {
    $data = DB::table('message_room AS r')
            ->select(DB::RAW('*'))
            ->where('r.room_id', $room_id)
            ->where('r.del_flag', 0);

    if ($data->exists()) {
      $data = $data->get();
      return $data[0];
    } else {
      return false;
    }
  }

  /*
   * ルームのworkerのuser_engineer_idを取得
   * エイトが登録した人材の場合はnullとなる
   */
  public static function getUserEngineerId($room_id)
  {
    $data = DB::table('message_room AS r')
            ->select(DB::RAW('w.user_engineer_id'))
            ->join('worker as w', 'w.worker_id', "=", 'r.worker_id')
            ->where('r.room_id', $room_id)
            ->where('r.del_flag', 0);

    if ($data->exists()) {
      $data = $data->get();
      return $data[0]->user_engineer_id;
    } else {
      return false;
    }
  }

  public static function newMessages($company_id, $user_company_id)
  {
    $data = DB::table('message_room')
            ->select(DB::RAW('
               count(`message_id`) as message_number
              ,DATE_FORMAT(message_detail.create_date,\'%Y-%m-%d\') as date
            '))
            ->join('message_detail', 'message_room.room_id', "=", 'message_detail.room_id')
            ->whereRaw('user_company_id = ' . $user_company_id . ' or (user_company_id is null and company_id = ' . $company_id . ')')
            ->where('message_detail.read_flag', 0)
            ->where('message_detail.del_flag', 0)
            ->groupBy('message_detail.create_date')
            ->orderByRaw(' DATE_FORMAT(message_detail.create_date,\'%Y-%m-%d\')');

    return $data->get();

  }
  
  public static function getRecentlyExchangedWorkerList($user_company_id, $limit = null)
  {
    $select = '
      w.worker_id
      ,w.user_engineer_id
      ,w.logo_image AS worker_image
      ,w.initial_name
      ,w.worker_type
    ';
    
    $data = DB::table('message_room AS m')
      ->select(DB::RAW($select))
      ->leftjoin('worker AS w', 'm.worker_id', "=", 'w.worker_id')
      ->where('w.del_flag', 0)
      ->where('m.user_company_id', $user_company_id)
      ->orderby('m.update_date', 'DESC');
  
    return $data->get();
  }
  
  public static function updateTimeStamp($room_id)
  {
    DB::table('message_room')
      ->where('room_id', $room_id)
      ->update(['update_date' => DB::RAW('CURRENT_TIMESTAMP')]);
  }
}
