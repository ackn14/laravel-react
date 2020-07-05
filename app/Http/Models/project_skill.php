<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class project_skill extends Model
{

  protected $table = 'project_skill';
  protected $guarded = ['id'];
  public $timestamps = false;


  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('project_skill')
            ->where('project_id', $data['project_id'])
            ->where('skill_id', $data['skill_id']);
    

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public static function del($project_id, $priority = null){
    $record = \DB::table('project_skill')
            ->where('project_id', $project_id);
    
    if(isset($priority)) {
      $record = $record->where('priority', $priority);
    }
    
    $record->delete();
  }

  /*
   * デリートインサートする
   */
  public static function deleteInsert($project_id,$data){
    $record = \DB::table('project_skill')
            ->where('project_id', $project_id);
    $record->delete();

    $record->insert($data);
  }
  
  public static function getByProjectId($project_id, $priority = null)
  {
    // project_idに紐づくスキルセットを取得
    $select = " p.project_id
                 ,p.skill_id
                 ,skill.skill_name
                 ";
  
    $skill = DB::table('project_skill AS p')
      ->select(DB::raw($select))
      ->leftjoin('m_skill AS skill', 'skill.skill_id', "=", "p.skill_id")
      ->where('p.project_id', $project_id);
    
    if(isset($priority)) {
      $skill = $skill->where('p.priority', $priority);
    }
      $skill = $skill->get();
  
    return $skill;
  }
}

