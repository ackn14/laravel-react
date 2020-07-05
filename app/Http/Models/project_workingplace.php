<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class project_workingplace extends Model
{

  protected $table = 'project_workingplace';
  protected $guarded = ['id'];
  public $timestamps = false;


  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('project_workingplace')
            ->where('project_id', $data['project_id'])
            ->where('prefecture_id', $data['prefecture_id']);

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public static function del($project_id)
  {
    \DB::table('project_workingplace')
            ->where('project_id', $project_id)->delete();
  }


  /*
   * デリートインサートする
   */
  public static function deleteInsert($project_id, $data)
  {
    $record = \DB::table('project_workingplace')
            ->where('project_id', $project_id);
    $record->delete();

    $record->insert($data);
  }
}

