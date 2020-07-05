<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class proposal_worker extends Model
{
  public static function checkExist($business_talk_status_id, $worker_id){
    $record = \DB::table('proposal_worker')->select("business_talk_status_id")
          ->where('business_talk_status_id', $business_talk_status_id)
          ->where('worker_id', $worker_id);

    return $record->exists();
  }


  public static function insert($business_talk_status_id, $worker_id){
    $select = 'business_talk_status_id
          ,worker_id
          ,prefecture_id
          ,city_id
          ,desired_contract_type
          ,self_introduction
          ,nearest_station
          ,current_monthly_income
          ,desired_monthly_income
          ,operation_date
          ,agent_comment
          ';

    $query = DB::table('worker')
          ->select(DB::RAW($business_talk_status_id.' AS '.$select))
          ->where('worker_id', $worker_id)->toSql();

    $insert_query = 'INSERT INTO proposal_worker('.$select.') '.$query;

    $insert = DB::insert($insert_query, [$worker_id]);
  }
}
