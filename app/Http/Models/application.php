<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class application extends Model
{
  protected $table = 'application';
  protected $guarded = ['id'];
  public $timestamps = false;

  /*
   * 申請数を取得
   */
  public static function getLast3DaysApplications($company_id, $search = array(), $limit = null)
  {
    $select = '
       DATE_FORMAT(ap.create_date, \'%Y-%m-%d\') AS date
      ,COUNT(*) AS count
      ';

    $data = DB::table('application AS ap')
      ->select(DB::RAW($select))
      ->where('ap.company_id', '=', $company_id)
      ->whereRaw("ap.create_date BETWEEN DATE_SUB(curdate(), interval 2 day) AND DATE_ADD(curdate(), interval 1 day)")
      ->groupBy(DB::raw("DATE_FORMAT(ap.create_date, '%Y%m%d')"))
      ->orderby('ap.create_date', 'DESC')
      ->get();

    return $data;
  }

  public static function upsert($data, $company_id, $worker_id)
  {
    $record = \DB::table('application')->select("id")
      ->where('worker_id', $worker_id)
      ->where('company_id', $company_id);

    if ($record->exists()) {
      $data['id'] = $record->get()[0]->id;
      $record->update($data);
      return $data['id'];
    } else {
      return $record->insertGetId($data);
      //return $record->project_id;
    }
  }
}
