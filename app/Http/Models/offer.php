<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class offer extends Model
{

  protected $table = 'offer';
  protected $guarded = ['id'];
  public $timestamps = false;

  public static function getWorkerListByUserCompanyId($user_company_id, $search = [], $limit = null)
  {
    $select = '
      o.worker_id
      ,o.project_id
      ,o.recruitment_status
      ,w.worker_type
      ,w.initial_name
      ,w.user_engineer_id
      ,w.logo_image as worker_image
      ,w.worker_manager_id
      ,p.title
      ,p.project_manager_id
      ,uc.first_name
      ,uc.last_name
      ,CONCAT(uc.last_name, uc.first_name) AS full_name
      ,DATE_FORMAT(o.create_date, "%Y年%m月%d日") as entry_date
    ';

    $data = DB::table('offer AS o')
      ->select(DB::raw($select))
      ->leftjoin('worker AS w', 'o.worker_id', '=', 'w.worker_id')
      ->leftjoin('user_company AS uc', 'uc.user_company_id', '=', 'w.worker_manager_id')
      ->leftjoin('project AS p', 'o.project_id', '=', 'p.project_id')
      ->where('p.project_manager_id', $user_company_id)
      ->where('w.del_flag', '0')
      ->orderby('o.create_date', 'DESC');

    if (isset($search['recruitment_status'])) {
      $data = $data->where('o.recruitment_status', $search['recruitment_status']);
    }

    $data = $data->groupby('o.id');
    
    if ($limit) {
      $data = $data->limit($limit);
    }

    return $data->get();
  }

  public static function getOfferProject($worker_id)
  {
    $select = '
      o.project_id
      ,p.title
      ,c.company_id
      ,c.company_name
    ';

    $data = DB::table('offer AS o')
      ->select(DB::raw($select))
      ->leftjoin('project AS p', 'o.project_id', '=', 'p.project_id')
      ->leftjoin('company AS c', 'p.company_id', '=', 'c.company_id')
      ->where('o.worker_id', $worker_id)
      ->where('p.del_flag', 0)
      ->where('o.del_flag', 0)
      ->where('c.del_flag', 0);

    return $data->get();
  }

  /*
   * 応募情報を登録する
   */
  public static function insert($data)
  {
    try {
      $record = \DB::table('offer')->select("id");
    } catch (\Exception $e) {
      return null;
    }

    return $record->insertGetId($data);
  }

  public static function getIsOffered($worker_id = null, $project_id = null)
  {
    $select = '
      *
    ';

    $data = DB::table('offer AS o')
      ->select(DB::RAW($select))
      ->where('del_flag', 0);

    if ($project_id) {
      $data = $data->where('o.project_id', '=', $project_id);
    }

    if ($worker_id) {
      $data = $data->where('o.worker_id', '=', $worker_id);
    }

    if ($data->count() > 0) {
      return $data->get();
    } else {
      return false;
    }
  }

  /*
   * 応募数を取得
   */
  public static function getLast3DaysOffers($company_id, $search = array(), $limit = null)
  {
    $select = '
       DATE_FORMAT(o.create_date, \'%Y-%m-%d\') AS date
      ,COUNT(*) AS count
      ';

    $data = DB::table('offer AS o')
      ->select(DB::RAW($select))
      ->leftjoin('project AS p', 'p.project_id', '=', 'o.project_id')
      ->where('p.company_id', '=', $company_id)
      ->whereRaw("o.create_date BETWEEN DATE_SUB(curdate(), interval 2 day) AND DATE_ADD(curdate(), interval 1 day)")
      ->groupBy(DB::raw("DATE_FORMAT(o.create_date, '%Y%m%d')"))
      ->orderby('o.create_date', 'DESC')
      ->get();

    return $data;
  }

  /*
   * 応募数を取得（直近1日間）
   * $month_ago は0なら今月 1なら1ヶ月前 ...
   */
  public static function getCountOffers($company_id, $month_ago = null)
  {
    $select = '
        COUNT(*) AS count
    ';

    $data = DB::table('offer')
      ->select(DB::RAW($select))
      ->leftjoin('project', 'project.project_id', '=', 'offer.project_id')
      ->where('project.company_id', '=', $company_id);


    if (isset($month_ago) && $month_ago > 0) {
      $data = $data->whereRaw('
                               offer.create_date
                               BETWEEN DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . -$month_ago . ' MONTH), "%Y-%m-01")
                               AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . (-$month_ago + 1) . ' MONTH), "%Y-%m-01")
                              ');
    } elseif (isset($month_ago) && $month_ago === 0) {
      $data = $data->whereRaw('
                               offer.create_date
                               BETWEEN DATE_FORMAT(CURDATE(), "%Y-%m-01")
                               AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL 1 MONTH), "%Y-%m-01")
                              ');
    }

    $data = $data->groupBy('project.company_id')->get();

    if (isset($data[0])) {
      return $data[0]->count;
    } else {
      return 0;
    }
  }

  /*
  * 月ごとのエントリー数取得
  */
  public static function getCountMonthlyEntries($worker_id, $month_ago = null)
  {
    $select = '
        COUNT(*) AS count
    ';

    $data = DB::table('offer')
      ->select(DB::RAW($select))
      ->where('worker_id', '=', $worker_id);

    if (isset($month_ago) && $month_ago > 0) {
      $data = $data->whereRaw('
          create_date
          BETWEEN DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . -$month_ago . ' MONTH), "%Y-%m-01")
          AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . (-$month_ago + 1) . ' MONTH), "%Y-%m-01")
          ');
    } elseif (isset($month_ago) && $month_ago === 0) {
      $data = $data->whereRaw('
          create_date
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

  /*
  * トータルエントリー数取得
  */
  public static function totalEntries()
  {
    $select = '
      count(*) as totalEntries
    ';

    $data = DB::table('offer')
      ->select(DB::RAW($select))
      ->where('del_flag', '=', 0);
    $data = $data->get();

    return $data[0]->totalEntries;
  }
}
