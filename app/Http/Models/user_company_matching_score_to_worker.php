<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class user_company_matching_score_to_worker extends Model
{
  protected $table = 'user_company_matching_score_to_worker';

  /*
   * insert or update判定
   */
  public static function upsert ($data)
  {
    $record = \DB::table('user_company_matching_score_to_worker')
            ->where('user_company_id', $data['user_company_id'])
            ->where('worker_id', $data['worker_id']);

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  /*
   * 送信済みフラグを更新
   */
  public static function updateSendFlag ($user_company_id, $worker_id, $flag = 0)
  {

    if (!is_numeric($worker_id) || !is_bool($flag)) {
      return false;
    }
//DB::enableQueryLog();
    $data = DB::table('user_company_matching_score_to_worker')
        ->where('user_company_id', $user_company_id);

    if (is_numeric($project_id)) {
      $data = $data->where('worker_id', $worker_id);
    } elseif (is_array($project_id)) {
      $data = $data->whereIn('worker_id', $worker_id);
    } else {
      return false;
    }

    $data->lockForUpdate()->update(['mail_send_flag' => $flag]);
//dd(DB::getQueryLog());
    return true;
  }
}