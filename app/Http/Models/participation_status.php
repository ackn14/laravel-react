<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class participation_status extends Model
{

  static $participation_status_count = null;
  static $participation_status_disp_count = null;
  protected $table = 'participation_status';
  protected $guarded = ['participation_status_id'];
  public $timestamps = false;

  public static function get($search, $company_id)
  {
    if(!is_numeric($company_id)) return false;

    $select = "
                 participation_status.participation_status_id
                ,worker.worker_id
                ,CASE
                  WHEN user_company.company_id <>" . $company_id . " THEN worker.initial_name 
                  WHEN worker.first_name IS NOT NULL && worker.last_name IS NOT NULL THEN CONCAT(worker.last_name,worker.first_name)
                  WHEN worker.last_name IS NOT NULL THEN worker.last_name
                  WHEN worker.first_name IS NOT NULL THEN worker.first_name
                  ELSE worker.initial_name
                END worker_name  
                ,worker.initial_name
                ,participation_status.period_start
                ,DATE_FORMAT(participation_status.period_start,'%Y-%m-01') as period_start_month 
                ,participation_status.period_end
                ,DATE_FORMAT(participation_status.period_end,'%Y-%m-28') as period_end_month
                ,participation_status.project_id
                ,participation_status.note
                ,participation_status.expectation_money
                ,participation_status.real_money
                ,project.title
                ,PERIOD_DIFF(DATE_FORMAT(participation_status.period_end, '%Y%m'),DATE_FORMAT(participation_status.period_start, '%Y%m')) as period_month
                ,DATE_FORMAT(NOW(),'%Y-%m-01') as current_month
              ";

    $query = DB::table('worker')
            ->select(DB::raw($select))
            ->leftjoin('participation_status', 'worker.worker_id', '=', 'participation_status.worker_id')
            ->leftjoin('project', 'project.project_id', '=', 'participation_status.project_id')
            ->leftjoin('user_company', 'worker.worker_manager_id', '=', 'user_company.user_company_id')
            ->where('worker.del_flag', '=', '0');
    if (array_key_exists('filter_user_company_id', $search)) {
      $query = $query->where('user_company.user_company_id', '=', $search['filter_user_company_id']);
    }


    if ($search['allSearchWorkerFlag'] == "true") {
      $query = $query->Join('company', 'company.company_id', "=", 'user_company.company_id')
              ->where(function ($query) {
                $query->whereNull('participation_status.del_flag')
                        ->orWhere('participation_status.del_flag', 0);
              })
              ->where(function ($query) {
                $query->whereNull('participation_status.period_end')
                        ->orWhereRAW('participation_status.period_end >= DATE_FORMAT(NOW(),"%Y-%m-01")');
              });

    } else {
      $query = $query->whereNotNull('participation_status.participation_status_id')
              ->where('participation_status.del_flag', 0)
              ->whereRaw('participation_status.period_end >= DATE_FORMAT(NOW(),"%Y-%m-01")')
              ->where('participation_status.company_id', "=", $company_id);
    }


    $query = $query->orderByRaw('worker.initial_name desc, participation_status.period_end asc');


    //全体の合計数を取得
    self::$participation_status_count = $query->count();
    $query = $query->get();

    self::$participation_status_disp_count = $query->count();

    return $query;
  }


  public static function upsert($data, $company_id, $participation_status_id = null)
  {
    $record = \DB::table('participation_status')->select("participation_status_id")
            ->where('participation_status_id', $participation_status_id)
            ->where('company_id', $company_id);

    if ($record->exists()) {
      $data['participation_status_id'] = $record->get()[0]->participation_status_id;
      $record->update($data);
      return $data['participation_status_id'];
    } else {
      return $record->insertGetId($data);
    }
  }


  /*
 * 削除機能
 */
  public static function del($participation_status_id, $company_id)
  {
    try {
      // 処理
      DB::table('participation_status')
              ->where('company_id', $company_id)
              ->where('participation_status_id', $participation_status_id)
              ->update(['del_flag' => 1]);
      return true;
    } catch (\Exception $e) {
      echo $e->getMessage();
      // 例外処理
      return false;
    }
  }

}
