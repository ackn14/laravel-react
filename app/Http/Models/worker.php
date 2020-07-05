<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker extends Model
{
  static $worker_count = null;
  static $worker_disp_count = null;
  protected $table = 'worker';
  protected $guarded = ['worker_id'];
  public $timestamps = false;

  /*
   * 人材一覧取得
   */
  public static function get($search = array(), $limit = null, $loginInfo = null)
  {

    $select = '
        worker.worker_id
        ,ue.user_engineer_id
        ,worker.worker_type
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
        ,worker.movie
        ,worker.del_flag
        ,worker.desired_monthly_income AS desired_monthly_income_id
        ,desired_monthly_income.display_name AS desired_monthly_income_name
        ,worker.operation_date
        ,DATE_FORMAT(worker.operation_date,\'%Y年%m月%d日\') AS operation_date_jp
        ,DATE_FORMAT(worker.operation_date,\'%Y/%m/%d\') AS operation_date_display
        ,CASE
          WHEN worker.operation_date IS NULL THEN ""
          WHEN worker.operation_date > DATE_FORMAT((NOW() - INTERVAL 1 YEAR), \'%Y-%m-%d\') THEN DATE_FORMAT(worker.operation_date,\'%m/%d\')
          ELSE "old"
        END AS operation_date_short
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
        ,m_station.line_name AS train_line_name
        ,m_station.station_name AS station_name
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
            ->leftjoin('m_station AS m_station', "m_station.station_id", "=", "worker.nearest_station")
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
            ->where(function($where) use($search) {
              $where->whereNull('company.company_id')->orWhere(function($where) use($search) {
                if(array_key_exists('manage_flag', $search) && $search['manage_flag']) {
                  $where->where('company.del_flag', 0);
                } else {
                  $where->where('company.del_flag', 0)->where('company.release_flag', 1);
                }
              });
            })
            ->where(function($query) {
              $query->whereNull('ue.registration_phase')->orWhere('ue.registration_phase', 0);
            })
            ->where('worker.del_flag', 0);


    // お気に入り人材表示
    if (isset($search['favoriteListFlag'])) {
      $data = $data->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['WORKER']);
    }

    // お気に入りしてくれた人材表示
    if (isset($search['favoritedListFlag'])) {
      $data = $data->join('worker_favorite as wf', 'wf.worker_id', '=', "worker.worker_id");
      $data = $data->where('wf.target_id', '=', $user_company_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
    }

    //エントリーしてくれた人材取得
    if (isset($search['entryListFlag'])) {
      $data = $data->join('offer', 'offer.worker_id', '=', "worker.worker_id");
      $data = $data->join('project', 'project.project_id', '=', "offer.project_id");
      $data = $data->where('project.project_manager_id', '=', $user_company_id);
    }

    //オファーした人材人材取得
    if (isset($search['offerListFlag'])) {
      $data = $data->join('offer_to_worker', 'offer_to_worker.worker_id', '=', "worker.worker_id");
      $data = $data->where('offer_to_worker.user_company_id', '=', $user_company_id);
    }

    if (isset($loginInfo['admin_flag'])) {
      if (!(array_key_exists("manage_flag", $search) && $search['manage_flag'] == 1) && ($loginInfo['admin_flag'] == 0 || intval($loginInfo['admin_flag']) != 1)) {
        //エイト以外の企業アカウントの場合は公開人材のみを表示する
        $data = $data->where('worker.release_flag', 1);
      }
    } else {
      $data = $data->where('worker.release_flag', 1);
    }

    // フリーワード検索
    if (array_key_exists("searchKeyword", $search) && $search['searchKeyword']) {
      $keywords = $search['searchKeyword'];
      if (is_string($keywords)) {
        $keywords = preg_split("/\s+/u", trim(mb_convert_kana($search['searchKeyword'], 's')));
      }
      foreach ($keywords as $index => $keyword) {
        $data = $data->where(function ($data) use ($keyword) {
          $data->orWhere('worker.self_introduction', 'like', '%' . $keyword . '%')
            ->orWhere('worker.nearest_station', 'like', '%' . $keyword . '%')
            ->orWhere('worker.initial_name', 'like', '%' . $keyword . '%')
            ->orWhere('m_skill.skill_name', 'like', '%' . $keyword . '%')
            ->orWhere('job.job_name', 'like', '%' . $keyword . '%')
            ->orWhere('contract_type.display_name', 'like', '%' . $keyword . '%')
            ->orWhere('prefecture.prefecture_name', 'like', '%' . $keyword . '%');
        });
      }
    }

    // // 職種指定がある場合
    // if(array_key_exists("job_id",$search) && $search['job_id']){
    //     $data = $data->leftjoin('worker_desired_job', 'worker.worker_id', '=', 'worker_desired_job.worker_id')
    //         ->where('worker_desired_job.desired_job_id',$search['job_id']);
    // }
    // 職種指定がある場合(複数)
    if (array_key_exists("job_id", $search) && $search['job_id']) {
      $id = $search['job_id'];
      $data = $data->leftjoin('worker_desired_job', 'worker.worker_id', '=', 'worker_desired_job.worker_id')
        ->where(function ($data) use ($id) {
          $data->orWhereIn('worker_desired_job.desired_job_id', $id);
        });
    }

    // 勤務地指定がある場合
    if (array_key_exists("prefecture_id", $search) && $search['prefecture_id']) {
      $data = $data->leftjoin('worker_desired_workingplace', 'worker.worker_id', '=', 'worker_desired_workingplace.worker_id')
        ->where('worker_desired_workingplace.prefecture_id', $search['prefecture_id']);
    }
    // // 勤務地指定がある場合（複数）
    // if(array_key_exists("prefecture_id",$search) && $search['prefecture_id']){
    //     $id = $search['prefecture_id'];
    //     $data = $data->leftjoin('worker_desired_workingplace', 'worker.worker_id', '=', 'worker_desired_workingplace.worker_id')
    //                  ->where(function ($data) use ($id) {
    //                              $data->orWhereIn('worker_desired_workingplace.prefecture_id', $id);
    //     });
    // }

    // 雇用形態指定がある場合
    if (array_key_exists("contract_type", $search) && $search['contract_type']) {
      // $data = $data->where('worker.desired_contract_type', $search['contract_type']);
      if(is_array($search['contract_type'])) {
        $data = $data->where(function($query) use($search) {
          foreach($search['contract_type'] AS $code) {
            $query->orWhereRaw('FIND_IN_SET(?, worker.desired_contract_type)', $code);
          }
        });
      }
      // 複数対応
      $data = $data->whereIn('worker.desired_contract_type', $search['contract_type']);
    }

    // 投稿日指定がある場合
    if (array_key_exists("post_date", $search) && $search['post_date']) {
      if ($search['post_date'] == '1') {
        $data = $data->whereRaw("DATE_ADD(worker.create_date, INTERVAL 24 HOUR) > NOW()");
      } elseif ($search['post_date'] == '2') {
        $data = $data->whereRaw("DATE_ADD(worker.create_date, INTERVAL 7 DAY) > NOW()");
      } elseif ($search['post_date'] == '3') {
        $data = $data->whereRaw("DATE_ADD(worker.create_date, INTERVAL 14 DAY) > NOW()");
      } elseif ($search['post_date'] == '4') {
        $data = $data->whereRaw("DATE_ADD(worker.create_date, INTERVAL 30 DAY) > NOW()");
      }
    }

    // 開始日指定
    if (array_key_exists("start_date", $search) && $search['start_date']) {
      if ($search['start_date'] == '1') {
        $data = $data->whereRaw("worker.operation_date <= NOW()");
      } elseif ($search['start_date'] == '2') {
        $data = $data->whereRaw("DATE_ADD(worker.operation_date, INTERVAL - 7 DAY) >= NOW()");
      } elseif ($search['start_date'] == '3') {
        $data = $data->whereRaw("DATE_ADD(worker.operation_date, INTERVAL - 14 DAY) >= NOW()");
      } elseif ($search['start_date'] == '4') {
        $data = $data->whereRaw("DATE_ADD(worker.operation_date, INTERVAL - 1 MONTH) >= NOW()");
      } elseif ($search['start_date'] == '5') {
        $data = $data->whereRaw("DATE_ADD(worker.operation_date, INTERVAL - 2 MONTH) >= NOW()");
      } elseif ($search['start_date'] == '6') {
        $data = $data->whereRaw("DATE_ADD(worker.operation_date, INTERVAL - 3 MONTH) >= NOW()");
      }
    }

    //単金検索
    if (array_key_exists("desired_monthly_income", $search) && $search['desired_monthly_income']) {
      $data = $data->whereIn('worker.desired_monthly_income', $search['desired_monthly_income']);
    }

    // 希望最低年収指定がある場合
    //    if (array_key_exists("income_min", $search) && $search['income_min'] == config('const.MONTHLY_INCOME')['MIN'] && array_key_exists("income_max", $search) && $search['income_max'] == config('const.MONTHLY_INCOME')['MAX']) {
    //
    //    } else {
    //      if (array_key_exists("income_min", $search) && $search['income_min']) {
    //        $data = $data->where('worker.desired_monthly_income', '>=', (int)$search['income_min']);
    //      }
    //
    //      // 希望最高年収指定がある場合
    //      if (array_key_exists("income_max", $search) && $search['income_max']) {
    //        $data = $data->where('worker.desired_monthly_income', '<=', (int)$search['income_max']);
    //      }
    //    }

    /*
     * 管理画面用ロジック(自社人材のみ表示)
     */
    if (array_key_exists("manage_flag", $search) && $search['manage_flag'] == 1) {
      if ($loginInfo['company_id'] == config('const.EIGHT_COMPANY_ID')) {
        $data = $data->where(function ($data) use ($loginInfo) {
          $data->where('company.company_id', $loginInfo['company_id'])
            ->orWhereNull('worker_manager_id');
        });
        //$data = $data->where('company.company_id', $loginInfo['company_id']);
      } else {

        $data = $data->where('company.company_id', $loginInfo['company_id']);
      }
    }

    // スキル指定がある場合
    if (array_key_exists("skill_id", $search) && $search['skill_id']) {
      $keyword = $search['skill_id'];
      $data = $data->leftjoin('worker_skill', 'worker.worker_id', '=', 'worker_skill.worker_id')
        ->where(function ($data) use ($keyword) {
          $data->orWhere('worker_skill.skill_id', $keyword);
        });
    }
    $data = $data->groupby("worker.worker_id");

    //検索件数指定
    if ($limit != null) {
      $data = $data->limit($limit);
    }
    $data = $data->groupby("worker.worker_id");

    //ソート順が指定されている場合
    if (isset($search["sort"])) {
      if ($search["sort"] == "new") {
        $data = $data->orderby('worker.update_date', 'desc');
      } elseif ($search['sort'] == 'create') {
        $data = $data->orderby('worker.create_date', 'desc');
      } elseif ($search['sort'] == 'pickup') {
        $data = $data->orderby('ucmstw.matching_score', 'desc')->orderby('reviews.review_rating', 'desc');
      } else {
        $data = $data->orderby('worker.release_date', 'desc');
      }
    } else {
      $data = $data->orderby('worker.update_date', 'desc');
    }

    $disp_num = config('const.DEFAULT_SEARCH_COUNT')['GENERAL'];

    //全体の合計数を取得
    self::$worker_count = $data->count();

    if (array_key_exists("where", $search)) {
      $data = $data->paginate();
    } else {
      $data = $data->paginate($disp_num);
    }

    self::$worker_disp_count = $data->count();

    return $data;
  }

  /*
   * ユーザー登録
   */
  public static function insertWorkerForSignUp($data)
  {
    // workerテーブルに人材情報を登録

    DB::table('worker')->insert([
      'user_engineer_id' => $data['user_engineer_id'],
      'email' => $data['email'],
    ]);
    return DB::getPdo()->lastInsertId();
  }

  /*
   * プロフィール用に情報取得
   */
  public static function getProfile($user_engineer_id)
  {
    // 指定のuser_engineer_idの人材情報をworkerテーブル等から取得
    $select = '
         w.worker_id
        ,w.logo_image
        ,w.cover_image
        ,w.resume
        ,w.skill_sheet
        ,w.other_resume
        ,w.email
        ,w.phone_number
        ,w.last_name
        ,w.first_name
        ,w.last_name_ruby
        ,w.first_name_ruby
        ,w.birthday
        ,w.age
        ,w.initial_name
        ,w.skill_description
        ,w.sex
        ,w.prefecture_id
        ,w.city_id
        ,w.desired_contract_type
        ,w.nearest_station
        ,w.operation_date
        ,w.school_name
        ,w.final_education
        ,w.educational_background_detail
        ,w.release_flag
        ,DATE_FORMAT(w.graduate_date,\'%Y-%m\') AS graduate_date
        ,w.self_introduction
        ,w.age
        ,w.birthday
        ,w.sex
        ,CASE
           WHEN w.sex = 0 THEN \'非公開\'
           WHEN w.sex = 1 THEN \'男性\'
           WHEN w.sex = 2 THEN \'女性\'
           ELSE \'非公開\'
         END AS sex_str
        ,w.current_monthly_income
        ,w.desired_monthly_income
        ,ww.prefecture_id AS desired_working_place1
        ,nearest_station.line_id AS train_line_id
        ,prefecture.prefecture_name
        ,nearest_station.line_name AS train_line_name
        ,nearest_station.station_name AS station_name
      ';

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->leftjoin('worker_desired_workingplace AS ww', 'w.worker_id', "=", "ww.worker_id")
      ->leftjoin('user_engineer AS ue', 'w.user_engineer_id', "=", "ue.user_engineer_id")
      ->leftjoin('m_prefecture AS prefecture', 'w.prefecture_id', "=", "prefecture.prefecture_id")
      ->leftjoin('m_station AS nearest_station', 'w.nearest_station', "=", "nearest_station.station_id")
      ->where('w.user_engineer_id', $user_engineer_id)
      ->where('w.del_flag', '0');

    if (!$data->exists()) {
      return null;
    }

    $data = $data->get();

    // 希望勤務地が複数ある場合セット
    if (isset($data[1]) && isset($data[1]->desired_working_place1)) {
      $data[0]->desired_working_place2 = $data[1]->desired_working_place1;
    } else {
      $data[0]->desired_working_place2 = '';
    }

    return $data[0];
  }

  /*
   * 人材詳細を取得
   */
  public static function getWorkerDetail($worker_id, $user_company_id = 0)
  {
    // 指定のworker_idの人材情報をworkerテーブル等から取得
    $select = '
        w.worker_id
        ,w.user_engineer_id
        ,w.worker_type
        ,w.belongs_company_id
        ,w.logo_image
        ,w.cover_image
        ,w.resume
        ,w.skill_sheet
        ,w.other_resume
        ,w.email
        ,w.phone_number
        ,w.last_name
        ,w.first_name
        ,w.last_name_ruby
        ,w.first_name_ruby
        ,w.prefecture_id
        ,w.city_id
        ,w.address
        ,w.desired_contract_type
        ,w.nearest_station
        ,w.skill_description
        ,w.operation_date
        ,w.school_name
        ,w.final_education
        ,w.educational_background_detail
        ,w.release_date
        ,w.graduate_date
        ,DATE_FORMAT(w.birthday,\'%Y年%m月%d日\') AS birthday_jp
        ,DATE_FORMAT(w.graduate_date,\'%Y年%m月\') AS graduate_date_jp
        ,DATE_FORMAT(w.operation_date,\'%Y年%m月%d日\') AS operation_date_jp
        ,w.movie
        ,w.movie_public_flag
        ,w.self_introduction
        ,w.initial_name
        ,w.sex
        ,w.birthday
        ,w.age
        ,w.current_monthly_income
        ,w.desired_monthly_income
        ,w.worker_manager_id
        ,w.agent_comment AS agent_comment
        ,uc.last_name AS agent_last_name
        ,uc.first_name AS agent_first_name
        ,uc.logo_image AS agent_logo_image
        ,company.company_name
        ,desired_monthly_income.display_name AS desired_monthly_income_jp
        ,desired_monthly_income.col_2 AS desired_monthly_income_min
        ,desired_monthly_income.col_3 AS desired_monthly_income_max
        ,w.initial_name
        ,CASE
          WHEN w.sex = 0 THEN \'非公開\'
          WHEN w.sex = 1 THEN \'男性\'
          WHEN w.sex = 2 THEN \'女性\'
          ELSE \'非公開\'
        END AS sex_str
        ,prefecture.prefecture_name
        ,city.city_name
        ,worker_previews.previews
        ,nearest_station.line_id AS train_line_id
        ,nearest_station.line_name AS train_line_name
        ,nearest_station.station_name AS station_name
        ,ue.mail_receiving_flag
      ';

    if ($user_company_id !== 0) {
      $select .= '
        ,ucmstw.matching_score
        ,CASE
          WHEN ucf.target_id IS NULL THEN 0
          ELSE 1
        END AS favorite
      ';
    }

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->leftjoin('user_engineer AS ue', 'w.user_engineer_id', "=", "ue.user_engineer_id")
      ->leftjoin('user_company AS uc', 'w.worker_manager_id', "=", "uc.user_company_id")
      ->leftjoin('company AS company', 'w.belongs_company_id', "=", "company.company_id")
      ->leftjoin('m_prefecture AS prefecture', 'w.prefecture_id', "=", "prefecture.prefecture_id")
      ->leftjoin('m_city AS city', 'w.city_id', "=", "city.city_id")
      ->leftjoin('m_station AS nearest_station', 'w.nearest_station', "=", "nearest_station.station_id")
      ->leftjoin('worker_previews', 'w.worker_id', '=', 'worker_previews.worker_id')
      ->leftjoin('user_company_matching_score_to_worker AS ucmstw', function ($join) use ($user_company_id) {
        $join->on('ucmstw.worker_id', '=', 'w.worker_id')->where('ucmstw.user_company_id', '=', $user_company_id);
      })
      ->leftjoin('user_company_favorite AS ucf', function ($join) use ($user_company_id) {
        $join->on('ucf.target_id', '=', 'w.worker_id')->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', config('const.FAVORITE_TARGET_TYPE')['WORKER']);
      })
      ->leftjoin('m_code AS desired_monthly_income', function ($join) {
        $join->on("w.desired_monthly_income", "=", "desired_monthly_income.code")
          ->where('desired_monthly_income.category', '=', config('const.CATEGORY')['MONTHLY_INCOME']);
      })
      ->where('w.worker_id', $worker_id)
      ->where('w.del_flag', '0')
      ->get();

    // 希望勤務地が複数ある場合セット
    if (isset($data[1]) && isset($data[1]->desired_working_place1)) {
      $data[0]->desired_working_place2 = $data[1]->desired_working_place1;
    } else {
      $data[0]->desired_working_place2 = '';
    }

    return $data[0];
  }

  /*
   * worker_manager_id(user_company_id)から人材一覧取得
   */
  public static function getWorkerByManagerId($manager_id, $admin_flag = 0, $limit = null)
  {

    $select = '
        worker.worker_id
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
        ,DATE_FORMAT(worker.operation_date,\'%Y年%m月%d日\') AS operation_date
        ,DATE_FORMAT(worker.create_date,\'%Y年%m月%d日\') AS create_date
        ,job.job_id
        ,job.job_name
        ,contract_type.code AS contract_type_id
        ,contract_type.display_name AS contract_type_name
        ,GROUP_CONCAT(DISTINCT prefecture.prefecture_name) AS desired_workingplace_names
        ,wj.desired_job_id
        ,GROUP_CONCAT(DISTINCT job.job_name) AS job_names
        ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
        ,GROUP_CONCAT(DISTINCT ex_skill_table.ex_skill_name) AS skill_and_experience
        ,CASE
          WHEN reviews.review_rating IS NULL THEN 3
          ELSE TRUNCATE(reviews.review_rating, 1)
        END AS review_rating
    ';

    $sub_query = "(
      SELECT
        worker_id,
        AVG(review_rating) as review_rating
      FROM
        `worker_reviews`
      WHERE
        del_flag = 0
      GROUP BY
        worker_id)";

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
      ->leftjoin('m_prefecture AS prefecture', 'ww.prefecture_id', "=", "prefecture.prefecture_id")
      ->leftjoin('user_company_favorite AS ucf', function ($join) use ($manager_id) {
        $join->on('ucf.target_id', '=', 'worker.worker_id')->where('ucf.user_company_id', '=', $manager_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['WORKER']);
      })
      ->leftjoin(DB::RAW($sub_query . "as reviews"), "reviews.worker_id", "worker.worker_id")
      ->leftjoin(DB::RAW($ex_skill_query), "ex_skill_table.worker_id", "worker.worker_id")
      ->where('worker.worker_manager_id', $manager_id)
      ->where('worker.del_flag', 0);

    if ($admin_flag == 0) {
      $data = $data->where('release_flag', 1);
    }

    $data = $data->groupby('worker.worker_id')->orderBy('create_date', 'desc');

    $data = $data->paginate(8);

    return $data;
  }

  /*
   *
   */
  public static function getWorkerIdByUserEngineerId($user_engineer_id)
  {
    // 指定のuser_engineer_idの人材情報をworkerテーブル等から取得
    $select = 'w.worker_id';

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->where('w.user_engineer_id', $user_engineer_id)
      ->where('w.del_flag', '0')
      ->get();
    if (count($data) <= 0) {
      return false;
    }
    return $data[0]->worker_id;
  }

  public static function getWorker($worker_id)
  {

    $select = 'worker_id,initial_name,last_name,email,user_engineer_id';

    $data = DB::table('worker')
      ->select(DB::raw($select))
      ->where('worker_id', $worker_id)
      ->where('del_flag', '0');

    $data = $data->get();

    if (count($data) <= 0) {
      return false;
    }

    return $data[0];
  }

  /*
   * 履歴書のファイル名取得
   */
  public static function getResumeName($worker_id)
  {
    // 指定のworker_idの履歴書のファイル名をworkerテーブルから取得
    $select = 'w.resume';

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->where('w.worker_id', $worker_id)
      ->where('w.del_flag', '0')
      ->get();

    return $data[0];
  }

  public static function getPrevResumeName($one_time_token)
  {
    // 指定のworker_idの履歴書のファイル名をworkerテーブルから取得
    $select = 'pre_signup.resume';

    $data = DB::table('pre_signup')
      ->select(DB::RAW($select))
      ->where('pre_signup.one_time_token', $one_time_token)
      ->get();

    return $data[0];
  }

  /*
   * スキルシートのファイル名取得
   */
  public static function getSkillSheetName($worker_id)
  {
    // 指定のworker_idのスキルシートのファイル名をworkerテーブルから取得
    $select = 'w.skill_sheet';

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->where('w.worker_id', $worker_id)
      ->where('w.del_flag', '0')
      ->get();

    return $data[0];
  }

  public static function getPrevSkillSheetName($one_time_token)
  {
    // 指定のworker_idのスキルシートのファイル名をworkerテーブルから取得
    $select = 'pre_signup.skill_sheet';

    $data = DB::table('pre_signup')
      ->select(DB::RAW($select))
      ->where('pre_signup.one_time_token', $one_time_token)
      ->get();

    return $data[0];
  }

  /*
   * その他履歴書のファイル名取得
   */
  public static function getOtherResumeName($worker_id)
  {
    // 指定のworker_idのその他履歴書のファイル名をworkerテーブルから取得
    $select = 'w.other_resume';

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->where('w.worker_id', $worker_id)
      ->where('w.del_flag', '0')
      ->get();

    return $data[0];
  }

  public static function getPrevOtherResumeName($one_time_token)
  {
    // 指定のworker_idのその他履歴書のファイル名をworkerテーブルから取得
    $select = 'pre_signup.other_resume';

    $data = DB::table('pre_signup')
      ->select(DB::RAW($select))
      ->where('pre_signup.one_time_token', $one_time_token)
      ->get();

    return $data[0];
  }

  /*
   * 更新
   */
  public static function up($data)
  {
    try {
      \DB::table('worker')->where("worker_id", $data['worker_id'])
        ->update($data);
    } catch (\Exception $e) {
      throw $e;
    }
    return true;
  }

  /*
  * 追加
  */
  public static function insertWorker($data)
  {
    try {
      \DB::table('worker')->insert($data);
      return DB::getPdo()->lastInsertId();
    } catch (\Exception $e) {
      throw $e;
    }
  }

  /*
   * ロゴ画像用ファイル名登録
   */
  public static function logoImgInsert($email, $data)
  {
    DB::table('pre_signup')
      ->where('email', $email)
      ->lockForUpdate()
      ->update(['logo_image' => $data]);
  }

  public static function logoImgUpdateWorker($worker_id, $logoFileName)
  {
    DB::table('worker')
      ->where('worker_id', $worker_id)
      ->lockForUpdate()
      ->update(['logo_image' => $logoFileName]);
  }

  public static function coverImgUpdateWorker($worker_id, $coverFileName)
  {
    DB::table('worker')
      ->where('worker_id', $worker_id)
      ->lockForUpdate()
      ->update(['cover_image' => $coverFileName]);
  }

  /*
   * 履歴書名登録
   */
  public static function resumeInsert($email, $data)
  {
    DB::table('pre_signup')
      ->where('email', $email)
      ->lockForUpdate()
      ->update(['resume' => $data]);
  }

  public static function resumeUpdateWorker($worker_id, $resumeFileName)
  {
    DB::table('worker')
      ->where('worker.worker_id', $worker_id)
      ->lockForUpdate()
      ->update(['resume' => $resumeFileName]);
  }

  /*
   * スキルシート名登録
   */
  public static function skillSheetInsert($email, $data)
  {
    DB::table('pre_signup')
      ->where('email', $email)
      ->lockForUpdate()
      ->update(['skill_sheet' => $data]);
  }

  public static function skillSheetUpdateWorker($worker_id, $skillSheetFileName)
  {
    DB::table('worker')
      ->where('worker.worker_id', $worker_id)
      ->lockForUpdate()
      ->update(['skill_sheet' => $skillSheetFileName]);
  }

  /*
   * その他資料名登録
   */
  public static function otherResumeInsert($email, $data)
  {
    DB::table('pre_signup')
      ->where('email', $email)
      ->lockForUpdate()
      ->update(['other_resume' => $data]);
  }

  public static function otherResumeUpdateWorker($worker_id, $otherResumeFileName)
  {
    DB::table('worker')
      ->where('worker.worker_id', $worker_id)
      ->lockForUpdate()
      ->update(['other_resume' => $otherResumeFileName]);
  }

  /*
   * 動画登録
   */
  public static function movieUpdateWorker($worker_id, $data)
  {
    DB::table('worker')
      ->where('worker.worker_id', $worker_id)
      ->lockForUpdate()
      ->update(['movie' => $data['movie'], 'movie_public_flag' => $data['movie_public_flag']]);
  }

  /*
   * 動画名取得
   */
  public static function getMovieName($worker_id){
    // 指定のworker_idのその他履歴書のファイル名をworkerテーブルから取得
    $select = 'movie';

    $data = DB::table('worker')
            ->select(DB::RAW($select))
            ->where('del_flag', 0)
            ->get();

    if(count($data) <= 0){
      return false;
    }

    return $data[0];
  }

  /*
   * 案件にある条件
   */
  public static function getProjectConditionMatchWorker($project_id)
  {

    $sql = '
      SELECT *
      FROM (
              SELECT DISTINCT worker.user_engineer_id
              FROM (
                      SELECT project.*
                            ,ps.skill_id
                            ,company.business_type
                      FROM project
                      LEFT JOIN project_skill AS ps
                             ON project.project_id = ps.project_id
                      LEFT JOIN company
                             ON project.company_id = company.company_id
                      WHERE project.project_id = ?
              ) AS project
              CROSS JOIN (
                      SELECT worker.worker_id
                            ,ue.user_engineer_id
                            ,COUNT(con.category = "contract_type" OR NULL) AS contract_type_count
                            ,COUNT(con.category = "prefecture_id" OR NULL) AS prefecture_id_count
                            ,COUNT(con.category = "skill_id" OR NULL) AS skill_id_count
                            ,COUNT(con.category = "business_type" OR NULL) AS business_type_count
                            ,COUNT(con.category = "job_id" OR NULL) AS job_id_count
                      FROM worker
                      JOIN user_engineer AS ue
                        ON worker.user_engineer_id = ue.user_engineer_id
                      LEFT JOIN search_project_condition AS con
                        ON con.user_engineer_id = worker.user_engineer_id
                      GROUP BY worker.worker_id
              ) AS worker
              WHERE (
                      project.prefecture_id IN (
                              SELECT code
                              FROM search_project_condition AS con
                              WHERE con.user_engineer_id = worker.user_engineer_id
                              AND con.category = "prefecture_id"
                      )
                      OR worker.prefecture_id_count = 0
              )
              AND (
                      project.contract_type in (
                              SELECT code
                              FROM search_project_condition AS con
                              WHERE con.user_engineer_id = worker.user_engineer_id
                              AND con.category = "contract_type"
                      )
                      OR worker.contract_type_count = 0
              )
              AND (
                      project.skill_id in (
                              SELECT code
                              FROM search_project_condition AS con
                              WHERE con.user_engineer_id = worker.user_engineer_id
                              AND con.category = "skill_id"
                      )
                      OR worker.skill_id_count = 0
              )
              AND (
                      project.business_type in (
                              SELECT code
                              FROM search_project_condition AS con
                              WHERE con.user_engineer_id = worker.user_engineer_id
                              AND con.category = "business_type"
                      )
                      OR worker.business_type_count = 0
              )
              AND (
                      project.job_id in (
                              SELECT code
                              FROM search_project_condition AS con
                              WHERE con.user_engineer_id = worker.user_engineer_id
                              AND con.category = "job_id"
                      )
                      OR worker.job_id_count = 0
              )
      ) AS worker_data
      LEFT JOIN worker ON worker.user_engineer_id = worker_data.user_engineer_id
        ';

    $worker = DB::select($sql, [$project_id]);

    return $worker;
  }

  /*
   * 企業ダッシュボード
   */
  public static function getRecommendedWorker($user_company_id = null, $data_limit = null, $view_limit = null)
  {

    $select = '
             w.worker_id
            ,w.initial_name
            ,w.logo_image AS worker_image
            ,3 AS review_rating
            ,DATE_FORMAT(w.release_date,\'%Y年%m月%d日\') as create_date
            ,GROUP_CONCAT(DISTINCT j.job_name) AS job_name
            ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
    ';

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->leftjoin('worker_desired_job AS wdj', 'wdj.worker_id', '=', 'w.worker_id')
      ->leftjoin('m_job AS j', 'j.job_id', '=', 'wdj.desired_job_id')
      ->leftjoin('user_company_matching_score_to_worker AS ucmstw', function ($join) use ($user_company_id) {
        $join->on('ucmstw.worker_id', '=', 'w.worker_id')->where('ucmstw.user_company_id', '=', $user_company_id);
      })
      ->leftjoin('user_company_favorite AS ucf', function ($join) use ($user_company_id) {
        $join->on('ucf.target_id', '=', 'w.worker_id')->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['WORKER']);
      })
      ->leftjoin('worker_skill AS ws', "ws.worker_id", "=", "w.worker_id")
      ->leftjoin('m_skill AS m_skill', "ws.skill_id", "=", "m_skill.skill_id")
      ->where('w.del_flag', 0)
      ->where('w.release_flag', 1)
      ->groupby('w.worker_id')
      ->orderbyRaw('ucmstw.matching_score desc, w.create_date desc');

    // DBから取得する件数を指定
    if (isset($data_limit) && $data_limit) {
      $data = $data->limit($data_limit);
    } else {
      $data = $data->limit(10);
    }

    $data = $data->get();

    // 実際に返す件数を指定
    if (isset($view_limit) && $view_limit) {
      $data = $data->shuffle();
      $data = $data->slice(0, $view_limit);
    }

    return $data;
  }

  /*
   * 企業におすすめ求人
   */
  public static function getRecommendedWorker4dashboard($user_company_id = null, $data_limit = null, $view_limit = null)
  {

    $select = '
             w.worker_id
            ,w.initial_name
            ,w.logo_image AS worker_image
            ,DATE_FORMAT(w.release_date,\'%Y年%m月%d日\') as create_date
    ';

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->leftjoin('user_company_matching_score_to_worker AS ucmstw', function ($join) use ($user_company_id) {
        $join->on('ucmstw.worker_id', '=', 'w.worker_id')->where('ucmstw.user_company_id', '=', $user_company_id);
      })
      ->where('w.del_flag', 0)
      ->where('w.release_flag', 1)
      ->groupby('w.worker_id')
      ->orderbyRaw('ucmstw.matching_score desc, w.create_date desc');

    // DBから取得する件数を指定
    if (isset($data_limit) && $data_limit) {
      $data = $data->limit($data_limit);
    } else {
      $data = $data->limit(10);
    }
    $data = $data->get();

    // 実際に返す件数を指定
    if (isset($view_limit) && $view_limit) {
      $data = $data->shuffle();
      $data = $data->slice(0, $view_limit);
    }

    return $data;
  }

  // 管理人材を取得
  public static function getMyWorkerForAgent($user_company_id)
  {
    $select = "worker.worker_id
              ,worker.initial_name
              ,CONCAT(worker.last_name, worker.first_name) AS full_name
              ";

    $worker = DB::table('worker')
      ->select(DB::raw($select))
      ->where('worker.worker_manager_id', $user_company_id)
      ->where('worker.del_flag', 0)
      ->orderby('worker.create_date', 'desc')
      ->get();

      return $worker;
  }

  // 今月登録した自分の管理人材を取得
  public static function getMyWorkerThisMonth($user_company_id)
  {
    $select = "worker_id
              ";

    $worker = DB::table('worker')
      ->select(DB::raw($select))
      ->whereRaw("DATE_FORMAT(worker.create_date, '%Y-%m-%d') BETWEEN DATE_FORMAT(curdate(), '%Y-%m-01') AND DATE_FORMAT(LAST_DAY(curdate()), '%Y-%m-%d')")
      ->where('worker.worker_manager_id', $user_company_id)
      ->where('worker.del_flag', 0)
      ->orderby('worker.create_date', 'desc')
      ->get();

      return $worker;
  }

  public static function getWorkerRepUser($worker_id)
  {
    $select = "worker.worker_id
              ,worker.initial_name
              ,worker.worker_manager_id
              ,user_engineer.user_engineer_id
              ,user_engineer.email AS user_email
              ";

    $worker = DB::table('worker')
      ->select(DB::raw($select))
      ->leftjoin('user_engineer', 'worker.user_engineer_id', '=', 'user_engineer.user_engineer_id')
      ->where('worker.worker_id', $worker_id)
      ->where('worker.del_flag', 0)
      ->where(function ($query) {
        $query->whereNull('worker.user_engineer_id')
          ->orWhere('user_engineer.del_flag', 0);
      })
      // ->where('user_engineer.del_flag', 0)
      ->orderby('worker.create_date', 'desc')
      ->get();

    if (count($worker) > 0) {
      return $worker[0];
    } else {
      return self::getWorkerRepUser(config('const.EIGHT_WORKER_ID'));
    }
  }

  /*
   * workerに紐付く担当営業及び企業取得
   */
  public static function getRepCompany($worker_id)
  {
    $select = "worker.worker_id
              ,worker.worker_manager_id
              ,company.company_id
              ,user_company.user_company_id
              ";

    $worker = DB::table('worker')
      ->select(DB::raw($select))
      ->leftjoin('user_company', 'worker.worker_manager_id', '=', 'user_company.user_company_id')
      ->leftjoin('company', 'user_company.company_id', '=', 'company.company_id')
      ->where('worker.worker_id', $worker_id)
      ->get();

    if (count($worker) > 0) {
      return $worker[0];
    } else {
      return false;
    }
  }

  /*
 * トータル案件数取得
 */
  public static function totalWorkers()
  {
    $select = '
      count(*) as totalWorkers
    ';

    $data = DB::table('worker AS p')
      ->select(DB::RAW($select))
      ->where('del_flag', '0')
      ->where('release_flag', '1');

    $data = $data->get();

    return $data[0]->totalWorkers;
  }

  /*
 * 特定日時の登録者数取得
 */
  public static function todayRegistWorkers($date)
  {
    $select = 'count(*) as todayRegistWorkers';

    $data = DB::table('worker AS p')
      ->select(DB::RAW($select))
      ->whereBetween('create_date', [$date . " 00:00:00", $date . " 23:59:59"])
      ->where('del_flag', '0')
      ->get();
    return $data[0]->todayRegistWorkers;
  }


  /*
* 非公開人材数取得
*/
  public static function getprivateWorkerCount()
  {
    $select = '
      count(*) as privateworker
    ';

    $data = DB::table('worker AS p')
      ->select(DB::RAW($select))
      ->where('del_flag', '=', '0')
      ->where('release_flag', '=', '0');

    $data = $data->get();
    return $data[0]->privateworker;
  }

  public static function countWorkerByContractType($code = null, $loginInfo = null)
  {
    $data = DB::table('worker AS w')->select(DB::RAW('w.*'));

    if ($code) {
      $data = $data->whereRaw('? in (w.desired_contract_type)', [$code]);
    }

    if (!isset($loginInfo['admin_flag']) || $loginInfo['admin_flag'] != 1) {
      $data = $data->where('w.release_flag', 1);
    }

    return $data->count();
  }

  /*
   * お気に入りした人材の数のみ取得
   */
  public static function getFavoritesCount($search = array())
  {
    $select = '*';
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
    $data = DB::table('worker')
      ->select(DB::RAW($select))
      ->leftjoin('user_company_favorite AS ucf', function ($join) use ($user_company_id) {
        $join->on('ucf.target_id', '=', 'worker.worker_id')->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['WORKER']);
      })
      ->where('worker.del_flag', 0);
    // お気に入り人材表示
    if (isset($search['favoriteListFlag'])) {
      $data = $data->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['WORKER']);
    }
    return $data->count();
  }


  public static function searchUserEngineerName($title)
  {
    $select = "
           worker_id
          ,CONCAT(worker_id, ': ', last_name,first_name,'(',initial_name, ') ' , age, '歳 ' , m_station.station_name) as name
          ,worker.user_engineer_id
          ";
    $data = DB::table('worker')
      ->select(DB::RAW($select))
      ->leftJoin('m_station', 'worker.nearest_station', "=", 'm_station.station_id')
      ->where('worker.del_flag', 0)
      ->whereNotNull('worker.initial_name')
      ->whereNotNull('worker.user_engineer_id')
      ->whereNotNull('worker.age');

    if ($title) {
      $data->where(function ($data) use ($title) {
        $data->where('worker.last_name', 'like', '%' . $title . '%')
          ->orWhere('worker.first_name', 'like', '%' . $title . '%')
          ->orWhere('worker.initial_name', 'like', '%' . $title . '%');
      });
    }
    $data = $data->orderBy('create_date', 'desc')
      ->limit(5)
      ->get();

    return $data;
  }

  public static function searchWorkerName($title)
  {
    $select = "
           worker_id
          ,CONCAT(worker_id, ': ', last_name,first_name,'(',initial_name, ') ' , age, '歳 ' , m_station.station_name) as name
          ,worker.user_engineer_id
          ";
    $data = DB::table('worker')
      ->select(DB::RAW($select))
      ->leftJoin('m_station', 'worker.nearest_station', "=", 'm_station.station_id')
      ->where('worker.del_flag', 0)
      ->whereNotNull('worker.initial_name')
      ->whereNotNull('worker.age');

    if ($title) {
      $data->where(function ($data) use ($title) {
        $data->where('worker.last_name', 'like', '%' . $title . '%')
          ->orWhere('worker.first_name', 'like', '%' . $title . '%')
          ->orWhere('worker.initial_name', 'like', '%' . $title . '%');
      });
    }
    $data = $data->orderBy('create_date', 'desc')
      ->limit(config('const.DEFAULT_SUGGEST_COUNT'))
      ->get();

    return $data;
  }


  public static function getConnectionCount($worker_id)
  {
    $offer = DB::table('offer')
      ->where('worker_id', $worker_id);

    $data = DB::table('offer_to_worker')
      ->where('worker_id', $worker_id)
      ->union($offer)
      ->get();

    return count($data);
  }

  public static function getWorkerProfileCount($worker_id)
  {
    $sql = "
      worker.logo_image,
      worker.first_name,
      worker.sex,
      worker.birthday,
      worker.age,
      worker.email,
      worker.phone_number,
      worker.prefecture_id,
      worker.city_id,
      worker.address,
      worker.nearest_station,
      worker.desired_contract_type,
      worker.current_monthly_income,
      worker.desired_monthly_income,
      worker.operation_date,
      worker.school_name,
      worker.final_education,
      worker.educational_background_detail,
      worker.graduate_date,
      worker.self_introduction,
      worker.skill_sheet,
      worker_skill.id as skill,
      worker_desired_job.id desired_job,
      worker_desired_another_feature.id as feature,
      worker_portfolio.id as portfolio
    ";

    $data = DB::table('worker')
      ->select(DB::RAW($sql))
      ->leftjoin('worker_skill', 'worker_skill.worker_id', '=', 'worker.worker_id')
      ->leftjoin('worker_desired_job', 'worker_desired_job.worker_id', '=', 'worker.worker_id')
      ->leftjoin('worker_desired_another_feature', 'worker_desired_another_feature.worker_id', '=', 'worker.worker_id')
      ->leftjoin('worker_portfolio', 'worker_portfolio.worker_id', '=', 'worker.worker_id')
      ->where('worker.worker_id', $worker_id)
      ->first();

    return $data;
  }

  public static function getRecommendFromConditionForUserCompany($condition_list, $user_company_id)
  {
    $select = '
      w.worker_id,
      w.initial_name,
      w.age,
      CASE w.sex
        WHEN 0 THEN \'非公開\'
        WHEN 1 THEN \'男性\'
        WHEN 2 THEN \'女性\'
        ELSE \'非公開\'
      END AS sex,
      m_code_monthly_income.display_name AS desired_monthly_income,
      GROUP_CONCAT(DISTINCT m_job.job_name separator ", ") AS desired_job_name,
      GROUP_CONCAT(DISTINCT m_prefecture.prefecture_name separator ", ") AS desired_prefecture_name,
      GROUP_CONCAT(DISTINCT m_code_desired_contract_type.display_name) AS desired_contract_type,
      GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_name
    ';


    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->join('user_company_matching_score_to_worker AS ucmstw', function ($join) use ($user_company_id) {
        $join->on('ucmstw.worker_id', '=', 'w.worker_id')
          ->where('ucmstw.user_company_id', $user_company_id)
          ->where('ucmstw.mail_send_flag', 0);
      })
      ->leftjoin('m_code AS m_code_monthly_income', function ($join) {
        $join->on("m_code_monthly_income.code", "=", "w.desired_monthly_income")
          ->where('m_code_monthly_income.category', '=', config('const.CATEGORY')['MONTHLY_INCOME']);
      })
      ->leftjoin('worker_desired_job AS wdj', 'w.worker_id', 'wdj.worker_id')
      ->leftjoin('m_job', 'wdj.desired_job_id', 'm_job.job_id')
      ->leftjoin('worker_desired_workingplace AS wdw', 'w.worker_id', 'wdw.worker_id')
      ->leftjoin('m_prefecture', 'wdw.prefecture_id', 'm_prefecture.prefecture_id')
      ->leftjoin('m_code AS m_code_desired_contract_type', function ($join) {
        $join->on("w.desired_contract_type", "LIKE", DB::raw("CONCAT('%', m_code_desired_contract_type.code, '%')"))
          ->where('m_code_desired_contract_type.category', '=', config('const.CATEGORY')['CONTRACT_TYPE']);
      })
      ->leftjoin('worker_skill AS ws', 'w.worker_id', 'ws.worker_id')
      ->leftjoin('m_skill', 'ws.skill_id', 'm_skill.skill_id')
      ->leftjoin('worker_desired_job AS wdj_where', 'w.worker_id', 'wdj_where.worker_id')
      ->leftjoin('worker_desired_workingplace AS wdw_where', 'w.worker_id', 'wdw_where.worker_id')
      ->leftjoin('m_code AS m_code_desired_contract_type_where', function ($join) {
        $join->on("w.desired_contract_type", "LIKE", DB::raw("CONCAT('%', m_code_desired_contract_type_where.code, '%')"))
          ->where('m_code_desired_contract_type_where.category', '=', config('const.CATEGORY')['CONTRACT_TYPE']);
      })
      ->leftjoin('worker_skill AS ws_where', 'w.worker_id', 'ws_where.worker_id');

    if (isset($condition_list['job'])) {
      $data = $data
        ->whereIn('wdj_where.desired_job_id', $condition_list['job']);
    }

    if (isset($search_condition['prefecture'])) {
      $data = $data->whereIn('wdw_where.prefecture_id', $search_condition['prefecture']);
    }

    if (isset($search_condition['monthly_income'])) {
      $data = $data->whereRaw('CONVERT(w.desired_monthly_income, unsigned) <= ' . $search_condition['monthly_income'][0]);
    }

    if (isset($search_condition['contract_type'])) {
      $data = $data
        ->whereIn('m_code_desired_contract_type_where.code', $search_condition['contract_type']);
    }

    if (isset($search_condition['skill'])) {
      $data = $data->whereIn('ws_where.skill_id', $search_condition['skill']);
    }

    $data = $data->where('w.del_flag', 0)
      ->where('w.release_flag', 1)
      ->whereRaw('w.release_date = CURDATE()')
      ->groupBy('w.worker_id')
      ->orderBy('ucmstw.matching_score', 'desc')
      ->get();

    return $data;
  }

  public static function getNewCreateWorker($limit = null)
  {
    $select = '
      w.worker_id
     ,w.logo_image
     ,w.initial_name
     ,w.create_date
     ,DATE_FORMAT(w.create_date,\'%Y年%m月%d日\') AS create_date_jp
    ';

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->where('w.release_flag', '1')
      ->where('w.del_flag', '0')
      ->orderBy('w.create_date', 'DESC');

    if ($limit) $data = $data->limit($limit);

    $data = $data->get();
    return $data;
  }

  public static function getApplicantList()
  {
    $select = '
      w.worker_id
     ,w.last_name
     ,w.first_name
    ';

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->where('w.worker_type', 4)
      ->where('w.del_flag', '0')
      ->get();
    return $data;
  }

  /*
 * 人材が自社管理かどうか判定
 * return true:自社人材 false:他社人材
 */
  public static function checkCompanyPersonnel($company_id, $worker_id)
  {
    $record = \DB::table('worker')
      ->join('user_company', 'user_company.user_company_id', '=', 'worker.worker_manager_id')
      ->join('company', 'company.company_id', '=', 'user_company.company_id')
      ->where('worker.worker_id', $worker_id)
      ->where('company.company_id', $company_id);

    $record = $record->exists();

    return $record;
  }

  public static function getInterviewTargetWorker($search = [], $limit = 15)
  {
    $select = "
      w.worker_id
      ,w.logo_image
      ,w.initial_name
      ,w.last_name
      ,w.first_name
      ,w.worker_type
      ,w.sex
      ,w.age
      ,CONCAT(w.last_name, w.first_name) AS full_name
      ,w.worker_manager_id
      ,c.company_id AS worker_manager_company_id
      ,w.operation_date
      ,w.desired_contract_type
      ,w.movie
      ,desired_monthly_income.display_name AS desired_monthly_income_name
      ,CONCAT(uc.last_name, uc.first_name) AS agent_full_name
      ,CASE
        WHEN m_code_bts.display_name IS NULL THEN 'ステータスなし'
        ELSE m_code_bts.display_name
      END AS status
      ,DATE_FORMAT(w.operation_date,'%Y年%m月%d日') AS operation_date_jp
      ,GROUP_CONCAT(DISTINCT m_prefecture.prefecture_name) AS desired_workingplace_names
      ,GROUP_CONCAT(DISTINCT m_job.job_name) AS job_names
      ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
      ,GROUP_CONCAT(DISTINCT m_job_category.abbreviated_name) AS job_category_abbreviated_names
      ,GROUP_CONCAT(DISTINCT ex_skill_table.ex_skill_name) AS skill_and_experience
      ,pmstw.matching_score AS matching_score
      ,m_station.line_name AS train_line_name
      ,m_station.station_name AS station_name
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

    $zoom_meeting = "
      (SELECT
        z.worker_id, MAX(z.update_date) AS update_date, z.zoom_meeting_id
      FROM
        zoom_meeting AS z
      LEFT JOIN
        user_company AS uc
      ON
        z.user_company_id = uc.user_company_id
      LEFT JOIN
        company AS c
      ON
        c.company_id = uc.company_id
      WHERE
        c.company_id = ?
      GROUP BY
        z.worker_id)
      AS zm
    ";

    $data = DB::table('worker AS w')
      ->select(DB::RAW($select))
      ->leftjoin('user_engineer AS ue', "ue.user_engineer_id", "=", "w.user_engineer_id")
      ->leftjoin("user_company AS uc", "uc.user_company_id", "=", "w.worker_manager_id")
      ->leftjoin("company AS c", "uc.company_id", "=", "c.company_id")
      ->leftjoin('worker_skill AS ws', "ws.worker_id", "=", "w.worker_id")
      ->leftjoin('m_skill AS m_skill', "ws.skill_id", "=", "m_skill.skill_id")
      ->leftjoin('worker_desired_job AS wj', 'w.worker_id', "=", "wj.worker_id")
      ->leftjoin('worker_desired_workingplace AS ww', 'w.worker_id', "=", "ww.worker_id")
      ->leftjoin("m_prefecture AS m_prefecture", "m_prefecture.prefecture_id", "=", "ww.prefecture_id")
      ->leftjoin('m_station AS m_station', "m_station.station_id", "=", "w.nearest_station")
      ->leftjoin('m_job AS m_job', 'wj.desired_job_id', "=", "m_job.job_id")
      ->leftjoin('m_job_category AS m_job_category', 'm_job.job_category_id', "=", "m_job_category.job_category_id")
      ->leftjoin(DB::RAW($ex_skill_query), "ex_skill_table.worker_id", "w.worker_id")
      ->leftjoin('m_code AS contract_type', function ($join) {
        $join->on("w.desired_contract_type", "=", "contract_type.code")->where('contract_type.category', '=', config('const.CATEGORY')['CONTRACT_TYPE']);
      })
      ->leftjoin('m_code AS desired_monthly_income', function ($join) {
        $join->on("w.desired_monthly_income", "=", "desired_monthly_income.code")->where('desired_monthly_income.category', '=', config('const.CATEGORY')['MONTHLY_INCOME']);
      })
      ->leftjoin("business_talk_status AS bts", function ($join) {
        $join->on("bts.worker_id", "=", "w.worker_id")
          ->where("bts.lost_flag", "=", 0)
          ->where("bts.del_flag", "=", 0);
      })
      ->leftjoin("m_code AS m_code_bts", function ($join) {
        $join->on("bts.phase", "=", "m_code_bts.code")->where("m_code_bts.category", "=", config('const.CATEGORY')['BUSINESS_TALK_STATUS']);
      })
      ->leftjoin(DB::RAW($zoom_meeting), function ($join) use ($search) {
        $join->on("zm.worker_id", "=", "w.worker_id")->setBindings([$search['company_id']]);
      })
      ->leftjoin("project_matching_score_to_worker AS pmstw", function ($join) use ($search) {
        $join->on("w.worker_id", "pmstw.worker_id")->where("pmstw.project_id", $search["project_id"]);
      })
      ->where("w.del_flag", "=", 0)
      ->where(function ($query) {
        $query->whereNull('ue.registration_phase')->orWhere('ue.registration_phase', 0);
      });


    // 案件で検索
    if (array_key_exists("project_id", $search) && $search['project_id']) {
      $data = $data->orderBy('matching_score', 'desc');
    }

    $data = $data
      ->orderBy("zm.update_date", "DESC")
      ->orderBy("w.update_date", "DESC");

    // ステータス検索
    if (array_key_exists("business_talk_status", $search) && $search['business_talk_status']) {
      $data = $data->where("bts.phase", "=", $search['business_talk_status']);
    }

    // 自社に限定するかどうか
    if (array_key_exists("filter_own_company", $search) && (bool)$search['filter_own_company']) {
      $data = $data->where("c.company_id", "=", $search['company_id']);
    } else {
      $data = $data->where(function ($query) use ($search) {
        $query->orWhere("c.company_id", "=", $search['company_id'])
          ->orWhere("w.release_flag", 1);
      });
    }

    // フリーワード検索
    if (array_key_exists("searchKeyword", $search) && $search['searchKeyword']) {
      $keywords = $search['searchKeyword'];
      if (is_string($keywords)) {
        $keywords = preg_split("/\s+/u", trim(mb_convert_kana($search['searchKeyword'], 's')));
      }
      foreach ($keywords as $index => $keyword) {
        $data = $data->where(function ($data) use ($keyword) {
          $data->orWhere('w.last_name', 'like', '%' . $keyword . '%')
            ->orWhere('w.first_name', 'like', '%' . $keyword . '%')
            ->orWhere('w.initial_name', 'like', '%' . $keyword . '%')
            ->orWhere('w.self_introduction', 'like', '%' . $keyword . '%')
            ->orWhere('m_skill.skill_name', 'like', '%' . $keyword . '%')
            ->orWhere('m_prefecture.prefecture_name', 'like', '%' . $keyword . '%')
            ->orWhere('contract_type.display_name', 'like', '%' . $keyword . '%')
            ->orWhere('m_job.job_name', 'like', '%' . $keyword . '%');
        });
      }
    }

    $data = $data->groupby('w.worker_id')->limit($limit);


    return $data->get();
  }

  public static function getContactData($worker_ids){

    $select = '
       w.worker_id
      ,concat(w.last_name,w.first_name) worker_name 
      ,w.email as mailTo
      ,"" as mailCc
      ,TRUE as sendFlag
    ';
    $data = DB::table('worker AS w')
            ->select(DB::RAW($select))
            ->whereIn('w.worker_id', $worker_ids)
            ->where('w.del_flag', '0')
            ->get();

    return $data;
  }
}
