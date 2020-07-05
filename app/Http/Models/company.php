<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class company extends Model
{

  static $company_count = null;
  static $company_disp_count = null;
  protected $table = 'company';
  protected $guarded = ['company_id'];
  public $timestamps = false;

  /*
   * 企業一覧取得
   */

  public static function get($search = array(), $limit = null, $loginInfo = null)
  {
    $select = "company.company_id
              ,company.company_caption
              ,company.company_name
              ,company.industry
              ,company.establishment_date
              ,company.employees_number
              ,company.capital
              ,company.sales
              ,company.hp_url
              ,company.cover_image
              ,company.address
              ,company.postal_code
              ,company.city_id
              ,company.rep_name
              ,m_city.city_name
              ,m_code_industry.display_name AS industry_name
              ,CASE
                WHEN company.del_flag IS NULL THEN 0
                ELSE company.del_flag
                END del_flag
              ,CASE
                WHEN company.pickup_flag IS NULL THEN 0
                ELSE company.pickup_flag
                END pickup_flag
              ,CASE
                WHEN company.release_flag IS NULL THEN 0
                ELSE company.release_flag
                END release_flag
              ,LEFT(company.business_type,2) AS business_type_id
              ,m_prefecture.prefecture_name
              ,CASE
                WHEN m_code_business_type.display_name IS NULL THEN'非公開'
                ELSE m_code_business_type.display_name
                END AS business_type
              ,CASE
                WHEN logo_image IS NULL THEN NULL
                ELSE logo_image
                END AS logo_image
              ,CASE
                WHEN m_prefecture.prefecture_name IS NULL THEN '非公開'
                ELSE m_prefecture.prefecture_name
                END AS prefecture_name
              ,CASE
                WHEN project_count.project_count IS NULL THEN 0
                ELSE project_count.project_count
                END AS project_count
    ";

    $projectCountQeury = '(
              SELECT COUNT(company_id) project_count,company_id
              FROM project
              WHERE del_flag = 0
              GROUP BY company_id
    )';

    $companies = DB::table('company')
      ->select(DB::raw($select))
      ->leftjoin('m_city', 'company.city_id', 'm_city.city_id')
      ->leftjoin('m_prefecture', 'm_prefecture.prefecture_id', "=", "company.prefecture_id")
      ->leftjoin('m_code AS m_code_business_type', function ($join) {
        $join->on('m_code_business_type.code', "=", "company.business_type")
          ->where("m_code_business_type.category", "=", config('const.CATEGORY')['BUSINESS_TYPE']);
      })
      ->leftjoin('m_code AS m_code_industry', function ($join) {
        $join->on('m_code_industry.code', "=", "company.industry")
          ->where("m_code_industry.category", "=", config('const.CATEGORY')['INDUSTRY']);
      })
      ->leftjoin(DB::RAW($projectCountQeury . ' AS project_count'), 'project_count.company_id', '=', 'company.company_id')
      ->where('company.del_flag', 0);


      // フリーワード検索
    if (array_key_exists('searchKeyword', $search) && $search['searchKeyword'] != 'null') {
      $keywords = $search['searchKeyword'];
      if(is_string($keywords)) {
        $keywords = preg_split("/\s+/u", trim(mb_convert_kana($search['searchKeyword'], 's')));
      }
      foreach ($keywords as $index => $keyword) {
        $companies = $companies->where(function ($companies) use ($keyword) {
          $companies->orWhere('company.company_name', 'like', '%' . $keyword . '%');
          $companies->orWhere('m_prefecture.prefecture_name', 'like', '%' . $keyword . '%');
          $companies->orWhere('m_code_business_type.display_name', 'like', '%' . $keyword . '%');
          //一覧表示に企業内容は含まれていない為、一旦コメントアウト
            // ->orWhere('company.company_caption', 'like', '%' . $keyword . '%');
        });
      }
    }

    if (array_key_exists('business_type', $search) && $search['business_type'] != '') {
      // $companies = $companies->where('business_type', $search['business_type']);
      // 複数対応
      $companies = $companies->whereIn('business_type', $search['business_type']);
    }

    if (array_key_exists('prefecture_id', $search) && $search['prefecture_id']) {
      // $companies = $companies->where('company.prefecture_id', $search['prefecture_id']);
      // 複数対応
      $companies = $companies->whereIn('company.prefecture_id', $search['prefecture_id']);
    }

    // if (array_key_exists('pickup_flag', $search)) {
    //   $companies = $companies->where('company.pickup_flag', $search['pickup_flag']);
    // }

    if ($loginInfo['admin_flag'] != config('const.USER_TYPE')['COMPANY']) {
      $companies = $companies->where('company.release_flag', 1);
    }
    // $companies = $companies->orderby('company.create_date', 'desc');

    //ソート順が指定されている場合
    if (isset($search["sort"])) {
      if ($search["sort"] == "new") {
        $companies = $companies->orderby('company.create_date', 'desc');
      } elseif ($search['sort'] == 'pickup') {
        // 企業にレビューはない為、並び替えピックアップは一旦flagで管理
        // $companies = $companies->orderby('reviews.review_rating', 'desc');
        $companies = $companies->orderby('company.pickup_flag', 'desc');
      } else {
        $companies = $companies->orderby('company.create_date', 'desc');
      }
    } else {
      $companies = $companies->orderby('company.create_date', 'desc');
    }

    //全体の合計数を取得
    self::$company_count = $companies->count();
    //検索件数指定
    if (array_key_exists("where", $search)) {
      $companies = $companies->paginate();
    } else {
      $companies = $companies->paginate(config('const.DEFAULT_SEARCH_COUNT')['GENERAL']);
    }

    self::$company_disp_count = $companies->count();

    return $companies;
  }

  /*
   * 企業一覧(id,name)
   */
  public static function getCompanyList()
  {
    $select = "company.company_id
              ,company.company_caption
              ,company.company_name
              ";

    $companies = DB::table('company')
      ->select(DB::raw($select))
      ->where('del_flag', 0)
      ->orderby('company.create_date', 'desc')
      ->get();

    return $companies;
  }

  /*
   * 企業詳細データ取得
   */
  public static function getDetail($company_id)
  {

    $select = "company.company_id
              ,company.business_type
              ,company.industry
              ,company.company_name
              ,company.company_name_ruby
              ,company.prefecture_id
              ,company.city_id
              ,company.address
              ,company.address2
              ,company.postal_code
              ,company.billing_prefecture_id
              ,company.billing_city_id
              ,company.billing_address
              ,company.billing_address2
              ,company.billing_postal_code
              ,company.billing_name
              ,company.billing_department
              ,company.billing_position
              ,company.billing_address_same_flag
              ,company.hp_url
              ,company.movie_url
              ,company.rep_name
              ,company.rep_name_ruby
              ,company.rep_dep_name
              ,company.rep_email
              ,company.rep_phone_number
              ,company.rep_position
              ,company.establishment_date
              ,company.employees_number
              ,company.capital
              ,company.sales
              ,company.company_caption
              ,company.company_document
              ,company.latitude
              ,company.longitude
              ,company.cover_image
              ,company.logo_image
              ,company.release_flag
              ,company.registration_phase
              ,m_city.city_name
              ,CASE
                WHEN logo_image IS NULL THEN NULL
                ELSE logo_image
                END AS logo_image
              ,CASE
                WHEN m_prefecture.prefecture_name IS NULL THEN ''
                ELSE m_prefecture.prefecture_name
                END AS prefecture_name
              ,CASE
                WHEN m_city.city_name IS NULL THEN ''
                ELSE m_city.city_name
                END AS city_name
              ,CASE
                WHEN m_prefecture2.prefecture_name IS NULL THEN ''
                ELSE m_prefecture2.prefecture_name
                END AS billing_prefecture_name
              ,CASE
                WHEN m_city2.city_name IS NULL THEN ''
                ELSE m_city2.city_name
                END AS billing_city_name
              ,CASE
                WHEN m_code_business_type.display_name  IS NULL THEN ''
                ELSE m_code_business_type.display_name
                END AS business_type_name
              ,CASE
                WHEN m_code_industry.display_name  IS NULL THEN ''
                ELSE m_code_industry.display_name
                END AS industry_name
    ";

    $company = DB::table('company')
      ->select(DB::raw($select))
      ->leftjoin('m_prefecture as m_prefecture', 'm_prefecture.prefecture_id', "=", "company.prefecture_id")
      ->leftjoin('m_city as m_city', 'm_city.city_id', '=', 'company.city_id')
      ->leftjoin('m_prefecture as m_prefecture2', 'm_prefecture2.prefecture_id', "=", "company.billing_prefecture_id")
      ->leftjoin('m_city as m_city2', 'm_city2.city_id', '=', 'company.billing_city_id')
      ->leftjoin('m_code AS m_code_business_type', function ($join) {
        $join->on('m_code_business_type.code', "=", "company.business_type")
          ->where("m_code_business_type.category", "=", config('const.CATEGORY')['BUSINESS_TYPE']);
      })
      ->leftjoin('m_code AS m_code_industry', function ($join) {
        $join->on('m_code_industry.code', "=", "company.industry")
          ->where("m_code_industry.category", "=", config('const.CATEGORY')['INDUSTRY']);
      })
      ->where('company.company_id', $company_id)
      ->where('company.del_flag', '0')
      ->get();

    if (count($company) <= 0) {
      return false;
    }

    return $company[0];
  }

      /*
   * ワーカーの条件に会う企業
   */
  public static function getWorkerConditionMatchUserCompany($worker_id){

        $sql = '
      SELECT *
      FROM (
              SELECT DISTINCT company.user_company_id
              FROM (
                      SELECT worker.*
                            ,ws.skill_id
                            ,w_job.desired_job_id
                            ,w_place.prefecture_id AS desired_prefecture_id
                      FROM worker
                      LEFT JOIN worker_skill AS ws
                             ON worker.worker_id = ws.worker_id
                      LEFT JOIN worker_desired_job AS w_job
                             ON worker.worker_id = w_job.worker_id
                      LEFT JOIN worker_desired_workingplace AS w_place
                             ON worker.worker_id = w_place.worker_id
                      WHERE worker.worker_id = ?
              ) AS worker
              CROSS JOIN (
                      SELECT company.company_id
                            ,uc.user_company_id
                            ,uc.email
                            ,COUNT(con.category = "job_id" OR NULL) AS job_id_count
                            ,COUNT(con.category = "prefecture_id" OR NULL) AS prefecture_id_count
                            ,COUNT(con.category = "skill_id" OR NULL) AS skill_id_count
                            ,COUNT(con.category = "business_type" OR NULL) AS business_type_count
                            ,COUNT(con.category = "contract_type" OR NULL) AS contract_type_count
                            ,COUNT(con.category = "annual_income_min" OR NULL) AS annual_income_min_count
                            ,COUNT(con.category = "annual_income_max" OR NULL) AS annual_income_max_count
                      FROM company
                      JOIN user_company uc
                        ON uc.company_id = company.company_id
                      LEFT JOIN search_worker_condition AS con
                      	ON con.user_company_id = uc.user_company_id
                      GROUP BY uc.user_company_id
              ) AS company
              WHERE (
                      worker.desired_job_id IN (
                              SELECT code
                              FROM search_worker_condition AS con
                              WHERE con.user_company_id = company.user_company_id
                              AND con.category = "job_id"
                      )
                      OR company.job_id_count = 0
              )
              AND (
                      worker.desired_prefecture_id IN (
                              SELECT code
                              FROM search_worker_condition AS con
                              WHERE con.user_company_id = company.user_company_id
                              AND con.category = "prefecture_id"
                      )
                      OR company.prefecture_id_count = 0
              )
              AND (
                      worker.skill_id IN (
                              SELECT code
                              FROM search_worker_condition AS con
                              WHERE con.user_company_id = company.user_company_id
                              AND con.category = "skill_id"
                      )
                      OR company.skill_id_count = 0
              )
              AND (
                      worker.desired_contract_type IN (
                              SELECT code
                              FROM search_worker_condition AS con
                              WHERE con.user_company_id = company.user_company_id
                              AND con.category = "contract_type"
                      )
                      OR company.contract_type_count = 0
              )
      ) AS user_company_data
      LEFT JOIN user_company ON user_company.user_company_id = user_company_data.user_company_id
        ';

    $user_company = DB::select($sql, [$worker_id]);

    return $user_company;
  }

  /*
   * 企業論理削除
   */
  public static function del($company_id)
  {

    try {
      // 処理
      DB::table('company')
        ->where('company_id', $company_id)
        ->update(['del_flag' => 1]);
    } catch (\Exception $e) {
      // 例外処理
      return json_decode(false);
    }


    return json_decode(true);
  }

  /*
   * insert or update判定
   */
  public static function upsert($data)
  {
    try {
      $record = \DB::table('company')->select("company_id")
        ->where('company_name', $data['company_name'])
        ->where('business_type', $data['business_type'])
        ->where('establishment_date', $data['establishment_date']);

      if ($record->exists()) {
        $data['company_id'] = $record->get()[0]->company_id;
        $record->update($data);
        return $data['company_id'];
      } else {
        return $record->insertGetId($data);
      }
    } catch (\Exception $e) {
      throw $e;
    }
  }

  /*
   * 新規登録
   */
  public static function insert($data)
  {
    try {
      $record = \DB::table('company')->insertGetId($data);
    } catch (\Exception $e) {
      return null;
    }

    return $record;
  }

  /*
   * 更新
   */
  public static function up($data)
  {

    try {
      \DB::table('company')->where("company_id", $data['company_id'])
        ->update($data);
    } catch (\Exception $e) {
      throw $e;
    }
    return true;
  }

  public static function getCompanyByCompanyId($company_id)
  {
    $select = "company.company_id
              ,company.company_name
              ";

    $company = DB::table('company')
            ->select(DB::raw($select))
            ->where('company.del_flag', 0)
            ->where('company.company_id', $company_id)
            ->orderby('company.create_date', 'desc')
            ->get();

    if (count($company) > 0) {
      return $company[0];
    } else {
      return false;
    }
  }

  public static function getCompanyRepUser($company_id)
  {
    $select = "company.company_id
              ,company.company_caption
              ,company.company_name
              ,CONCAT(user_company.last_name, user_company.first_name) AS full_name
              ,user_company.email
              ";

    $company = DB::table('company')
      ->select(DB::raw($select))
      ->leftjoin('user_company', 'company.company_id', '=', 'user_company.company_id')
      ->where('company.del_flag', 0)
      ->where('user_company.del_flag', 0)
      ->where('company.company_id', $company_id)
      ->orderby('company.create_date', 'desc')
      ->get();

    if (count($company) > 0) {
      return $company[0];
    } else {
      return self::getUserCompany(config('const.EIGHT_COMPANY_ID'));
    }
  }

  public static function getUserCompany($company_id)
  {
    $select = "company.company_id
              ,company.company_name
              ,company.logo_image
              ,company.latitude
              ,company.longitude
              ,company.postal_code
              ,company.registration_phase
              ,user_company.user_company_id
              ,CONCAT(user_company.last_name, user_company.first_name) AS full_name
              ,m_prefecture.prefecture_name
              ,m_city.city_name
              ,address AS address";

    $company = DB::table('company')
      ->select(DB::raw($select))
      ->leftjoin('user_company', 'company.company_id', '=', 'user_company.company_id')
      ->leftjoin('m_prefecture', 'm_prefecture.prefecture_id', '=', 'company.prefecture_id')
      ->leftjoin('m_city', 'm_city.city_id', '=', 'company.city_id')
      ->where('company.del_flag', 0)
      ->where('user_company.del_flag', 0)
      ->where('company.company_id', $company_id)
      ->get();

    if (count($company) > 0) {
      return $company[0];
    } else {
      return self::getUserCompany(config('const.EIGHT_COMPANY_ID'));
    }
  }

  public static function getUserCompanies($company_id)
  {
    $select = "company.company_id
              ,company.company_name
              ,user_company.user_company_id
              ,CONCAT(user_company.last_name, user_company.first_name) AS full_name
              ,user_company.email
              ,m_prefecture.prefecture_name
              ,m_city.city_name
              ,address AS address";

    $company = DB::table('company')
      ->select(DB::raw($select))
      ->leftjoin('user_company', 'company.company_id', '=', 'user_company.company_id')
      ->leftjoin('m_prefecture', 'm_prefecture.prefecture_id', '=', 'company.prefecture_id')
      ->leftjoin('m_city', 'm_city.city_id', '=', 'company.city_id')
      ->where('company.del_flag', 0)
      ->where('user_company.del_flag', 0)
      ->where('company.company_id', $company_id)
      ->get();

    if (count($company) > 0) {
      return $company;
    }
  }

  public static function getCompaniesInMap($data)
  {
    /*
     * TODO:
     * -何を表示するか決める
     */

    $select = "*
              ";

    $company = DB::table('company')
            ->select(DB::raw($select))
            ->whereBetween('latitude', [$data['s'], $data['n']])
            ->whereBetween('longitude', [$data['w'], $data['e']])
            ->where('release_flag', 1)
            ->where('del_flag', 0)
            ;

    if(isset($data['business_type']) && $data['business_type']) {
      $company = $company->where('business_type', $data['business_type']);
    }

      $company = $company->get();

      if(count($company) > 0) {
        return $company;
      }
  }

  public static function searchCompanyName($name = '', $search = []){
    $select = 'c.company_id,c.company_name';
    
  
    if(isset($search['without_account']) && $search['without_account']) {
      $select .= ',count(uc.user_company_id) AS user_count';
    }
    
    $data = DB::table('company AS c')
      ->select(DB::RAW($select))
      ->where('c.del_flag', 0);
    
    if($name){
      $data = $data->where('c.company_name', 'like', '%' . $name . '%');
    }
  
    if(isset($search['without_account']) && $search['without_account']) {
      $data = $data
        ->leftjoin('user_company AS uc', 'uc.company_id', '=', 'c.company_id')
        ->groupby('c.company_id')
        ->having('user_count', '=', 0);
      if(isset($search['company_id']) && $search['company_id']) {
        $data = $data->orHaving('c.company_id', '=', $search['company_id']);
      }
    }
  
    $data = $data
      ->orderBy('c.create_date','desc')
      ->limit(5);
    $data = $data->get();
    

    return $data;
  }

  public static function getTradingCompanyByWorker($worker_id){


    $select = 'company.company_id,company.company_name';
    $entry = DB::table('company')
            ->distinct()
            ->select(DB::RAW($select))
            ->join('user_company', 'user_company.company_id', "=", 'company.company_id')
            ->join('offer_to_worker','offer_to_worker.user_company_id', '=', 'user_company.user_company_id')
            ->where('offer_to_worker.worker_id', $worker_id)
            ->where('company.del_flag', 0)
            ->where('offer_to_worker.del_flag', 0)
    ;

    $offer = DB::table('company')
            ->distinct()
            ->select(DB::RAW($select))
            ->join('project', 'project.company_id', "=", 'company.company_id')
            ->join('offer','offer.project_id', '=', 'project.project_id')
            ->where('offer.worker_id', $worker_id)
            ->where('company.del_flag', 0)
            ->where('offer.del_flag', 0)
            ->union($entry)
    ;

    $offer = $offer->get();

    return $offer;
  }

  /*
   * insert or update判定
   * 他社メディアからクローラーで取得したCSVデータ取込時に使用
   */
  public static function upsertForThirdPatyMedia($data)
  {
    $record = \DB::table('company')->select("company_id")
            ->where('media_company_id', $data['media_company_id'])
            ->where('media_id', $data['media_id']);

    if ($record->exists()) {
      $data['company_id'] = $record->get()[0]->company_id;
      $record->update($data);
      return $data['company_id'];
    } else {
      return $record->insertGetId($data);
    }
  }

  /*
   * insert or update判定
   * ようかんから取得したCSVデータ取込時に使用
   */
  public static function upsertYoukanCompanyCsv($data)
  {
    $record = \DB::table('company')->select("company_id")
            ->where('company_name', $data["company_name"])
            ->where('media_id', $data['media_id']);
    if ($record->exists()) {
      $data['company_id'] = $record->get()[0]->company_id;
      $record->update($data);
      return $data['company_id'];
    } else {
      return $record->insertGetId($data);
    }
  }

}
