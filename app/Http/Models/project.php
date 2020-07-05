<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class project extends Model
{
  static $project_count = null;
  static $project_disp_count = null;
  protected $table = 'project';
  protected $guarded = ['project_id'];
  public $timestamps = false;

  public static function get($search = array(), $limit = null, $loginInfo = null)
  {
    $select = '
         project.project_id
        ,project.project_manager_id
        ,project.title
        ,project.nearest_station
        ,project.monthly_income_min
        ,project.monthly_income_max
        ,project.contract_type
        ,project.project_outline
        ,project.agent_comment
        ,project.settlement_time
        ,settlement_time.display_name AS settlement_time_name
        ,project.settlement_time_min
        ,project.settlement_time_max
        ,project.payment_terms
        ,project.recruitment_number
        ,user_company.user_company_id
        ,CONCAT(user_company.last_name, user_company.first_name) AS full_name
        ,user_company.last_name AS user_company_last_name
        ,user_company.first_name AS user_company_first_name
        ,user_company.logo_image as user_company_logo_image
        ,DATE_FORMAT(project.posting_end_date,\'%Y年%m月%d日\') as posting_end_date
        ,DATE_FORMAT(project.release_date,\'%Y/%m/%d\') as release_date_display
        ,DATE_FORMAT(project.create_date,\'%Y年%m月%d日\') as create_date
        ,project.work_start_date
        ,DATE_FORMAT(project.work_start_date,\'%Y/%m/%d\') AS work_start_date_display
        ,CASE
          WHEN project.work_start_date IS NULL THEN ""
          WHEN project.work_start_date > DATE_FORMAT((NOW() - INTERVAL 1 YEAR), \'%Y-%m-%d\') THEN DATE_FORMAT(project.work_start_date,\'%m/%d\')
          ELSE "old"
        END AS work_start_date_short
        ,company.company_id
        ,company.company_name
        ,company.logo_image  AS company_logo_image
         ,CASE
          WHEN project.del_flag IS NULL THEN 0
          ELSE project.del_flag
          END del_flag
        ,CASE
          WHEN project.pickup_flag IS NULL THEN 0
          ELSE project.pickup_flag
          END pickup_flag
        ,CASE
          WHEN project.release_flag IS NULL THEN 0
          ELSE project.release_flag
          END release_flag
        ,pre.prefecture_name
        ,m_city.city_name
        ,job.job_category_id
        ,job.job_name
        ,job_category.abbreviated_name AS job_category_abbreviated_name
        ,position.display_name AS position
        ,m_station.station_name AS nearest_station_name
        ,m_station.line_name AS nearest_station_line_name
        ,monthly_income.display_name AS monthly_income
        ,contract_type.display_name AS contract_type_name
        ,skill_management.display_name AS skill_management
        ,skill_english.display_name AS skill_english
        ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
        ,3.0 AS review_rating
        ,CASE
          WHEN DATEDIFF(NOW(), project.release_date) < 1 THEN "24時間以内"
          WHEN DATEDIFF(NOW(), project.release_date) between 1 AND 7 THEN CONCAT(FORMAT(DATEDIFF(NOW(), project.release_date),0),"日前")
          WHEN DATEDIFF(NOW(), project.release_date) between 8 AND 30 THEN CONCAT(TRUNCATE(DATEDIFF(NOW(), project.release_date)/7,0),"週間前")
          WHEN DATEDIFF(NOW(), project.release_date) between 31 AND 360 THEN CONCAT(TRUNCATE(DATEDIFF(NOW(), project.release_date)/30,0),"ヶ月前")
          WHEN DATEDIFF(NOW(), project.release_date) > 360 THEN CONCAT(TRUNCATE(DATEDIFF(NOW(), project.release_date)/360,0),"年前")
        ELSE 0 END AS diffDate
        ,working_system.display_name AS working_system_name
        ,contract_period.display_name AS contract_period_name
      ';
    if (isset($search['worker_id'])) {
      $select .= ',CASE
          WHEN wf.worker_id IS NULL THEN 0
          ELSE 1
          END AS favorite
          ,wmstp.matching_score
          ';
      $worker_id = $search['worker_id'];
    } else {
      $worker_id = 0;
    }

    $data = DB::table('project')
            ->select(DB::RAW($select))
            ->leftjoin('project_skill AS skill', function ($join) {
              $join->on('skill.project_id', '=', 'project.project_id')
                      ->where('skill.priority', 0);
            })
            ->leftjoin('m_skill AS m_skill', 'skill.skill_id', "=", "m_skill.skill_id")
            ->join('company', function ($join) use($search) {
              if(array_key_exists('page_type', $search) && $search["page_type"] === 'manage') {
                $join->on('company.company_id', '=', 'project.company_id')->where('company.del_flag', 0);
              } else {
                $join->on('company.company_id', '=', 'project.company_id')->where('company.del_flag', 0)->where('company.release_flag', 1);
              }
            })
            ->leftjoin('company as project_company', 'project_company.company_id', '=', 'project.project_company_id')
            ->leftjoin('m_station as m_station', 'm_station.station_id', '=', 'project.nearest_station')
            ->leftjoin('m_code AS position', function ($join) {
              $join->on("position.code", "=", "project.position")->where('position.category', '=', config('const.CATEGORY')['POSITION']);
            })
            ->leftjoin('m_code AS working_system', function ($join) {
              $join->on("working_system.code", "=", "project.working_system")->where('working_system.category', '=', config('const.CATEGORY')['WORKING_SYSTEM']);
            })
            ->leftjoin('m_prefecture AS pre', 'pre.prefecture_id', "=", "project.prefecture_id")
            ->leftjoin('m_city', 'm_city.city_id', '=', 'project.city_id')
            ->leftjoin('project_feature AS project_feature', 'project_feature.project_id', "=", "project.project_id")
            ->leftjoin('m_another_feature AS m_another_feature', 'm_another_feature.another_feature_id', "=", "project_feature.project_feature_id")
            ->leftjoin('m_job AS job', 'job.job_id', "=", "project.job_id")
            ->leftjoin('m_job_category AS job_category', 'job.job_category_id', "=", "job_category.job_category_id")
            ->leftjoin('user_company', 'user_company.user_company_id', '=', 'project.project_manager_id')
            ->leftjoin('m_code AS settlement_time', function ($join) {
              $join->on("settlement_time.code", "=", "project.settlement_time")
                      ->where('settlement_time.category', '=', config('const.CATEGORY')['SETTLEMENT_TIME']);
            })
            ->leftjoin('m_code AS contract_type', function ($join) {
              $join->on("contract_type.code", "=", "project.contract_type")
                      ->where('contract_type.category', '=', config('const.CATEGORY')['CONTRACT_TYPE']);
            })
            ->leftjoin('m_code AS contract_period', function ($join) {
              $join->on("contract_period.code", "=", "project.contract_period")
                      ->where('contract_period.category', '=', config('const.CATEGORY')['CONTRACT_PERIOD']);
            })
            ->leftjoin('m_code AS monthly_income', function ($join) {
              $join->on("monthly_income.code", "=", "project.monthly_income")
                      ->where('monthly_income.category', '=', config('const.CATEGORY')['MONTHLY_INCOME']);
            })
            ->leftjoin('m_code AS skill_management', function ($join) {
              $join->on("skill_management.code", "=", "project.skill_management")
                      ->where('skill_management.category', '=', config('const.CATEGORY')['SKILL_MANAGEMENT']);
            })
            ->leftjoin('m_code AS skill_english', function ($join) {
              $join->on("skill_english.code", "=", "project.skill_english")
                      ->where('skill_english.category', '=', config('const.CATEGORY')['SKILL_ENGLISH']);
            })
            ->leftjoin('offer', function ($join) {
              $join->on("offer.project_id", "=", "project.project_id")
                      ->where('offer.del_flag', 0);
            })
            ->leftjoin('worker_favorite AS wf', function ($join) use ($worker_id) {
              $join->on('wf.target_id', '=', 'project.project_id')->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['PROJECT']);
            })
            ->leftjoin('worker_matching_score_to_project AS wmstp', function ($join) use ($worker_id) {
              $join->on('wmstp.project_id', '=', 'project.project_id')->where('wmstp.worker_id', '=', $worker_id);
            })
            ->where('project.del_flag', 0);

    // お気に入り案件表示
    if (isset($search['favoriteListFlag'])) {
      $data = $data->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['PROJECT']);
    }

    // 応募した案件取得
    if (isset($search['appliedListFlag'])) {
      $data = $data->where('offer.worker_id', '=', $worker_id);
    }

    if (isset($loginInfo['admin_flag']) && $loginInfo['admin_flag'] != 1 && $search["page_type"] === 'manage') {
      //企業アカウントの場合(通常アカウント)は自分の案件のみを表示する
      $data = $data->where('company.company_id', $loginInfo['company_id']);
    } elseif (!isset($loginInfo['admin_flag']) || $loginInfo['admin_flag'] != 1) {
      $data = $data->where('project.release_flag', 1);
    }

    $data->where('project.recruitment_end_flag', 0);

    if (isset($search['searchKeyword']) && $search['searchKeyword']) {
      $keywords = $search['searchKeyword'];
      if (is_string($keywords)) {
        $keywords = preg_split("/\s+/u", trim(mb_convert_kana($search['searchKeyword'], 's')));
      }
      foreach ($keywords as $index => $keyword) {
        $data = $data->where(function ($data) use ($keyword) {
          $data->orWhere('project.title', 'like', '%' . $keyword . '%')
            ->orWhere('project.project_outline', 'like', '%' . $keyword . '%')
            ->orWhere('pre.prefecture_name', 'like', '%' . $keyword . '%')
            ->orWhere('project.address', 'like', '%' . $keyword . '%')
            ->orWhere('m_skill.skill_name', 'like', '%' . $keyword . '%')
            ->orWhere('m_city.city_name', 'like', '%' . $keyword . '%')
            ->orWhere('m_another_feature.another_feature_name', 'like', '%' . $keyword . '%')
            ->orWhere('job.job_name', 'like', '%' . $keyword . '%');
        });
      }
    }

    //職種検索
    if (array_key_exists("job_id", $search) && $search['job_id']) {
      // $data = $data->whereIn('project.job_id', $search['job_id']);
      // 複数対応
      $data = $data->whereIn('project.job_id', $search['job_id']);
    }

    //スキル検索
    if (array_key_exists("skill_id", $search) && $search['skill_id']) {
      //echo "<pre>";    var_dump($search['skill_id']);    echo "</pre>";
      $data = $data->leftjoin('project_skill', 'project_skill.project_id', '=', 'project.project_id')
              ->whereIn('project_skill.skill_id', $search['skill_id']);
    }

    //勤務地指定がある場合
    if (array_key_exists("prefecture_id", $search) && $search['prefecture_id'] && $search['prefecture_id'][0] != null) {
      // 複数対応
      $data = $data->whereIn('project.prefecture_id', $search['prefecture_id']);
    }


    //    if(array_key_exists("prefecture_name", $search) && $search['prefecture_name']){
    //      $keyword = $search['prefecture_name'];
    //      $data = $data->where('pre.prefecture_name', 'like', '%' . $keyword . '%');
    //    }

    //ピックアップ求人の場合
    if (isset($search['pickup_flag']) && $search['pickup_flag'] === TRUE) {
      $data = $data->where('project.pickup_flag', 1);
    }

    // 雇用形態指定がある場合
    if (array_key_exists("contract_type", $search) && $search['contract_type']) {
      // $data = $data->where('project.contract_type', $search['contract_type']);
      // 複数対応
      if (is_array($search['contract_type'])) {
        $contract_type = $search['contract_type'];
      } else {
        $contract_type = explode(',', $search['contract_type']);
      }
      $data = $data->whereIn('project.contract_type', $contract_type);
    }

    // 投稿日指定がある場合
    if (array_key_exists("post_date", $search) && $search['post_date']) {
      if ($search['post_date'] == '1') {
        $data = $data->whereRaw("DATE_ADD(project.create_date, INTERVAL 24 HOUR) > NOW()");
      } elseif ($search['post_date'] == '2') {
        $data = $data->whereRaw("DATE_ADD(project.create_date, INTERVAL 7 DAY) > NOW()");
      } elseif ($search['post_date'] == '3') {
        $data = $data->whereRaw("DATE_ADD(project.create_date, INTERVAL 14 DAY) > NOW()");
      } elseif ($search['post_date'] == '4') {
        $data = $data->whereRaw("DATE_ADD(project.create_date, INTERVAL 30 DAY) > NOW()");
      }
    }

    // 求人の特徴指定がある場合
    if (array_key_exists("project_feature", $search) && $search['project_feature']) {
      $data = $data->whereIn('project_feature.project_feature_id', $search['project_feature']);
    }

    // 従業員数の指定がある場合
    if (array_key_exists("employees_number", $search) && $search['employees_number']) {
      $data = $data->where('project_company.employees_number', '<', config('const.EMPLOYEES_NUMBER')[$search['employees_number']]);
    }

    //単金検索
    if (array_key_exists("monthly_income", $search) && $search['monthly_income']) {
      $data = $data->whereIn('project.monthly_income', $search['monthly_income']);
    }

    //稼働開始日検索
    if (array_key_exists("work_start_date", $search) && $search['work_start_date']) {
      $data = $data->whereNotNull("work_start_date");
      if ($search['work_start_date'] == "1") {
        $data = $data->whereRaw("DATE_ADD(NOW(), INTERVAL 7 DAY) >= project.work_start_date");
      } elseif ($search['work_start_date'] == "2") {
        $data = $data->whereRaw("DATE_ADD(NOW(), INTERVAL 7 DAY) < project.work_start_date");
      } elseif ($search['work_start_date'] == "3") {
        $data = $data->whereRaw("DATE_ADD(NOW(), INTERVAL 14 DAY) < project.work_start_date");
      } elseif ($search['work_start_date'] == "4") {
        $data = $data->whereRaw("DATE_ADD(NOW(), INTERVAL 1 MONTH) < project.work_start_date");
      } elseif ($search['work_start_date'] == "5") {
        $data = $data->whereRaw("DATE_ADD(NOW(), INTERVAL 2 MONTH) < project.work_start_date");
      } elseif ($search['work_start_date'] == "6") {
        $data = $data->whereRaw("DATE_ADD(NOW(), INTERVAL 3 MONTH) > NOW()");
      }
    }

    //ソート順が指定されている場合
    //基本的に新着は企業は作成日、人材は公開日を見る
    if (isset($search["sort"])) {
      if ($search["sort"] == "new") {
        $data = $data->orderbyRaw('project.release_date desc, project.project_id desc');
        if (isset($loginInfo['user_type']) && $loginInfo['user_type'] == config('const.USER_TYPE')['WORKER']) {
          if (isset($search["mypage_flag"]) && $search["mypage_flag"] == 1) {
            $data = $data
              ->whereRaw("DATE_ADD(project.release_date, INTERVAL 7 DAY) > NOW()")
              ->orderbyRaw('project.release_date desc, project.project_id desc');
          }
        }
        $data = $data->groupby("project.project_id");
      } elseif ($search["sort"] == "pickup" && isset($worker_id)) {
        $data = $data->orderbyRaw('wmstp.matching_score desc, project.release_date desc, project.project_id desc');
      } else {
        if (isset($loginInfo['user_type']) && $loginInfo['user_type'] == config('const.USER_TYPE')['WORKER']) {
          $data = $data->orderbyRaw('project.release_date desc');
        } else {
          $data = $data->orderbyRaw('project.create_date desc');
        }
        $data = $data->orderbyRaw('project.project_id desc');
      }
    } else {
      if (isset($loginInfo['user_type']) && $loginInfo['user_type'] == config('const.USER_TYPE')['WORKER']) {
        $data = $data->orderbyRaw('project.release_date desc');
      } else {
        $data = $data->orderbyRaw('project.create_date desc');
      }
      $data = $data->orderbyRaw('project.project_id desc');
    }

    $data = $data->groupby("project.project_id");

    //検索件数指定
    if ($limit != null) {
      $data = $data->limit($limit);
      return $data->get();
    }

    //全体の合計数を取得
    //self::$project_count = $data->count();

    if (array_key_exists("where", $search)) {
      $data = $data->paginate();
    } else {
      $data = $data->paginate(config('const.DEFAULT_SEARCH_COUNT')['GENERAL']);
    }
    // dd($data);
    //self::$project_disp_count = $data->count();

    return $data;
  }

  public static function detail($project_id = null, $worker_id = null)
  {
    $select = '
         project.project_id
        ,project.title
        ,project.company_id
        ,project.project_company_id
        ,project.project_manager_id
        ,project.job_id
        ,project.cover_image
        ,project.salary
        ,project.welfare
        ,project.vacation
        ,project.selection_process
        ,project.nearest_station
        ,project.monthly_income
        ,project.settlement_time
        ,settlement_time.display_name AS settlement_time_name
        ,project.settlement_time_min
        ,project.settlement_time_max
        ,project.payment_terms
        ,project.recruitment_number
        ,project.project_requirements
        ,project.contract_type
        ,project.contract_period
        ,project.project_outline
        ,project.desired_personality
        ,project.address
        ,project.postal_code
        ,project.prefecture_id
        ,project.city_id
        ,project.latitude
        ,project.longitude
        ,project.working_system
        ,project.working_days
        ,project.age_min
        ,project.age_max
        ,project.agent_comment
        ,DATEDIFF(NOW(), project.release_date) as diff_release_date
        ,DATE_FORMAT(project.posting_end_date,\'%Y.%m\') as posting_end_date
        ,DATE_FORMAT(project.create_date,\'%Y年%m月%d日\') as create_date
        ,DATE_FORMAT(project.release_date,\'%Y.%m\') as release_date
        ,DATE_FORMAT(project.work_start_date,\'%Y年%m月%d日\') AS work_start_date_jp
        ,HOUR(project.working_time_from) as working_time_from_hour
        ,MINUTE(project.working_time_from) as working_time_from_minute
        ,HOUR(project.working_time_to) as working_time_to_hour
        ,MINUTE(project.working_time_to) as working_time_to_minute
        ,working_time_from
        ,working_time_to
        ,CONCAT(\'/storage/company/\' , company.company_id, \'/\', company.logo_image)  AS logo_image
        ,project_category
        ,settlement_time
        ,m_code_contract_period.display_name AS contract_period_jp
        ,m_code_working_days.display_name AS working_days_jp
        ,m_code_working_system.display_name AS working_system_jp
        ,monthly_income.display_name AS monthly_income_jp
        ,monthly_income.col_2 AS monthly_income_min
        ,monthly_income.col_3 AS monthly_income_max
        ,work_start_date
        ,agent_comment
        ,recruitment_restrictions
        ,number_of_interviews
        ,job.job_name
        ,job.job_category_id
        ,position.display_name AS position
        ,skill_management.display_name AS skill_management
        ,skill_english.display_name AS skill_english
        ,company.company_name
        ,project_company.company_name AS project_company_name
        ,project_company.logo_image AS project_company_logo_image
        ,project_previews.previews
        ,pre.prefecture_name
        ,city.city_name
        ,nearest_station.line_id AS train_line_id
        ,nearest_station.line_name AS train_line_name
        ,nearest_station.station_name AS station_name
        ,GROUP_CONCAT(DISTINCT project_skill.skill_id) AS skill_required
        ,GROUP_CONCAT(DISTINCT project_skill_ok.skill_id) AS skill_ok
        ,GROUP_CONCAT(DISTINCT project_feature.project_feature_id) AS project_feature_id
        ,uc.last_name AS agent_last_name
        ,uc.first_name AS agent_first_name
        ,uc.logo_image AS agent_logo_image
    ';

    if ($worker_id != null) {
      $select .= '
            ,CASE
            WHEN wf.worker_id IS NULL THEN 0
            ELSE 1
            END AS favorite
            ,wmstp.matching_score
          ';
    }

    $data = DB::table('project')
      ->select(DB::RAW($select))
      ->leftjoin('user_company AS uc', 'uc.user_company_id', '=', 'project.project_manager_id')
      ->leftjoin('company', 'company.company_id', '=', 'project.company_id')
      ->leftjoin('company AS project_company', 'project_company.company_id', '=', 'project.project_company_id')
      ->leftjoin('project_previews', 'project.project_id', '=', 'project_previews.project_id')
      ->leftjoin('project_feature', 'project_feature.project_id', '=', 'project.project_id')
      ->leftjoin('project_skill', function ($join) {
        $join->on('project_skill.project_id', '=', 'project.project_id')
          ->where('project_skill.priority', 0);
      })
      ->leftjoin('project_skill AS project_skill_ok', function ($join) {
        $join->on('project_skill_ok.project_id', '=', 'project.project_id')
          ->where('project_skill_ok.priority', 1);
      })
      ->leftjoin('m_code AS position', function ($join) {
        $join->on("position.code", "=", "project.position")->where('position.category', '=', config('const.CATEGORY')['POSITION']);
      })
      ->leftjoin('m_code AS monthly_income', function ($join) {
        $join->on("monthly_income.code", "=", "project.monthly_income")
          ->where('monthly_income.category', '=', config('const.CATEGORY')['MONTHLY_INCOME']);
      })
      ->leftjoin('m_prefecture AS pre', 'pre.prefecture_id', "=", "project.prefecture_id")
      ->leftjoin('m_city AS city', 'project.city_id', "=", "city.city_id")
      ->leftjoin('m_station AS nearest_station', 'project.nearest_station', "=", "nearest_station.station_id")
      ->leftjoin('m_job AS job', 'job.job_id', "=", "project.job_id")
      ->leftjoin('m_code AS skill_management', function ($join) {
        $join->on("skill_management.code", "=", "project.skill_management")
          ->where('skill_management.category', '=', config('const.CATEGORY')['SKILL_MANAGEMENT']);
      })
      ->leftjoin('m_code AS skill_english', function ($join) {
        $join->on("skill_english.code", "=", "project.skill_english")
          ->where('skill_english.category', '=', config('const.CATEGORY')['SKILL_ENGLISH']);
      })
      ->leftjoin('m_code AS settlement_time', function ($join) {
        $join->on("settlement_time.code", "=", "project.settlement_time")
          ->where('settlement_time.category', '=', config('const.CATEGORY')['SETTLEMENT_TIME']);
      })
      ->leftjoin('m_code AS contract_type', function ($join) {
        $join->on("contract_type.code", "=", "project.contract_type")
          ->where('contract_type.category', '=', config('const.CATEGORY')['CONTRACT_TYPE']);
      })
      ->leftjoin('m_code AS m_code_contract_period', function ($join) {
        $join->on('m_code_contract_period.code', "=", "project.contract_period")
          ->where("m_code_contract_period.category", "=", config('const.CATEGORY')['CONTRACT_PERIOD']);
      })
      ->leftjoin('m_code AS m_code_working_days', function ($join) {
        $join->on('m_code_working_days.code', "=", "project.working_days")
          ->where("m_code_working_days.category", "=", config('const.CATEGORY')['DAYS_A_WEEK']);
      })
      ->leftjoin('m_code AS m_code_working_system', function ($join) {
        $join->on('m_code_working_system.code', "=", "project.working_system")
          ->where("m_code_working_system.category", "=", config('const.CATEGORY')['WORKING_SYSTEM']);
      })
      ->leftjoin('m_code AS m_code_business_type', function ($join) {
        $join->on('m_code_business_type.code', "=", "company.business_type")
          ->where("m_code_business_type.category", "=", config('const.CATEGORY')['BUSINESS_TYPE']);
      })
      ->leftjoin('worker_matching_score_to_project AS wmstp', function ($join) use ($worker_id) {
        $join->on('wmstp.project_id', '=', 'project.project_id')->where('wmstp.worker_id', '=', $worker_id);
      })
      // ->where('project.release_flag', 1)
      ->where('project.recruitment_end_flag', 0)
      ->groupby('project.project_id');

    if ($worker_id != null) {
      $data = $data->leftjoin('worker_favorite AS wf', function ($join) use ($worker_id) {
        $join->on('wf.target_id', '=', 'project.project_id')->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', 0);
      });
    }

    if ($project_id) {
      $data = $data->where('project.project_id', $project_id);
      if (!$data->exists()) {
        return null;
      }
      $project = $data->get();

      return $project[0];
    } else {
      if (!$data->exists()) {
        return null;
      }
      $data = $data->get();
      $project = null;
      foreach ($data[0] as $key => $val) {
        $project[$key] = null;
      }

      $ret = (object) $project;

      return $ret;
    }
  }

  public static function getNearestProject($project_feature_ids, $project_id = null)
  {
    $select = '
         project.project_id
        ,project.title
        ,project.cover_image
        ,project.nearest_station
        ,project.monthly_income_min
        ,project.monthly_income_max
        ,project.contract_type
        ,project.project_outline
        ,DATE_FORMAT(project.create_date,\'%Y年%m月%d日\') as create_date
        ,DATE_FORMAT(project.release_date,\'%Y年%m月%d日\') as release_date
        ,company.company_name
        ,CONCAT(\'/storage/company/\' , company.company_id, \'/\', company.logo_image)  AS logo_image
        ,pre.prefecture_name
        ,job.job_name
        ,job.job_category_id
        ,position.display_name AS position
        ,skill_management.display_name AS skill_management
        ,skill_english.display_name AS skill_english
        ,tmp.project_feature
        ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
      ';


    $data = DB::table('project')
      ->select(DB::RAW($select))
      ->leftjoin('project_skill AS skill', 'skill.project_id', '=', 'project.project_id')
      ->leftjoin('m_skill AS m_skill', 'skill.skill_id', '=', 'm_skill.skill_id')
      ->leftjoin('company', 'company.company_id', '=', 'project.company_id')
      //->leftjoin('project_feature', 'project_feature.project_id', '=', 'project.project_id')
      ->leftjoin('m_code AS position', function ($join) {
        $join->on("position.code", "=", "project.position")->where('position.category', '=', config('const.CATEGORY')['POSITION']);
      })
      ->leftjoin('m_prefecture AS pre', 'pre.prefecture_id', "=", "project.prefecture_id")
      ->leftjoin('m_job AS job', 'job.job_id', "=", "project.job_id")
      ->leftjoin('m_code AS skill_management', function ($join) {
        $join->on("skill_management.code", "=", "project.skill_management")
          ->where('skill_management.category', '=', config('const.CATEGORY')['SKILL_MANAGEMENT']);
      })
      ->leftjoin('m_code AS skill_english', function ($join) {
        $join->on("skill_english.code", "=", "project.skill_english")
          ->where('skill_english.category', '=', config('const.CATEGORY')['SKILL_ENGLISH']);
      })
      ->leftjoin(DB::RAW('(SELECT project.project_id,GROUP_CONCAT(project_feature.project_feature_id) AS project_feature
                                FROM project LEFT JOIN project_feature ON project.project_id = project_feature.project_id GROUP BY project.project_id) AS tmp'), 'project.project_id', '=', 'tmp.project_id')
      ->where('project.release_flag', 1)
      ->where('project.del_flag', 0)
      ->where('project.recruitment_end_flag', 0)
      ->where('tmp.project_feature', $project_feature_ids);

    if ($project_id) {
      $data = $data->where("project.project_id", '!=', $project_id);
    }

    $data = $data->get();


    //全体の合計数を取得
    self::$project_count = $data->count();

    self::$project_disp_count = $data->count();

    if ($data->count() == 0) {
      return null;
    } elseif ($data->count() == 1 && !$data[0]->project_id) {
      return null;
    }


    return $data;
  }

  /*
   * project_idから求人情報を取得
   */
  public static function getProjectById($project_id = null)
  {
    if (!$project_id) {
      return null;
    }
    $select = '
       p.project_id
      ,p.project_manager_id
      ,p.title
      ,c.company_id
      ,c.company_name
    ';

    $data = DB::table('project AS p')
      ->select(DB::RAW($select))
      ->leftjoin('company AS c', 'c.company_id', "=", "p.company_id")
      ->where('p.project_id', $project_id)
      ->where('p.del_flag', '0')
      ->get();

    return $data[0];
  }

  /*
   * 条件から求人数を取得
   */
  public static function countFilteredProject($search = null, $loginInfo)
  {
    $data = DB::table('project AS p')
      ->select(DB::RAW('*'));

    if (array_key_exists("job_id", $search) && $search['job_id']) {
      $data = $data->where('p.job_id', $search['job_id']);
    }

    if (array_key_exists("prefecture_id", $search) && $search['prefecture_id']) {
      $data = $data->where('p.prefecture_id', $search['prefecture_id']);
    }

    $data = $data->where('p.del_flag', 0);

    if (!isset($loginInfo['admin_flag'])) {
      $data = $data->where('p.release_flag', 1);
    } elseif ($loginInfo['admin_flag'] != 1) {
      //企業アカウントの場合(通常アカウント)は自分の案件のみを表示する
      $data = $data->where('p.company_id', $loginInfo['company_id']);
    }

    return $data->count();
  }


  /*
 * project_idからメッセージ用求人情報を取得
 */
  public static function getProjectForMessageById($project_id)
  {
    $select = '
       p.project_id
      ,p.title
      ,u.user_company_id
      ,p.project_manager_id
      ,CASE
        WHEN u.user_company_id IS NOT NULL THEN u.company_id
        ELSE ' . config('const.EIGHT_COMPANY_ID') .
      ' END AS company_id

    ';

    $data = DB::table('project AS p')
      ->select(DB::RAW($select))
      ->leftjoin('company AS c', 'c.company_id', "=", "p.company_id")
      ->leftjoin('user_company AS u', 'u.company_id', "=", "p.company_id")
      ->where('p.project_id', $project_id)
      ->where('p.del_flag', '0')
      ->get();

    return $data[0];
  }

  // worker_idを指定した場合スコアの高いものでオファーもお気に入りもしていないものになる
  public static function getRecommendedProject($worker_id = null, $company_id = null, $data_limit = null, $view_limit = null)
  {

    $select = '
        project.project_id
        ,project.title
        ,project.cover_image AS project_image
        ,project.project_manager_id
        ,project.nearest_station
        ,project.address
        ,project.monthly_income_min
        ,project.monthly_income_max
        ,project.contract_type
        ,project.project_outline
        ,project.release_date
        ,project.work_start_date
        ,CONCAT(uc.last_name, uc.first_name) AS full_name
        ,uc.logo_image AS user_company_logo_image
        ,DATEDIFF(NOW(), project.create_date) as diff_create_date
        ,DATE_FORMAT(project.posting_end_date,\'%Y年%m月%d日\') as posting_end_date
        ,DATE_FORMAT(project.release_date,\'%Y年%m月%d日\') as release_date
        ,DATE_FORMAT(project.create_date,\'%Y年%m月%d日\') as create_date
        ,company.company_name
        ,CONCAT(\'/storage/company/\' , company.company_id, \'/\', company.logo_image)  AS logo_image
        ,CASE
          WHEN project.del_flag IS NULL THEN 0
          ELSE project.del_flag
          END del_flag
        ,CASE
          WHEN project.pickup_flag IS NULL THEN 0
          ELSE project.pickup_flag
          END pickup_flag
        ,CASE
          WHEN project.release_flag IS NULL THEN 0
          ELSE project.release_flag
          END release_flag
        ,pre.prefecture_name
        ,job.job_id
        ,job.job_category_id
        ,job.job_name
        ,position.display_name AS position
        ,skill_management.display_name AS skill_management
        ,skill_english.display_name AS skill_english
        ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
        ,CASE
        WHEN DATEDIFF(NOW(), project.release_date) = 0 THEN "24時間以内"
        WHEN DATEDIFF(NOW(), project.release_date) between 0 AND 7 THEN CONCAT(FORMAT(DATEDIFF(NOW(), project.release_date),0),"日前")
        WHEN DATEDIFF(NOW(), project.release_date) between 8 AND 30 THEN CONCAT(TRUNCATE(DATEDIFF(NOW(), project.release_date)/7,0),"週間前")
        WHEN DATEDIFF(NOW(), project.release_date) between 31 AND 360 THEN CONCAT(TRUNCATE(DATEDIFF(NOW(), project.release_date)/30,0),"ヶ月前")
        WHEN DATEDIFF(NOW(), project.release_date) > 360 THEN CONCAT(TRUNCATE(DATEDIFF(NOW(), project.release_date)/360,0),"年前")
        ELSE "24時間以内" END AS diffDate
        ,3.0 AS review_rating
      ';
    // TODO: review_ratingの実装

    $data = DB::table('project')
      ->select(DB::RAW($select))
      ->leftjoin('user_company AS uc', 'uc.user_company_id', "=", "project.project_manager_id")
      ->leftjoin('project_skill AS skill', function ($join) {
        $join->on('skill.project_id', '=', 'project.project_id')
          ->where('skill.priority', 0);
      })
      ->leftjoin('m_skill AS m_skill', 'skill.skill_id', "=", "m_skill.skill_id")
      ->leftjoin('company', 'company.company_id', '=', 'project.company_id')
      ->leftjoin('m_code AS position', function ($join) {
        $join->on("position.code", "=", "project.position")->where('position.category', '=', config('const.CATEGORY')['POSITION']);
      })
      ->leftjoin('m_prefecture AS pre', 'pre.prefecture_id', "=", "project.prefecture_id")
      ->leftjoin('m_job AS job', 'job.job_id', "=", "project.job_id")
      ->leftjoin('m_code AS skill_management', function ($join) {
        $join->on("skill_management.code", "=", "project.skill_management")
          ->where('skill_management.category', '=', config('const.CATEGORY')['SKILL_MANAGEMENT']);
      })
      ->leftjoin('m_code AS skill_english', function ($join) {
        $join->on("skill_english.code", "=", "project.skill_english")
          ->where('skill_english.category', '=', config('const.CATEGORY')['SKILL_ENGLISH']);
      });


    if (isset($company_id)) {
      $data = $data
        ->where('project.company_id', $company_id);
    }

    if (isset($worker_id)) {
      $data = $data
        ->leftjoin('worker_favorite AS wf', function ($join) use ($worker_id) {
          $join->on('wf.target_id', '=', 'project.project_id')->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['PROJECT']);
        })
        ->leftjoin('offer AS o', function ($join) use ($worker_id) {
          $join->on('o.project_id', '=', 'project.project_id')->where('o.worker_id', '=', $worker_id)->where('o.del_flag', '=', 0);
        })
        ->leftjoin('worker_matching_score_to_project AS wmstp', function ($join) use ($worker_id) {
          $join->on('wmstp.project_id', '=', 'project.project_id')->where('wmstp.worker_id', '=', $worker_id);
        })
        ->whereNULL('wf.worker_id')
        ->whereNULL('o.worker_id')
        ->orderbyRaw('wmstp.matching_score desc');
    }

    $data = $data
      ->where('project.del_flag', 0)
      ->where('project.release_flag', 1)
      ->where('project.recruitment_end_flag', 0)
      ->orderbyRaw('project.release_date desc, project.project_id desc')
      ->groupby("project.project_id");

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
   * company_idから求人情報を取得
   */
  public static function getProjectByCompanyId($company_id, $limit = null, $mode = null)
  {
    $select = '
      p.project_id
      ,p.title
      ,p.cover_image
      ,p.project_manager_id
      ,DATE_FORMAT(p.create_date,\'%Y年%m月%d日\') as create_date
      ,c.company_id
      ,c.company_name
      ,uc.logo_image AS user_company_logo_image
      ,job.job_name
      ,job.job_category_id
      ,pre.prefecture_name
      ,3.0 AS review_rating
    ';

    $data = DB::table('project AS p')
      ->select(DB::RAW($select))
      ->leftjoin('company AS c', 'c.company_id', "=", "p.company_id")
      ->leftjoin('user_company AS uc', 'uc.user_company_id', "=", "p.project_manager_id")
      ->leftjoin('m_prefecture AS pre', 'pre.prefecture_id', "=", "p.prefecture_id")
      ->leftjoin('m_job AS job', 'job.job_id', "=", "p.job_id")
      ->where('p.company_id', $company_id)
      ->where('p.del_flag', '0');

    if ($mode == 'company_detail') {
      $data = $data->orderBy('p.create_date', 'desc');
    } else {
      $data = $data
        ->whereRaw("p.create_date > (NOW() - INTERVAL 1 WEEK)")
        ->orderBy('p.create_date', 'desc');
    }

    if ($limit) {
      $data = $data->limit($limit);
    }

    $data = $data->get();

    return $data;
  }

  public static function getProject4DashboardByCompanyId($company_id, $limit = null)
  {
    $select = '
      p.project_id
      ,p.title
      ,p.project_manager_id
      ,DATE_FORMAT(p.create_date,\'%Y年%m月%d日\') as create_date
      ,uc.logo_image AS user_company_logo_image
      ,job.job_category_id
      ,CASE WHEN p.release_flag = 0 THEN
          "非公開"
        WHEN p.recruitment_end_flag = 1 THEN
          "掲載終了"
        ELSE
          "募集中"
        END as project_status
        ,count((bts.lost_flag = 1) or NULL) as count_phase_lost
        ,count((bts.phase = 1 and bts.lost_flag = 0) or NULL) as count_phase1
        ,count((bts.phase = 2 and bts.lost_flag = 0) or NULL) as count_phase2
        ,count((bts.phase = 3 and bts.lost_flag = 0) or NULL) as count_phase3
        ,count((bts.phase = 4 and bts.lost_flag = 0) or NULL) as count_phase4
        ,count((bts.phase = 5 and bts.lost_flag = 0) or NULL) as count_phase5
        ,count((bts.phase = 6 and bts.lost_flag = 0) or NULL) as count_phase6
        ,count((bts.phase = 7 and bts.lost_flag = 0) or NULL) as count_phase7
        ,count((bts.phase = 8 and bts.lost_flag = 0) or NULL) as count_phase8
        ,count((bts.phase = 9 and bts.lost_flag = 0) or NULL) as count_phase9
    ';

    $data = DB::table('project AS p')
      ->select(DB::RAW($select))
      ->leftjoin('user_company AS uc', 'uc.user_company_id', "=", "p.project_manager_id")
      ->leftjoin('m_job AS job', 'job.job_id', "=", "p.job_id")
      ->leftjoin('business_talk_status as bts', 'bts.project_id', "=", "p.project_id")
      ->leftjoin('m_code AS m_code_business_talk_status', function ($join) {
        $join->on("m_code_business_talk_status.code", "=", "bts.phase")
          ->where('m_code_business_talk_status.category', '=', config('const.CATEGORY')['BUSINESS_TALK_STATUS']);
      })
      ->where('p.company_id', $company_id)
      ->where('p.del_flag', '0')
      ->orderBy('p.create_date', 'desc')
      ->orderBy('p.pickup_flag', 'desc')
      ->orderBy('bts.update_date', 'desc')
      ->orderBy('p.project_id', 'asc');

    $data = $data->groupby('p.project_id');

    if ($limit) {
      $data = $data->limit($limit);
    }
    $data = $data->get();

    return $data;
  }

  /*
   * project_manager_id(user_company_id)から求人情報を取得
   */
  public static function getProjectByManagerId($manager_id, $admin_flag = 0)
  {
    $select = '
    project.project_id
    ,project.title
    ,project.nearest_station
    ,project.monthly_income_min
    ,project.monthly_income_max
    ,project.contract_type
    ,project.project_outline
    ,project.agent_comment
    ,user_company.user_company_id
    ,CONCAT(user_company.last_name, user_company.first_name) AS full_name
    ,user_company.logo_image as user_company_logo_image
    ,DATE_FORMAT(project.posting_end_date,\'%Y年%m月%d日\') as posting_end_date
    ,DATE_FORMAT(project.release_date,\'%Y年%m月%d日\') as release_date
    ,DATE_FORMAT(project.create_date,\'%Y年%m月%d日\') as create_date
    ,DATE_FORMAT(project.work_start_date,\'%Y年%m月%d日\') as work_start_date
    ,company.company_id
    ,company.company_name
    ,company.logo_image  AS company_logo_image
    ,CASE
      WHEN project.del_flag IS NULL THEN 0
      ELSE project.del_flag
      END del_flag
    ,CASE
      WHEN project.pickup_flag IS NULL THEN 0
      ELSE project.pickup_flag
      END pickup_flag
    ,CASE
      WHEN project.release_flag IS NULL THEN 0
      ELSE project.release_flag
      END release_flag
    ,pre.prefecture_name
    ,m_city.city_name
    ,job.job_category_id
    ,job.job_name
    ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
    ,position.display_name AS position
    ,monthly_income.display_name AS monthly_income
    ,skill_management.display_name AS skill_management
    ,skill_english.display_name AS skill_english

    ,3.0 AS review_rating
    ';

    // ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names

    $data = DB::table('project')
      ->select(DB::RAW($select))
      ->leftjoin('project_skill AS skill', function ($join) {
        $join->on('skill.project_id', '=', 'project.project_id')
          ->where('skill.priority', 0);
      })
      ->leftjoin('m_skill AS m_skill', 'skill.skill_id', "=", "m_skill.skill_id")
      ->leftjoin('company', 'company.company_id', '=', 'project.company_id')
      ->leftjoin('m_code AS position', function ($join) {
        $join->on("position.code", "=", "project.position")->where('position.category', '=', config('const.CATEGORY')['POSITION']);
      })
      ->leftjoin('m_prefecture AS pre', 'pre.prefecture_id', "=", "project.prefecture_id")
      ->leftjoin('m_city', 'm_city.city_id', '=', 'project.city_id')
      ->leftjoin('m_job AS job', 'job.job_id', "=", "project.job_id")
      ->leftjoin('user_company', 'project.project_manager_id', "=", "user_company.user_company_id")
      ->leftjoin('m_code AS monthly_income', function ($join) {
        $join->on("monthly_income.code", "=", "project.monthly_income")
          ->where('monthly_income.category', '=', config('const.CATEGORY')['MONTHLY_INCOME']);
      })
      ->leftjoin('m_code AS skill_management', function ($join) {
        $join->on("skill_management.code", "=", "project.skill_management")
          ->where('skill_management.category', '=', config('const.CATEGORY')['SKILL_MANAGEMENT']);
      })
      ->leftjoin('m_code AS skill_english', function ($join) {
        $join->on("skill_english.code", "=", "project.skill_english")
          ->where('skill_english.category', '=', config('const.CATEGORY')['SKILL_ENGLISH']);
      })
      // ->leftjoin('worker_favorite AS wf', function ($join) use ($worker_id) {
      //   $join->on('wf.target_id', '=', 'project.project_id')->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', 0);
      // })
      // ->leftjoin('worker_matching_score_to_project AS wmstp', function ($join) use ($worker_id) {
      //   $join->on('wmstp.project_id', '=', 'project.project_id')->where('wmstp.worker_id', '=', $worker_id);
      // })
      // ->where('project.recruitment_end_flag', 0)
      ->where('project.project_manager_id', $manager_id)
      ->where('project.del_flag', 0);

    // エージェントに紐づく公開済みの案件はすべて表示する
    // if($admin_flag == 0) {
    $data = $data->where('project.release_flag', 1);
    // }
    $data = $data->groupBy('project.project_id');
    $data = $data->orderBy('project.create_date', 'desc');
    $data = $data->paginate(8);

    // dd($data);

    return $data;
  }

  /*
   * ダッシュボードお客様案件数グラフデータ
  */
  public static function getCountMonthlyProject($company_id, $month_ago = null)
  {
    $select = '
        COUNT(*) AS count
    ';

    $data = DB::table('project')
      ->select(DB::RAW($select))
      ->where('company_id', $company_id)
      ->where('del_flag', 0)
      ->where('release_flag', 1)
      ->groupby('company_id');

    if (isset($month_ago) && $month_ago > 0) {
      $data = $data->whereRaw('
          release_date
          BETWEEN DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . -$month_ago . ' MONTH), "%Y-%m-01")
          AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . (-$month_ago + 1) . ' MONTH), "%Y-%m-01")
          ');
    } else {
      $data = $data->whereRaw('
          release_date
          BETWEEN DATE_FORMAT(CURDATE(), "%Y-%m-01")
          AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . 1 . ' MONTH), "%Y-%m-01")
          ');
    }

    $data = $data->get();

    if (isset($data[0])) {
      return $data[0]->count;
    } else {
      return 0;
    }
  }

  /*
   * insert or update判定
  */
  public static function upsert($data)
  {
    $record = \DB::table('project')->select("project_id")
      ->where('project_management_no', $data['project_management_no']);

    if ($record->exists()) {
      $data['project_id'] = $record->get()[0]->project_id;
      $record->update($data);
      return $data['project_id'];
    } else {
      return $record->insertGetId($data);
      //return $record->project_id;

    }
  }

  /*
   * insert or update判定
   * 他社メディアからクローラーで取得したCSVデータ取込時に使用
   */
  public static function upsertForThirdPatyMedia($data, $project_manager_id = null)
  {
    $record = \DB::table('project')->select("project_id")
      ->where('media_id', $data['media_id'])
      ->where('media_project_id', $data['media_project_id']);

    if ($record->exists()) {
      $data['project_id'] = $record->get()[0]->project_id;
      $record->update($data);
      return $data['project_id'];
    } else {
      //新規登録時の日付をリリース日とする
      $data['project_manager_id'] = $project_manager_id;
      $data['release_date'] = date("Y-m-d");
      return $record->insertGetId($data);
    }
  }

  /*
   * 存在しない案件番号(マイナビ)は非公開にする
   */
  public static function updReleaseflagOff($arrProjectManagementNo)
  {
    $record = \DB::table('project')
      ->whereNotNull('project_management_no')
      ->whereNotIn('project_management_no', $arrProjectManagementNo)
      ->update(['release_flag' => 0]);
  }

  /*
   * 条件変更に合わせた案件
   * @param   array $search_condition search_project_condition::getCodeCategoryArrayの結果
   * @param   int   $worker_id        $logininfo['worker_id']
   * @param   int   $age              $logininfo['age']
   * @return  Collection
   */
  public static function getProjectIdsByEngineerSearchCondition($search_condition, $worker_id)
  {
    $select = '
      p.project_id,
      p.title,
      p.project_outline,
      mj.job_name,
      mp.prefecture_name,
      p.nearest_station,
      m_code_monthly_income.display_name AS monthly_income,
      c.company_name,
      GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
    ';

    // メインクエリ
    $data = DB::table('project AS p')
      ->select(DB::RAW($select))
      ->join('worker_matching_score_to_project AS wmstp', function ($join) use ($worker_id) {
        $join->on('wmstp.project_id', '=', 'p.project_id')
          // ->where('wmstp.mail_send_flag', 0)
          ->where('wmstp.worker_id', $worker_id);
      })
      ->leftjoin('m_code AS m_code_monthly_income', function ($join) {
        $join->on("m_code_monthly_income.code", "=", "p.monthly_income")
          ->where('m_code_monthly_income.category', '=', config('const.CATEGORY')['MONTHLY_INCOME']);
      })
      ->join('company AS c', 'p.company_id', '=', 'c.company_id')
      ->leftjoin('m_job AS mj', 'p.job_id', '=', 'mj.job_id')
      ->leftjoin('m_prefecture AS mp', 'p.prefecture_id', '=', 'mp.prefecture_id')
      ->leftjoin('project_skill AS ps_where', 'p.project_id', 'ps_where.project_id')
      ->leftjoin('project_skill AS ps', 'p.project_id', 'ps.project_id')
      ->leftjoin('m_skill', 'ps.skill_id', 'm_skill.skill_id');


    if (isset($search_condition['job'])) {
      $data = $data->whereIn('p.job_id', $search_condition['job']);
    }

    if (isset($search_condition['prefecture'])) {
      $data = $data->whereIn('p.prefecture_id', $search_condition['prefecture']);
    }

    if (isset($search_condition['monthly_income'])) {
      $data = $data->whereRaw('CONVERT(p.monthly_income_min, unsigned) >= ' . $search_condition['monthly_income'][0]);
    }

    if (isset($search_condition['contract_type'])) {
      $data = $data->whereIn('p.contract_type', $search_condition['contract_type']);
    }

    if (isset($search_condition['skill'])) {
      $data = $data->whereIn('ps_where.skill_id', $search_condition['skill']);
    }

    $data = $data->where('p.del_flag', 0)
      ->where('p.release_flag', 1)
      ->groupBy('p.project_id')
      ->orderBy('wmstp.matching_score', 'desc')
      ->get();

    return $data;
  }

  /*
   * 新規登録
   */
  public static function insert($data)
  {
    \DB::table('project')->insert($data);
    $id = \DB::getPdo()->lastInsertId();

    return $id;
  }

  /*
   * 更新
   */
  public static function up($data)
  {

    try {
      \DB::table('project')->where("project_id", $data['project_id'])
        ->update($data);
    } catch (\Exception $e) {
      throw $e;
    }

    return true;
  }

  /*
   * トータル案件数取得
   */
  public static function totalProjects($release_flag = 1)
  {
    $select = '
      count(*) as totalProjects
    ';

    $data = DB::table('project AS p')
      ->select(DB::RAW($select))
      ->where('del_flag', 0);

    if ($release_flag == 1) {
      $data = $data->where('release_flag', $release_flag);
    }
    $data = $data->get();

    return $data[0]->totalProjects;
  }

  public static function getPrivateProjects()
  {
    $select = '
      count(*) as privateProjects
    ';

    $data = DB::table('project AS p')
      ->select(DB::RAW($select))
      ->where('del_flag', 0)
      ->where('release_flag', 0);

    $data = $data->get();

    return $data[0]->privateProjects;
  }

  public static function updateRecruitmentEndFlag($media_id, $media_project_id)
  {

    $inClause = substr(str_repeat(',?', count($media_project_id)), 1);

    $sql = '
    UPDATE
	      project
    SET
	      recruitment_end_flag = 1
    WHERE
	      project_id IN (
		        SELECT tmp.project_id
	          FROM(
	              SELECT
 		                project_id
	              FROM
		                project AS p1
	              WHERE NOT EXISTS(
		                SELECT
			                  p1.project_id
		                FROM
			                  project AS project_sub
                    WHERE
			                      p1.media_project_id IN ( ' . $inClause . ' )
			                  AND p1.project_id = project_sub.project_id
		            )
	              AND p1.media_id = ?
	          ) AS tmp
        )
    ';

    $tmp = $media_project_id;
    $tmp[] = $media_id;
    $ret = DB::update($sql, $tmp);
    return $ret;
  }


  public static function getFavoritesCount($search = array())
  {
    $select = '*';
    if (isset($search['worker_id'])) {
      $select .= ',CASE
          WHEN wf.worker_id IS NULL THEN 0
          ELSE 1
          END AS favorite
          ,wmstp.matching_score
          ';
      $worker_id = $search['worker_id'];
    } else {
      $worker_id = 0;
    }
    $data = DB::table('project')
      ->select(DB::RAW($select))
      ->leftjoin('worker_favorite AS wf', function ($join) use ($worker_id) {
        $join->on('wf.target_id', '=', 'project.project_id')->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['PROJECT']);
      })
      ->where('project.recruitment_end_flag', 0)
      ->where('project.del_flag', 0);
    // お気に入り案件表示
    if (isset($search['favoriteListFlag'])) {
      $data = $data->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['PROJECT']);
    }
    return $data->count();
  }


  public static function searchProjectName($title)
  {
    $select = 'project_id,title';
    $data = DB::table('project')
      ->select(DB::RAW($select))
      ->where('project.recruitment_end_flag', 0)
      ->where('project.del_flag', 0);


    if ($title) {
      $data = $data->Where('project.title', 'like', '%' . $title . '%');
    }
    $data = $data->orderBy('create_date', 'desc')
      ->limit(config('const.DEFAULT_SUGGEST_COUNT'));
    $data = $data->get();

    return $data;
  }

  public static function getInterviewTargetProject($search = [], $limit = 15)
  {
    $select = "
         p.project_id
        ,p.project_manager_id
        ,p.title
        ,p.settlement_time
        ,settlement_time.display_name AS settlement_time_name
        ,p.settlement_time_min
        ,p.settlement_time_max
        ,p.payment_terms
        ,p.recruitment_number
        ,m_job.job_category_id
        ,m_job.job_name
        ,m_prefecture.prefecture_name
        ,m_job_category.abbreviated_name AS job_category_abbreviated_name
        ,monthly_income.display_name AS monthly_income
        ,m_station.station_name AS nearest_station_name
        ,m_station.line_name AS nearest_station_line_name
        ,contract_type.display_name AS contract_type_name
        ,p.work_start_date
        ,DATE_FORMAT(p.work_start_date,'%Y年%m月%d日') as work_start_date_jp
        ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_names
        ,working_system.display_name AS working_system_name
        ,contract_period.display_name AS contract_period_name
    ";

    if (array_key_exists("worker_id", $search) && $search['worker_id']) {
      $select .= ',wmstp.matching_score AS matching_score';
    } else {
      $select .= ',NULL AS matching_score';
    }

    $data = DB::table('project AS p')
      ->select(DB::RAW($select))
      ->leftjoin('project_skill AS skill', function ($join) {
        $join->on('skill.project_id', '=', 'p.project_id')
          ->where('skill.priority', 0);
      })
      ->leftjoin('company AS c', 'c.company_id', "=", "p.company_id")
      ->leftjoin('m_skill AS m_skill', 'skill.skill_id', "=", "m_skill.skill_id")
      ->leftjoin('m_station as m_station', 'm_station.station_id', '=', 'p.nearest_station')
      ->leftjoin('m_prefecture AS m_prefecture', 'm_prefecture.prefecture_id', "=", "p.prefecture_id")
      ->leftjoin('m_job AS m_job', 'm_job.job_id', "=", "p.job_id")
      ->leftjoin('m_job_category AS m_job_category', 'm_job.job_category_id', "=", "m_job_category.job_category_id")
      ->leftjoin('m_code AS contract_type', function ($join) {
        $join->on("contract_type.code", "=", "p.contract_type")
          ->where('contract_type.category', '=', config('const.CATEGORY')['CONTRACT_TYPE']);
      })
      ->leftjoin('m_code AS contract_period', function ($join) {
        $join->on("contract_period.code", "=", "p.contract_period")
          ->where('contract_period.category', '=', config('const.CATEGORY')['CONTRACT_PERIOD']);
      })
      ->leftjoin('m_code AS settlement_time', function ($join) {
        $join->on("settlement_time.code", "=", "p.settlement_time")
          ->where('settlement_time.category', '=', config('const.CATEGORY')['SETTLEMENT_TIME']);
      })
      ->leftjoin('m_code AS working_system', function ($join) {
        $join->on("working_system.code", "=", "p.working_system")
          ->where('working_system.category', '=', config('const.CATEGORY')['WORKING_SYSTEM']);
      })
      ->leftjoin('m_code AS monthly_income', function ($join) {
        $join->on("monthly_income.code", "=", "p.monthly_income")
          ->where('monthly_income.category', '=', config('const.CATEGORY')['MONTHLY_INCOME']);
      })
      ->leftjoin("business_talk_status AS bts", function ($join) {
        $join->on("bts.project_id", "=", "p.project_id")
          ->where("bts.lost_flag", "=", 0)
          ->where("bts.del_flag", "=", 0);
      })
      ->where('p.recruitment_end_flag', 0)
      ->where('p.del_flag', 0)
      ->whereRaw('p.media_id IS NULL')
      ->groupBy('p.project_id');

    // フリーワード
    if (isset($search['searchKeyword']) && $search['searchKeyword']) {
      $keywords = $search['searchKeyword'];
      if (is_string($keywords)) {
        $keywords = preg_split("/\s+/u", trim(mb_convert_kana($search['searchKeyword'], 's')));
      }
      foreach ($keywords as $index => $keyword) {
        $data = $data->where(function ($data) use ($keyword) {
          $data->orWhere('p.title', 'like', '%' . $keyword . '%')
            ->orWhere('m_prefecture.prefecture_name', 'like', '%' . $keyword . '%')
            ->orWhere('m_skill.skill_name', 'like', '%' . $keyword . '%')
            ->orWhere('m_job.job_name', 'like', '%' . $keyword . '%');
        });
      }
    }

    // ステータス検索
    if (array_key_exists("business_talk_status", $search) && $search['business_talk_status']) {
      $data = $data->where("bts.phase", "=", $search['business_talk_status']);
    }

    // 自社に限定するかどうか
    if (array_key_exists("filter_own_company", $search) && (bool) $search['filter_own_company']) {
      $data = $data->where("c.company_id", "=", $search['company_id']);
    } else {
      $data = $data->where(function ($query) use ($search) {
        $query->orWhere("c.company_id", "=", $search['company_id'])
          ->orWhere("p.release_flag", 1);
      });
    }

    // 人材で検索
    if (array_key_exists("worker_id", $search) && $search['worker_id']) {
      // TODO: マッチング率順にする
      $data = $data->leftjoin('worker_matching_score_to_project AS wmstp', function ($join) use ($search) {
        $join->on('wmstp.project_id', '=', 'p.project_id')->where('wmstp.worker_id', '=', $search['worker_id']);
      })
      ->orderBy('wmstp.matching_score', 'DESC');
    }

    $data = $data->orderBy('p.create_date', 'DESC')->limit($limit);
    return $data->get();
  }

  public static function getMyProjectForAgent($user_company_id)
  {
    $select = 'project_id,title';
    $data = DB::table('project')
      ->select(DB::RAW($select))
      ->where('project.project_manager_id', $user_company_id)
      ->where('project.del_flag', 0)
      ->whereRAW('project.media_id IS NULL')
      ->orderBy('create_date', 'desc');

    $data = $data->get();

    return $data;
  }

  public static function getMyProjectThisMonth($user_company_id)
  {
    $select = 'project_id';
    $data = DB::table('project')
      ->select(DB::RAW($select))
      ->whereRaw("DATE_FORMAT(project.create_date, '%Y-%m-%d') BETWEEN DATE_FORMAT(curdate(), '%Y-%m-01') AND DATE_FORMAT(LAST_DAY(curdate()), '%Y-%m-%d')")
      ->where('project.project_manager_id', $user_company_id)
      ->where('project.del_flag', 0)
      ->whereRAW('project.media_id IS NULL')
      ->orderBy('create_date', 'desc');

    $data = $data->get();

    return $data;
  }
}
