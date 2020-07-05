<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_portfolio extends Model
{
  protected $table = 'worker_portfolio';
  protected $guarded = ['id'];
  public $timestamps = false;
  
  
  /*
   * ポートフォリオ取得
   */
  public static function getPortfolioByWorkerId($worker_id)
  {
    $data = DB::table('worker_portfolio')
      ->select(DB::raw('*'))
      ->where('worker_id', $worker_id)
      ->get();
    
    return $data;
  }
  
  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = DB::table('worker_portfolio')
      ->where('worker_id', $data['worker_id'])
      ->where('id', $data['id']);
    
    if($record->exists()) {
      $record->update($data);
      return $data['id'];
    } else {
      return $record->insertGetId($data);
    }
  }
  
  public static function del($data){
    DB::table('worker_portfolio')
      ->where('worker_id', $data['worker_id'])
      ->where('id', $data['id'])
      ->delete();
  }
  
  public static function insertGetId($data)
  {
    $record = DB::table('worker_portfolio')
      ->where('id', $data['id'])
      ->where('worker_id', $data['worker_id']);
    
    $id = "";
    if(!$record->exists()) {
      $id = $record->insertGetId($data);
    }
    
    return $id;
  }
  
}
