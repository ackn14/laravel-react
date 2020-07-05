<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class send_recommend_worker_mail extends Model
{

  protected $table = 'send_recommend_worker_mail';
  protected $guarded = ['worker_id','create_date'];
  public $timestamps = false;


  /*
   * insert(但し未送信データがある場合は追加しない)
   */
  public static function insert($data)
  {
    $record = \DB::table('send_recommend_worker_mail')
            ->where('worker_id', $data['worker_id'])
            ->where('send_flag', '0');

    if(!$record->exists()) $record->insert($data);
  }


  public static function updSendFlag($worker_id){
    $data = DB::table('send_recommend_worker_mail')
            ->where('worker_id', $worker_id)
            ->update(['send_flag' => 1]);
  }


  public static function getFirstUnsentMail()
  {
    $select = '
               worker.*
              ,pre.prefecture_name AS prefecture_name
              ,desired_contract_type.display_name AS desired_contract_type_name
              ,GROUP_CONCAT(DISTINCT d_pre.prefecture_name) AS desired_prefecture_name
              ,GROUP_CONCAT(DISTINCT m_job.job_name) AS desired_job_name
              ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_name

    ';
    
    
    $record = \DB::table('send_recommend_worker_mail')->select(DB::RAW($select))
            ->join('worker',"send_recommend_worker_mail.worker_id", "=", "worker.worker_id")
            ->leftjoin('m_prefecture AS pre', 'pre.prefecture_id', '=', 'worker.prefecture_id')
            ->leftjoin('m_code AS desired_contract_type', function($join) {
              $join->on( 'desired_contract_type.code', '=', 'worker.desired_contract_type')
                      ->where('desired_contract_type.category', '=', 'contract_type');
            })
            ->leftjoin('worker_desired_job', 'worker_desired_job.worker_id', '=', 'worker.worker_id')
            ->leftjoin('m_job', 'm_job.job_id', '=', 'worker_desired_job.desired_job_id')
            ->leftjoin('worker_desired_workingplace', 'worker_desired_job.worker_id', '=', 'worker.worker_id')
            ->leftjoin('m_prefecture AS d_pre', function($join) {
              $join->on('d_pre.prefecture_id', '=', 'worker_desired_workingplace.prefecture_id')
                      ->orderby('d_pre.prefecture_id', 'asc');
            })
            ->leftjoin('worker_skill', 'worker_skill.worker_id', '=', 'worker.worker_id')
            ->leftjoin('m_skill', 'm_skill.skill_id', '=', 'worker_skill.skill_id')
            ->where('worker.del_flag', '=', 0)
            ->where('send_recommend_worker_mail.send_flag', 0)
            ->groupby('worker.worker_id')
            ->orderby('send_recommend_worker_mail.create_date', 'asc')
            ->limit(1);

    if ($record->exists()) {
      $record = $record->get();
      return  $record[0];
    }
    return null;
  }
}

