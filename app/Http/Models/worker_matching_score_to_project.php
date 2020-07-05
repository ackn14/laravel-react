<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_matching_score_to_project extends Model
{
  protected $table = 'worker_matching_score_to_project';


  public static function getUpdateDate ($worker_id)
  {
    $select = "update_date";

    $data = DB::table('worker_matching_score_to_project')
          ->select(DB::raw($select))
          ->where("worker_id", $worker_id)
          ->orderBy("update_date", "asc")
          ->limit(1)
          ->get();

    return $data;
  }
  /*
   * 送信済みフラグを更新
   */
  public static function updateSendFlag ($worker_id, $project_id, $flag = 0)
  {
    if (!is_numeric($worker_id) || !is_bool($flag)) {
      return false;
    }

    $data = DB::table('worker_matching_score_to_project')
        ->where('worker_id', $worker_id);

    if (is_numeric($project_id)) {
      $data = $data->where('project_id', $project_id);
    } elseif (is_array($project_id)) {
      $data = $data->whereIn('project_id', $project_id);
    } else {
      return false;
    }

    $data->lockForUpdate()->update(['mail_send_flag' => $flag]);

    return true;
  }
}