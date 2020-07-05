<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_reviews extends Model
{
  protected $table = 'worker_reviews';
  protected $guarded = ['id'];
  public $timestamps = false;
  
  
  /*
   * レビュー取得
   */
  public static function get($search)
  {
    $data = DB::table('worker_reviews')
      ->select(DB::raw('*'));
    
    if(isset($search['worker_id'])) {
      $data = $data->where('worker_id', $search['worker_id']);
    }
    
    if(isset($search['user_company_id'])) {
      $data = $data->where('user_company_id', $search['user_company_id']);
    }
    
    if(isset($search['rating'])) {
      $data = $data->where('rating', $search['rating']);
    }
    
    if(isset($search['release_flag'])) {
      $data = $data->where('release_flag', $search['release_flag']);
    }
    
    if(isset($search['del_flag'])) {
      $data = $data->where('del_flag', $search['del_flag']);
    }
    
    $data = $data->orderby('create_date');
    
    $data = $data->get();
    
    return $data;
  }
  
  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = DB::table('worker_reviews')
      ->where('worker_id', $data['worker_id'])
      ->where('user_company_id', $data['user_company_id'])
    ;
    
    if($record->exists()) $record->update($data); else $record->insert($data);
  }
  
  public static function del($data){
    DB::table('worker_reviews')
      ->where('worker_id', $data['worker_id'])
      ->where('user_company_id', $data['user_company_id'])
      ->delete();
  }
  
}
