<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class project_matching_score_to_worker extends Model
{
  protected $table = 'project_matching_score_to_worker';


  public static function getUpdateDate ($project_id)
  {
    $select = "update_date";

    $data = DB::table('project_matching_score_to_worker')
          ->select(DB::raw($select))
          ->where("project_id", $project_id)
          ->orderBy("update_date", "asc")
          ->limit(1)
          ->get();

    return $data;
  }
}