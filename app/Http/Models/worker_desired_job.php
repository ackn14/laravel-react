<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_desired_job extends Model
{

  protected $table = 'worker_desired_job';
  protected $guarded = ['id'];
  public $timestamps = false;


  /*
   * スキル取得
   */
  public static function getDesiredJobByWorkerId($worker_id)
  {
      // worker_idに紐づく希望職種を取得
      $select = " w.worker_id
                 ,w.desired_job_id
                 ,job.job_name
                 ,job.job_category_id
                 ";

      $desiredJob = DB::table('worker_desired_job AS w')
          ->select(DB::raw($select))
          ->leftjoin('m_job AS job', 'job.job_id', "=", "w.desired_job_id")
          ->where('worker_id', $worker_id)
          ->get();

      return $desiredJob;
  }

  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('worker_desired_job')
            ->where('worker_id', $data['worker_id'])
            ->where('desired_job_id', $data['desired_job_id']);

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public static function del($worker_id){
    \DB::table('worker_desired_job')
            ->where('worker_id', $worker_id)->delete();
  }

  public static function insert($desired_job)
  {
    $record = \DB::table('worker_desired_job')
            ->where('worker_id', $desired_job['worker_id'])
            ->where('desired_job_id', $desired_job['desired_job_id']);

    $record->insert($desired_job);
  }
  
  /*
   * 条件から求職者数を取得
   */
  public static function countFilteredDesiredJob($search = null, $loginInfo)
  {
    $data = DB::table('worker_desired_job AS w')
      ->select(DB::RAW('*'))
      ->leftjoin('worker', 'worker.worker_id', '=', 'w.worker_id')
      ->where('w.del_flag', '0')
      ->where('worker.del_flag', '0')
    ;
  
  
    if (!isset($loginInfo['admin_flag']) || $loginInfo['admin_flag'] != 1) {
      $data = $data->where('worker.release_flag', 1);
    }
    
    if (array_key_exists("job_id", $search) && $search['job_id']) {
      $data = $data->where('w.desired_job_id', $search['job_id']);
    }

    return $data->count();
  }
}

