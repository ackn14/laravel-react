<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class proposal_worker_desired_job extends Model
{

  public static function insert($business_talk_status_id, $worker_id){
    $select = 'business_talk_status_id
          ,worker_id
          ,desired_job_id
          ';

    $query = DB::table('worker_desired_job')
          ->select(DB::RAW($business_talk_status_id.' AS '.$select))
          ->where('worker_id', $worker_id)->toSql();

    $insert_query = 'INSERT INTO proposal_worker_desired_job('.$select.') '.$query;

    $insert = DB::insert($insert_query, [$worker_id]);
  }
}
