<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_desired_another_feature extends Model
{
  
  protected $table = 'worker_desired_another_feature';
  protected $guarded = ['id'];
  public $timestamps = false;
  
  
  /*
   * スキル取得
   */
  public static function getDesiredAnotherFeatureByWorkerId($worker_id)
  {
    // worker_idに紐づく希望職種を取得
    $select = " w.worker_id
                 ,w.desired_another_feature_id
                 ,feature.another_feature_name
                 ";
    
    $desiredJob = DB::table('worker_desired_another_feature AS w')
      ->select(DB::raw($select))
      ->leftjoin('m_another_feature AS feature', 'feature.another_feature_id', "=", "w.desired_another_feature_id")
      ->where('worker_id', $worker_id)
      ->get();
    
    return $desiredJob;
  }
  
  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('worker_desired_another_feature')
      ->where('worker_id', $data['worker_id'])
      ->where('desired_another_feature_id', $data['desired_another_feature_id']);
    
    $record->exists() ? $record->update($data) : $record->insert($data);
  }
  
  public static function del($worker_id){
    \DB::table('worker_desired_another_feature')
      ->where('worker_id', $worker_id)->delete();
  }
  
  public static function insert($desired_another_feature)
  {
    $record = \DB::table('worker_desired_another_feature')
      ->where('worker_id', $desired_another_feature['worker_id'])
      ->where('desired_another_feature_id', $desired_another_feature['desired_another_feature_id']);
    
    $record->insert($desired_another_feature);
  }
}
