<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class project_feature extends Model
{

  protected $table = 'project_feature';
  protected $guarded = ['id'];
  public $timestamps = false;


  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('project_feature')
            ->where('project_id', $data['project_id'])
            ->where('project_feature_id', $data['project_feature_id']);

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public static function del($project_id){
    \DB::table('project_feature')
            ->where('project_id', $project_id)->delete();
  }
  
  public static function getByProjectId($project_id)
  {
    // project_idに紐づくスキルセットを取得
    $select = " p.project_id
                 ,p.project_feature_id
                 ,f.another_feature_name
                 ";
    
    $feature = DB::table('project_feature AS p')
      ->select(DB::raw($select))
      ->leftjoin('m_another_feature AS f', 'f.another_feature_id', "=", "p.project_feature_id")
      ->where('p.project_id', $project_id)
      ->get();
    
    return $feature;
  }

  public static function getFeatureId($project_id){
    $select = "project_feature_id";
    $features = DB::table('project_feature')
    ->select($select)
    ->where('project_id', $project_id)
    ->get();

    //文字列に変換
    $feature = "default";
    foreach($features as $f){
      $feature .= ",".$f->project_feature_id;
    }
    return $feature;
  }
}

