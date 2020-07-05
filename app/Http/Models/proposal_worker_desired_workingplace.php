<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class proposal_worker_desired_workingplace extends Model
{

  public static function insert($business_talk_status_id, $worker_id){
    $select = 'business_talk_status_id
          ,worker_id
          ,prefecture_id
          ,priority
          ';

    $query = DB::table('worker_desired_workingplace')
          ->select(DB::RAW($business_talk_status_id.' AS '.$select))
          ->where('worker_id', $worker_id)->toSql();

    $insert_query = 'INSERT INTO proposal_worker_desired_workingplace('.$select.') '.$query;

    $insert = DB::insert($insert_query, [$worker_id]);
  }
}
