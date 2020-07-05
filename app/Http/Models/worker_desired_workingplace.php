<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_desired_workingplace extends Model
{

  protected $table = 'worker_desired_workingplace';
  protected $guarded = ['id'];
  public $timestamps = false;

  /*
 * 勤務地取得
 */
  public static function getDesiredPrefectureByWorkerId($worker_id)
  {
    // worker_idに紐づく希望勤務地を取得
    $select = " w.worker_id
                ,w.prefecture_id
                ,p.prefecture_name
                ";

    $desiredWorkingPlace = DB::table('worker_desired_workingplace AS w')
            ->select(DB::raw($select))
            ->leftjoin('m_prefecture AS p', 'p.prefecture_id', "=", "w.prefecture_id")
            ->where('w.worker_id', $worker_id)
            ->orderby('priority', 'ASC')
            ->get();

    return $desiredWorkingPlace;
  }

  /*
   * ユーザー登録
   */
  public static function insertForSignUp($data, $workingPlace)
  {
      // 新規登録時のインサート
      DB::table('worker_desired_workingplace')->insert([
          'worker_id' => $data['worker_id'],
          'prefecture_id' => $workingPlace
      ]);
      return DB::getPdo()->lastInsertId();
  }

  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    $record = \DB::table('worker_desired_workingplace')
            ->where('worker_id', $data['worker_id'])
            ->where('prefecture_id', $data['prefecture_id']);

    $record->exists() ? $record->update($data) : $record->insert($data);
  }

  public static function del($worker_id){
    \DB::table('worker_desired_workingplace')
            ->where('worker_id', $worker_id)->delete();
  }

  /*
   * 勤務地の第一希望と第二希望を取得
   */
  public static function desiredWorkingPlaceByPriority($worker_id, $priority) {
    // worker_idに紐づく希望勤務地を取得
    $select = " w.worker_id
                ,w.prefecture_id
                ,p.prefecture_name
                ,w.priority
              ";

    $DesiredWorkingPlace = DB::table('worker_desired_workingplace AS w')
            ->select(DB::raw($select))
            ->leftjoin('m_prefecture AS p', 'p.prefecture_id', "=", "w.prefecture_id")
            ->where('worker_id', $worker_id)
            ->where('w.priority', $priority)
            ->first();

    return $DesiredWorkingPlace;
  }
  
  /*
   * 条件から求職者数を取得
   */
  public static function countFilteredDesiredWorkingPlace($search = null, $loginInfo)
  {
    $data = DB::table('worker_desired_workingplace AS w')
      ->select(DB::RAW('*'))
      ->leftjoin('worker', 'worker.worker_id', '=', 'w.worker_id')
      ->where('w.del_flag', '0')
      ->where('worker.del_flag', '0')
    ;
    
    
    if (isset($loginInfo['admin_flag']) && $loginInfo['admin_flag'] == 1) {
    } else {
      $data = $data->where('worker.release_flag', 1);
    }
    
    if (array_key_exists("prefecture_id", $search) && $search['prefecture_id']) {
      $data = $data->where('w.prefecture_id', $search['prefecture_id']);
    }
    
    $data = $data->count();
    
    return $data;
  }
}

