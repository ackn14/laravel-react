<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_interview extends Model
{
  protected $table = 'worker_interview';
  protected $guarded = ['id'];
  public $timestamps = false;




  public static function getInterviewData($worker_id){
    $select = "
         w.worker_id
        ,w.movie 
        ,wi.programming_language
        ,wi.desired_case_project
        ,wi.desired_amount
        ,wi.minimum_amount
        ,wi.commuting_time
        ,wi.operation
        ,wi.operation_start_date
        ,wi.operating_period
        ,wi.priority
        ,wi.parallel_situation
        ,wi.memo
        ";

    $data = DB::table('worker AS w')
        ->select(DB::raw($select))
        ->leftjoin('worker_interview AS wi', 'wi.worker_id', '=', 'w.worker_id')
        ->where("w.del_flag", 0)
        ->where("w.worker_id", $worker_id)
    ->get();

    if(count($data) < 1){
      return false;
    }

    return $data[0];
  }



  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('worker_interview')
      ->where('worker_id', $data['worker_id']);

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public static function del($worker_id){
    \DB::table('worker_interview')
      ->where('worker_id', $worker_id)->delete();
  }

  public static function insert($skill)
  {
    $record = \DB::table('worker_interview')
      ->where('worker_id', $skill['worker_id']);

    $record->insert($skill);
  }
}
