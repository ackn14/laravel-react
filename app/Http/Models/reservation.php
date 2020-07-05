<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class reservation extends Model
{
  static $project_count = null;
  static $project_disp_count = null;
  protected $table = 'message_room';
  protected $guarded = ['room_id'];
  public $timestamps = false;


  public static function getReservationData($user_engineer_id,$company_id){
    $select = '
         r.reservation_id,
         r.user_engineer_id,
         r.company_id,
         r.project_id,
         r.reservation_date,
         TIME_FORMAT(r.reservation_time,"%H:%i") AS reservation_time,
         r.reservation_text,
         r.event_id,
         r.create_date
      ';

    $data = DB::table('reservation AS r')
            ->select(DB::RAW($select))
            ->join('company as c','c.company_id', "=", "r.company_id")
            ->where('r.user_engineer_id', $user_engineer_id)
            ->where('r.company_id', $company_id)
            ->where('r.del_flag', 0)
            ->where('r.cancel_flag', 0)
            ->whereDate('r.reservation_date', '>=',date('Y-m-d'))
            ->orderby('create_date')
            ->get()
    ;

    if(count($data) != 0){
      return $data[0];
    }else{
      return null;
    }
  }


  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('reservation')->select("reservation_id")
            ->where('reservation_id', $data['reservation_id'])
            ->where('del_flag', 0)
            ->where('cancel_flag', 0)
    ;

    $record_pattern2 = \DB::table('reservation')->select("reservation_id")
            ->where('reservation_id', $data['reservation_id'])
            ->where('del_flag', 0)
            ->where('cancel_flag', 0)
    ;

    if ($record->exists()) {
      $data['reservation_id'] = $record->get()[0]->reservation_id;
      $record->update($data);
      $data['mode'] = 'update';
      return $data;
    } else {
      $data['reservation_id'] = $record->insertGetId($data);
      $data['mode'] = 'insert';
      return $data;
      //return $record->project_id;

    }
  }

  /*
   * キャンセルフラグ更新
   */
  public static function updCancelFlag($data){
    try{
      \DB::table('reservation')->where("reservation_id",$data['reservation_id'])
              ->update($data);
    }catch (\Exception $e) {
      throw $e;
    }
    return true;
  }

  /*
   * 面接予約状況取得(企業側)
   */
  public static function getCompanyReservationList($company_id){
    $select = '
         distinct
         DATE_FORMAT(reservation_date, "%m月%d日(%a)") as reservation_date
        ,TIME_FORMAT(reservation_time, "%H:%i") as reservation_start_time
        ,TIME_FORMAT(ADDTIME(reservation_time,"00:30:00"), "%H:%i") as reservation_end_time
        ,reservation_time
        ,DATE_FORMAT(reservation_date, "%Y/%m/%d") as reservation_date_data
        ,worker.worker_id
        ,worker.initial_name
        ,worker.logo_image as worker_image
        ,project.project_id
        ,project.title
        ,project.cover_image as project_image
        ,job.job_category_id
      ';

    $data = DB::table('reservation AS r')
            ->select(DB::RAW($select))
            ->join('company as c','c.company_id', "=", "r.company_id")
            ->leftjoin('worker','worker.user_engineer_id', '=', 'r.user_engineer_id')
            ->leftjoin('project', 'project.project_id', '=', 'r.project_id')
            ->leftjoin('m_job AS job', 'job.job_id', "=", "project.job_id")
            ->where('r.company_id', $company_id)
            ->where('r.del_flag', 0)
            ->where('r.cancel_flag', 0)
            ->whereDate('r.reservation_date', '>=',date('Y-m-d'))
            ->orderby('r.reservation_date')
            ->orderby('r.reservation_time')
            ->get();

    return $data;
  }

  /*
   * 面接予約状況取得(エンジニア側)
   */
  public static function getWorkerReservationList($user_engineer_id){
    $select = '
        DISTINCT DATE_FORMAT(reservation_date, "%m月%d日") as reservation_date
        ,TIME_FORMAT(reservation_time, "%H:%i") as reservation_start_time
        ,TIME_FORMAT(ADDTIME(reservation_time,"00:30:00"), "%H:%i") as reservation_end_time
        ,DATE_FORMAT(reservation_date, "%Y/%m/%d") as reservation_date_data
        ,c.company_id AS company_id
        ,c.company_name AS company_name
        ,c.logo_image AS company_logo_image
        ,project.project_id
        ,project.title
        ,project.cover_image as project_image
        ,user_company.user_company_id
        ,CONCAT(user_company.last_name, user_company.first_name) AS full_name
        ,user_company.logo_image as user_company_image
        ,job.job_category_id
      ';

    $data = DB::table('reservation AS r')
            ->select(DB::RAW($select))
            ->join('company as c','c.company_id', "=", "r.company_id")
            ->where('c.del_flag', 0)
            ->where('c.release_flag', 1)
            ->leftjoin('project', 'project.project_id', '=', 'r.project_id')
            ->leftjoin('user_company', 'user_company.user_company_id', '=', 'project.project_manager_id')
            ->leftjoin('m_job AS job', 'job.job_id', "=", "project.job_id")
            ->where('r.user_engineer_id', $user_engineer_id)
            ->where('r.del_flag', 0)
            ->where('r.cancel_flag', 0)
            ->whereDate('r.reservation_date', '>=',date('Y-m-d'))
            ->orderby('r.reservation_date')
            ->orderby('r.reservation_time')
            ->get()
    ;
    return $data;
  }

  public static function getCountMonthlyReservation($company_id, $month_ago = null) {
    $select = '
        COUNT(*) AS count
    ';

    $data = DB::table('reservation AS r')
            ->select(DB::RAW($select))
            ->join('company as c','c.company_id', "=", "r.company_id")
            ->where('r.company_id', $company_id)
            ->where('r.del_flag', 0)
            ->where('r.cancel_flag', 0)
            ->groupby('r.company_id')
    ;

    if(isset($month_ago) && $month_ago > 0) {
      $data = $data->whereRaw('
                               r.reservation_date 
                               BETWEEN DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . -$month_ago . ' MONTH), "%Y-%m-01")
                               AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . (-$month_ago + 1) . ' MONTH), "%Y-%m-01")
                              ');
    } else {
      $data = $data->whereRaw('
                               r.reservation_date 
                               BETWEEN DATE_FORMAT(CURDATE(), "%Y-%m-01")
                               AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . 1 . ' MONTH), "%Y-%m-01")
                              ');
    }

    $data = $data->get();

    if(isset($data[0])) {
      return $data[0]->count;
    } else {
      return 0;
    }

  }

}
