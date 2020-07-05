<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class user_company_favorite extends Model
{
  protected $table = 'user_company_favorite';
  protected $fillable = ['user_company_id', 'target_type', 'target_id'];
  public $timestamps = false;


  public static function getFavorite($user_company_id, $target_type)
  {
    $data = [];
    if ($target_type === config('const.FAVORITE_TARGET_TYPE')['WORKER']){
      $data = self::getFavoriteWorker($user_company_id);
    }
    if ($target_type === config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']){
      $data = self::getFavoriteUserCompany($user_company_id);
    }
    return $data;
  }


  public static function getFavoriteWorkerList($search = array())
  {

    $select = '
        worker.worker_id
        ,ue.user_engineer_id
        ,worker.initial_name
        ,worker.age
        ,worker.birthday
        ,worker.sex
        ,worker.logo_image
        ,worker.self_introduction
        ,worker.operation_date
        ,worker.desired_contract_type
        ,worker.create_date
        ,worker.release_flag
        ,worker.release_date
        ,worker.del_flag
        ,worker.desired_monthly_income AS desired_monthly_income_id
        ,desired_monthly_income.display_name AS desired_monthly_income_name
        ,worker.operation_date
        ,DATE_FORMAT(worker.operation_date,\'%Y年%m月%d日\') AS operation_date_jp
        ,DATE_FORMAT(worker.operation_date,\'%Y/%m/%d\') AS operation_date_display
        ,DATE_FORMAT(worker.create_date,\'%Y/%m/%d\') AS create_date_display
        ,job.job_id
        ,job.job_name
        ,job_category.abbreviated_name AS job_category_abbreviated_name
        ,contract_type.code AS contract_type_id
        ,contract_type.display_name AS contract_type_name
        ,GROUP_CONCAT(DISTINCT prefecture.prefecture_name) AS desired_workingplace_names
        ,wj.desired_job_id
        ,GROUP_CONCAT(DISTINCT job.job_name) AS job_names
        ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
        ,GROUP_CONCAT(DISTINCT job_category.abbreviated_name) AS job_category_abbreviated_names
        ,GROUP_CONCAT(DISTINCT ex_skill_table.ex_skill_name) AS skill_and_experience
        ,CASE
          WHEN reviews.review_rating IS NULL THEN 3
          ELSE TRUNCATE(reviews.review_rating, 1)
        END AS review_rating
        ,worker.worker_manager_id
        ,CONCAT(user_company.last_name, user_company.first_name) AS full_name
        ,worker.agent_comment
        ,user_company.logo_image as user_company_logo_image
    ';
    if (isset($search['user_company_id'])) {
      $select .= ',CASE
      WHEN ucf.user_company_id IS NULL THEN 0
      ELSE 1
      END AS favorite
      ,ucmstw.matching_score
      ';
      $user_company_id = $search['user_company_id'];
    } else {
      $user_company_id = 0;
    }

    $sub_query = "(
        SELECT
            worker_id,
            AVG(review_rating) as review_rating
        FROM
            `worker_reviews`
        WHERE
            del_flag = 0
        GROUP BY
            worker_id )

    ";

    // スキル経験年数のテーブルを作成
    $ex_skill_query = "
    (SELECT CONCAT(ex_skills.skill_name, ':', ex_skills.display_name) as ex_skill_name, worker_id
      FROM (
      SELECT skill_name, display_name, worker_id
      FROM worker_skill AS ws
      LEFT JOIN m_skill AS ms
      ON ws.skill_id  = ms.skill_id
      LEFT JOIN m_code
      ON ws.experience_id = m_code.code
      WHERE m_code.category = 'ex_skill'
      ) AS ex_skills
    ) AS ex_skill_table";

    $data = DB::table('worker')
      ->select(DB::RAW($select))
      ->leftjoin('user_engineer AS ue', "ue.user_engineer_id", "=", "worker.user_engineer_id")
      ->leftjoin('worker_skill AS skill', "skill.worker_id", "=", "worker.worker_id")
      ->leftjoin('m_skill AS m_skill', "skill.skill_id", "=", "m_skill.skill_id")
      ->leftjoin('m_code AS contract_type', function ($join) {
        $join->on("worker.desired_contract_type", "=", "contract_type.code")->where('contract_type.category', '=', config('const.CATEGORY')['CONTRACT_TYPE']);
      })
      ->leftjoin('m_code AS desired_monthly_income', function ($join) {
        $join->on("worker.desired_monthly_income", "=", "desired_monthly_income.code")->where('desired_monthly_income.category', '=', config('const.CATEGORY')['MONTHLY_INCOME']);
      })
      ->leftjoin('worker_desired_workingplace AS ww', 'worker.worker_id', "=", "ww.worker_id")
      ->leftjoin('worker_desired_job AS wj', 'worker.worker_id', "=", "wj.worker_id")
      ->leftjoin('m_job AS job', 'wj.desired_job_id', "=", "job.job_id")
      ->leftjoin('m_job_category AS job_category', 'job.job_category_id', "=", "job_category.job_category_id")
      ->leftjoin('m_prefecture AS prefecture', 'ww.prefecture_id', "=", "prefecture.prefecture_id")
      ->leftjoin('user_company', 'worker.worker_manager_id', "=", "user_company.user_company_id")
      ->leftjoin('company', 'user_company.company_id', "=", "company.company_id")
      ->leftjoin('user_company_favorite AS ucf', function ($join) use ($user_company_id) {
        $join->on('ucf.target_id', '=', 'worker.worker_id')->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['WORKER']);
      })
      ->leftjoin('user_company_matching_score_to_worker AS ucmstw', function ($join) use ($user_company_id) {
        $join->on('ucmstw.worker_id', '=', 'worker.worker_id')->where('ucmstw.user_company_id', '=', $user_company_id);
      })
      ->leftjoin(DB::RAW($sub_query . "as reviews"), "reviews.worker_id", "worker.worker_id")
      ->leftjoin(DB::RAW($ex_skill_query), "ex_skill_table.worker_id", "worker.worker_id")
      ->where(function ($where) {
        $where->whereNull('company.company_id')->orWhere('company.del_flag', 0);
      })
      ->where(function ($where) {
        $where->whereNull('company.company_id')->orWhere('company.release_flag', 1);
      })
      ->where(function ($query) {
        $query->whereNull('ue.registration_phase')->orWhere('ue.registration_phase', 0);
      })
      ->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['WORKER'])
      ->where('worker.del_flag', 0);


    $data = $data->groupby("worker.worker_id");

    $disp_num = config('const.DEFAULT_SEARCH_COUNT')['GENERAL'];

    //全体の合計数を取得

    if (array_key_exists("where", $search)) {
      $data = $data->paginate();
    } else {
      $data = $data->paginate($disp_num);
    }

    return $data;
  }

  public static function getFavoriteWorker($user_company_id)
  {
    $select = "ucf.target_id AS worker_id
              ,worker.initial_name AS initial_name
              ,worker.logo_image AS worker_image
              ,DATE_FORMAT(ucf.update_date,'%Y年%m月%d日') as update_date
              ";

    $data = DB::table('user_company_favorite AS ucf')
          ->select(DB::raw($select))
          ->leftjoin('worker', 'ucf.target_id', '=', 'worker.worker_id')
          ->where('ucf.user_company_id', $user_company_id)
          ->where('ucf.target_type', config('const.FAVORITE_TARGET_TYPE')['WORKER'])
          ->orderBy('ucf.update_date', 'desc');

    return $data->get();
  }

  public static function getFavoriteUserCompany($user_company_id)
  {
    $select = "ucf.target_id AS user_company_id
              ,CONCAT(uc.last_name, uc.first_name) AS full_name
              ,uc.logo_image AS logo_image
              ,DATE_FORMAT(ucf.update_date,'%Y年%m月%d日') as update_date
              ";

    $data = DB::table('user_company_favorite AS ucf')
          ->select(DB::raw($select))
          ->leftjoin('user_company AS uc', 'ucf.target_id', '=', 'uc.user_company_id')
          ->where('ucf.user_company_id', $user_company_id)
          ->where('ucf.target_type', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY'])
          ->orderBy('ucf.update_date', 'desc');

    return $data->get();
  }

  public static function insertFavorite($data)
  {
    try{
      DB::table('user_company_favorite')->insert([
      'user_company_id' => $data['user_company_id'],
      'target_type' => $data['target_type'],
      'target_id' => $data['target_id'],
    ]);
    }catch(\Exception $e){
      throw $e;
    }
    return true;
  }
  // 企業からのお気に入り数を取得
  public static function getCountFavoriteWorker($worker_id)
  {
    $select = 'DATE_FORMAT(u.update_date, \'%Y-%m-%d\') AS date, COUNT(*) AS count';
    $data = DB::table('user_company_favorite AS u')

          ->select(DB::RAW($select))
          ->leftjoin('worker AS w', 'u.target_id', '=', 'w.worker_id')
          ->where('target_type', '=', config('const.FAVORITE_TARGET_TYPE')['WORKER'])
          ->where('target_id', '=', $worker_id)
          ->groupBy(DB::raw("DATE_FORMAT(u.update_date, '%Y%m%d')"))
          ->orderby('u.update_date','DESC');


    if($data->count()) {
      return $data;
    }

    return false;
  }

  public static function deleteFavorite($data)
  {
    try{
      \DB::table('user_company_favorite')
            ->where('user_company_id', $data['user_company_id'])
            ->where('target_type', $data['target_type'])
            ->where('target_id', $data['target_id'])->delete();
    }catch(\Exception $e){
      throw $e;
    }
    return true;
  }

  public static function getCountMonthlyFavorite($worker_id, $month_ago = null)
  {
    $select = '
        COUNT(*) AS count
    ';

    $data = DB::table('user_company_favorite AS ucf')
            ->select(DB::RAW($select))
            ->leftjoin('worker AS w','ucf.target_id', "=", "w.worker_id")
            ->where('w.worker_id', '=', $worker_id)
            ->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['WORKER'])

    ;
    if(isset($month_ago) && $month_ago > 0) {
      $data = $data->whereRaw('
                                ucf.update_date 
                                BETWEEN DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . -$month_ago . ' MONTH), "%Y-%m-01")
                                AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . (-$month_ago + 1) . ' MONTH), "%Y-%m-01")
                              ');
    } elseif(isset($month_ago) && $month_ago === 0) {
      $data = $data->whereRaw('
                              ucf.update_date
                              BETWEEN DATE_FORMAT(CURDATE(), "%Y-%m-01")
                              AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . 1 . ' MONTH), "%Y-%m-01")
                            ');
    }

    $data = $data->groupBy('worker_id')->get();
    if(isset($data[0])) {
      return $data[0]->count;
    } else {
      return 0;
    }

  }

}
