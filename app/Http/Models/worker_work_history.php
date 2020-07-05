<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_work_history extends Model
{
  public static function getByWorkerId($worker_id)
  {
    $select = "
      w.worker_id
     ,w.id
     ,w.company_name
     ,w.job_id
     ,CASE WHEN w.job_id IS NULL THEN
        ''
      ELSE
        w.job_id
      END AS job_id
     ,CASE WHEN w.industry IS NULL THEN
        ''
      ELSE
        w.industry
      END AS industry
     ,CASE WHEN w.contract_type IS NULL THEN
        ''
      ELSE
        w.contract_type
      END AS contract_type
     ,CASE WHEN w.monthly_income IS NULL THEN
        ''
      ELSE
        w.monthly_income
      END AS monthly_income
     ,w.management_experience
     ,w.work_content
     ,w.achievement
     ,w.start_date
     ,w.end_date
     ,DATE_FORMAT(w.start_date, \"%Y年%m月%d日\") as start_date_jp
     ,DATE_FORMAT(w.end_date, \"%Y年%m月%d日\") as end_date_jp
     ,m_job.job_name
    ";

    $data = DB::table('worker_work_history AS w')
      ->select(DB::raw($select))
      ->leftjoin('m_job', 'm_job.job_id', '=', 'w.job_id')
      ->where('worker_id', $worker_id)
      ->get();

    return $data;
  }

  /*
   * insert or update判定
   */
  public
  static function upsert($data)
  {
    $record = \DB::table('worker_work_history')
      ->where('worker_id', $data['worker_id'])
      ->where('id', $data['id']);

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public
  static function del($worker_id)
  {
    \DB::table('worker_work_history')
      ->where('worker_id', $worker_id)->delete();
  }

  public
  static function insert($sns)
  {
    $record = \DB::table('worker_work_history');

    $record->insert($sns);
  }
}
