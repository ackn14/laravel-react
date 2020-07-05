<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class offer_to_worker extends Model
{

  protected $table = 'offer_to_worker';
  protected $guarded = ['id'];
  public $timestamps = false;


  public static function getWorkerList($user_company_id, $search = [], $limit = null)
  {
    $select = '
      o.worker_id
      ,o.recruitment_status
      ,w.worker_type
      ,w.initial_name
      ,w.user_engineer_id
      ,w.worker_manager_id
      ,w.logo_image as worker_image
      ,uc.user_company_id
      ,uc.last_name
      ,uc.first_name
      ,CONCAT(uc.last_name, uc.first_name) AS full_name
      ,DATE_FORMAT(o.create_date, "%Y年%m月%d日") as offer_date
    ';

    $data = DB::table('offer_to_worker AS o')
      ->select(DB::raw($select))
      ->leftjoin('worker AS w', 'o.worker_id', '=', 'w.worker_id')
      ->leftjoin('user_company AS uc', 'uc.user_company_id', '=', 'o.user_company_id')
      ->where('o.user_company_id', $user_company_id)
      ->where('w.del_flag', '0')
      ->orderby('o.create_date', 'DESC');

    if(isset($search['recruitment_status'])) {
      $data = $data->where('o.recruitment_status', $search['recruitment_status']);
    }

    $data = $data->groupby('w.worker_id');

    if ($limit) {
      $data = $data->limit($limit);
    }

    return $data->get();
  }

  /*
   * 応募情報を登録する
   */
  public static function insert($data)
  {
    try {
      return \DB::table('offer_to_worker')->insertGetId($data);
    } catch (\Exception $e) {
      return null;
    }
  }

  /*
   * トータルエントリー数取得
   */
  public static function totalOffers()
  {
    $select = '
      count(*) as totalOffers
    ';

    $data = DB::table('offer_to_worker')
      ->select(DB::RAW($select))
      ->where('del_flag', '0');
    $data = $data->get();

    return $data[0]->totalOffers;
  }

  /*
   * オファー数を取得
   */

  public static function getEngineerOffers($worker_id, $search = array(), $limit = null)
  {
    $select = '
       DATE_FORMAT(o.create_date, \'%Y-%m-%d\') AS date
      ,COUNT(*) AS count';

    $data = DB::table('offer_to_worker AS o')
      ->select(DB::RAW($select))
      // ->leftjoin('user_company AS u', 'u.user_company_id', '=', 'o.user_company_id')
      ->where('worker_id', '=', $worker_id)

      ->groupBy(DB::raw("DATE_FORMAT(o.create_date, '%Y%m%d')"))
      ->orderby('o.create_date', 'DESC')
      ->get();
    return $data;
  }

  /*
   * オファー数を取得（直近1日間）
   * $month_ago は0なら今月 1なら1ヶ月前 ...
   */
  public static function getCountMonthlyOffers($worker_id, $month_ago = null)
  {
    $select = '
        COUNT(*) AS count
    ';

    $data = DB::table('offer_to_worker As o')
      ->select(DB::RAW($select))
      // ->leftjoin('user_company AS u', 'u.user_company_id', '=', 'o.user_company_id')
      ->where('worker_id', '=', $worker_id);


    if (isset($month_ago) && $month_ago > 0) {
      $data = $data->whereRaw('
                               o.create_date
                               BETWEEN DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . -$month_ago . ' MONTH), "%Y-%m-01")
                               AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . (-$month_ago + 1) . ' MONTH), "%Y-%m-01")
                              ');
    } elseif (isset($month_ago) && $month_ago === 0) {
      $data = $data->whereRaw('
                               o.create_date
                               BETWEEN DATE_FORMAT(CURDATE(), "%Y-%m-01")
                               AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL 1 MONTH), "%Y-%m-01")
                              ');
    }

    $data = $data->groupBy('worker_id')->get();
    if (isset($data[0])) {
      return $data[0]->count;
    } else {
      return 0;
    }
  }
}
