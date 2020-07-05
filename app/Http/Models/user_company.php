<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;

class user_company extends Model implements AuthenticatableContract, CanResetPasswordContract
{

  use Authenticatable,
          CanResetPassword;

  protected $table = 'user_company';
  protected $primaryKey = 'user_company_id';
  public $timestamps = false;
  protected $fillable = [
          'email', 'password',
  ];

  static $usercompany_count = null;


  /*
   * 有効な企業アカウント取得
   */
  public static function getUserCompanyList($search = array()){
    $select = '
       u.user_company_id
      ,u.age
      ,u.sex
      ,u.last_name
      ,u.first_name
      ,u.email
      ,CONCAT(u.last_name, u.first_name) AS full_name
      ,u.catch_phrase
      ,u.self_introduction
      ,u.logo_image AS user_company_logo_image
      ,c.company_id
      ,c.business_type
      ,c.company_name
      ,c.logo_image AS company_logo_image
      ,m_prefecture.prefecture_name
      ,m_city.city_name
      ,m_code_business_type.display_name AS business_type_name
      ,GROUP_CONCAT(DISTINCT m_job.job_name) AS specialty_names
      ,GROUP_CONCAT(DISTINCT prefecture.prefecture_name) AS responsible_area_names
      ,COUNT(project.project_id) AS projectCount
      ,DATE_FORMAT(u.create_date,\'%Y年%m月%d日\') AS create_date
      ,3.0 AS review_rating
      ,u.agent_flag AS release_flag
    ';
    if(isset($search['worker_id'])) {
      $select .= ',CASE
          WHEN wf.worker_id IS NULL THEN 0
          ELSE 1
          END AS favorite
          ';
      $worker_id = $search['worker_id'];
    } else {
      $worker_id = 0;
    }
    if (isset($search['user_company_id'])) {
      $select .= ',CASE
          WHEN ucf.user_company_id IS NULL THEN 0
          ELSE 1
          END AS favorite
          ';
      $user_company_id = $search['user_company_id'];
    } else {
      $user_company_id = 0;
    }

    $data = DB::table('user_company AS u')
            ->select(DB::RAW($select))
            ->join('company AS c', function ($join) {
              $join->on("c.company_id", "=", "u.company_id")->where('c.del_flag', 0)->where('c.release_flag', 1);
            })
            ->leftjoin('m_prefecture', 'm_prefecture.prefecture_id','=', "c.prefecture_id")
            ->leftjoin('m_city', 'm_city.city_id','=', "c.city_id")
            ->leftjoin('project',  function ($join) {
              $join->on('project.project_manager_id', "=", "u.user_company_id")
                      ->where('project.release_flag', "=", 1)
                      ->where("project.del_flag", "=", 0);
            })
            ->leftjoin('m_code AS m_code_business_type', function ($join) {
              $join->on('m_code_business_type.code', "=", "c.business_type")
                      ->where("m_code_business_type.category", "=", config('const.CATEGORY')['BUSINESS_TYPE']);
            })
            ->leftjoin('offer_to_worker AS otw', function ($join) {
              $join->on('otw.user_company_id', '=', 'u.user_company_id')->where('otw.del_flag', '0');
            })
            ->leftjoin('user_company_specialty AS specialty', 'specialty.user_company_id', '=', 'u.user_company_id')
            ->leftjoin('m_job', 'specialty.specialty_id', "=", "m_job.job_id")
            ->leftjoin('user_company_responsible_area AS responsible_area', 'responsible_area.user_company_id', '=', 'u.user_company_id')
            ->leftjoin('m_prefecture AS prefecture', 'prefecture.prefecture_id', '=', 'responsible_area.prefecture_id')
            ->where('u.authenticated_flag', 1)
            ->where('u.del_flag', '0')
    ;

    // ログインユーザがエンジニアの時
    if($worker_id) {
      $data = $data
            ->leftjoin('worker_favorite AS wf', function ($join) use ($worker_id) {
              $join->on('wf.target_id', '=', 'u.user_company_id')->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
            })
            ->leftjoin('user_company_favorite AS ucf', function ($join) {
              $join->on('ucf.user_company_id', '=', 'u.user_company_id')->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
            });

      // お気に入りしているエージェント取得
      if(array_key_exists("favoriteListFlag",$search) && $search['favoriteListFlag']){
        $data = $data ->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
      }

      // お気に入りされているエージェント取得
      if(array_key_exists("favoritedListFlag",$search) && $search['favoritedListFlag']){
        $data = $data ->where('ucf.target_id', '=', $worker_id);
      }

      // 特定の人材にオファーしたエージェント取得
      if(array_key_exists("offeredListFlag",$search) && $search['offeredListFlag']){
        $data = $data ->where('otw.worker_id', '=', $worker_id);
      }
    } elseif($user_company_id) {
    // ログインユーザがエージェントの時
      $data = $data
            ->leftjoin('user_company_favorite AS ucf', function ($join) use ($user_company_id) {
              $join->on('ucf.target_id', '=', 'u.user_company_id')->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
            })
            ->leftjoin('user_company_favorite AS ucf2', function ($join) {
              $join->on('ucf2.user_company_id', '=', 'u.user_company_id')->where('ucf2.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
            });

      // お気に入りしているエージェント取得
      if(array_key_exists("favoriteListFlag",$search) && $search['favoriteListFlag']){
        $data = $data ->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
      }

      // お気に入りされているエージェント取得
      if(array_key_exists("favoritedListFlag",$search) && $search['favoritedListFlag']){
        $data = $data ->where('ucf2.target_id', '=', $user_company_id);
      }
    }


    // フリーワード検索
    if(array_key_exists("searchKeyword",$search) && $search['searchKeyword']){
      $keywords = $search['searchKeyword'];
      if(is_string($keywords)) {
        $keywords = preg_split("/\s+/u", trim(mb_convert_kana($search['searchKeyword'], 's')));
      }
      foreach ($keywords as $index => $keyword) {
        $data = $data->where(function ($data) use ($keyword) {
          $data->orWhere('u.last_name', 'like', '%' . $keyword . '%')
            ->orWhere('u.first_name', 'like', '%' . $keyword . '%')
            ->orWhere('prefecture.prefecture_name', 'like', '%' . $keyword . '%')
            ->orWhere('m_city.city_name', 'like', '%' . $keyword . '%');
        });
      }
    }

    // 投稿日指定がある場合
    if (array_key_exists("post_date", $search) && $search['post_date']) {
      if ($search['post_date'] == '1') {
        $data = $data->whereRaw("DATE_ADD(u.create_date, INTERVAL 24 HOUR) > NOW()");
      } elseif ($search['post_date'] == '2') {
        $data = $data->whereRaw("DATE_ADD(u.create_date, INTERVAL 7 DAY) > NOW()");
      } elseif ($search['post_date'] == '3') {
        $data = $data->whereRaw("DATE_ADD(u.create_date, INTERVAL 14 DAY) > NOW()");
      } elseif ($search['post_date'] == '4') {
        $data = $data->whereRaw("DATE_ADD(u.create_date, INTERVAL 30 DAY) > NOW()");
      }
    }

    // 性別指定がある場合
    if (array_key_exists("sex", $search) && $search['sex'] !== '' && $search['sex'] !== NULL) {
      $data = $data->where('u.sex', $search['sex']);
    }

    // 勤務地指定がある場合
    if(array_key_exists("prefecture_id",$search) && $search['prefecture_id']){
      $data = $data->leftjoin('user_company_responsible_area', 'u.user_company_id', '=', 'user_company_responsible_area.user_company_id')
              ->whereIn('user_company_responsible_area.prefecture_id',$search['prefecture_id']);
    }

    //得意分野指定がある場合
    if(array_key_exists("job_id",$search) && $search['job_id']){
      $data = $data->leftjoin('user_company_specialty', 'u.user_company_id', '=', 'user_company_specialty.user_company_id')
              ->whereIn('user_company_specialty.specialty_id',$search['job_id']);
    }

    if (array_key_exists("age", $search) && $search['age']) {
      $data = $data->whereIn('u.age', $search['age']);
    }

    $data = $data->groupBy('u.user_company_id');

    self::$usercompany_count = $data->count();

    $data = $data->orderby('u.create_date', 'desc');
    if (array_key_exists("sort", $search)) {
      $disp_num = config('const.DEFAULT_SEARCH_COUNT')['GENERAL'];
      $data = $data->paginate($disp_num);
    } else {
      $data = $data->get();
    }
    return $data;
  }

  /*
   * user_company_idからユーザ情報とプロフィール情報を取得
   */
  public static function getUserCompanyById($user_company_id)
  {

      $select = '
       u.user_company_id
      ,u.last_name
      ,u.first_name
      ,u.last_name_ruby
      ,u.first_name_ruby
      ,CONCAT(u.last_name, u.first_name) AS full_name
      ,u.email
      ,u.age
      ,u.sex
      ,u.catch_phrase
      ,u.self_introduction
      ,u.school_name
      ,u.final_education
      ,u.educational_background_detail
      ,u.final_employment_name
      ,u.final_employment_department
      ,u.final_employment_content
      ,u.final_employment_start_date
      ,u.enrollment_date
      ,u.graduate_date
      ,u.final_employment_end_date
      ,u.facebook
      ,u.twitter
      ,u.instagram
      ,u.position
      ,u.department
      ,u.mail_receiving_flag
      ,DATE_FORMAT(u.final_employment_start_date,\'%Y年%m月\') AS final_employment_start_date_jp
      ,DATE_FORMAT(u.final_employment_end_date,\'%Y年%m月\') AS final_employment_end_date_jp
      ,DATE_FORMAT(u.enrollment_date,\'%Y年%m月\') AS enrollment_date_jp
      ,DATE_FORMAT(u.graduate_date,\'%Y年%m月\') AS graduate_date_jp
      ,u.admin_flag
      ,u.token
      ,u.logo_image
      ,c.company_id
      ,c.business_type
      ,c.company_name
    ';

      $data = DB::table('user_company AS u')
          ->select(DB::RAW($select))
          ->leftjoin('company AS c', 'c.company_id', "=", "u.company_id")
          ->where('u.user_company_id', $user_company_id)
          ->where('u.del_flag', '0')
          ->get();

      if ($data->count() > 0) {
        return $data[0];
      }
  }

  public static function getRecommendedAgent($loginInfo, $num){
    $select = '
         u.user_company_id
        ,CONCAT(u.last_name, u.first_name) AS full_name
        ,u.create_date
        ,u.logo_image
          ';
    $data = DB::table('user_company AS u')
            ->select(DB::RAW($select))
            ->limit($num);

    return $data->get();
  }

  /*
   * company_idから企業に属しているエージェントを取得
   */
  public static function getCompanyAccountData($company_id, $agent_flag = null, $admin_flag = null){
    $select = '
         uc.user_company_id
         ,CONCAT(uc.last_name, uc.first_name) AS full_name
         ,uc.email
         ,uc.logo_image
         ,uc.sex
         ,uc.age
         ,uc.admin_flag
        ';
    $data = DB::table('user_company AS uc')
            ->select(DB::RAW($select))
            ->where('uc.company_id', $company_id)
            ->where('uc.authenticated_flag', 1)
            ->where('uc.del_flag', 0);

    if($agent_flag !== null) {
      $data = $data->where('uc.agent_flag',$agent_flag);
    }

    return $data->get();
  }

  /*
   * メール送信用に全てのエージェントを取ってくる
   */
  public static function getUserCompanyForMail()
  {
    $select = '
      user_company_id
      ,email
      ,CONCAT(last_name, first_name) AS full_name
    ';

    $data = DB::table('user_company')
        ->select(DB::RAW($select))
        ->where('mail_receiving_flag', 1)
        ->where('del_flag', 0)
        ->get();

    return $data;
  }

  /*
 * ユーザー登録
 */
  public static function insertUser($data)
  {
    // userテーブルに人材情報を登録
    DB::table('user_company')->insert($data);
    return DB::getPdo()->lastInsertId();
  }

  /*
   * ユーザ情報を更新する
   */
  public static function updateUserCompany($user_company_id, $data, $updateList)
  {

    $record = array();

    foreach ($data as $key => $value) {
      if (in_array($key, $updateList)) {
        $record[$key] = $value;
      }
    }

    // 更新する対象がなければ処理を終了する
    if (empty($record)) {
      return;
    }

    $data = DB::table('user_company')
            ->where('user_company_id', $user_company_id)
            ->update($record);
  }

  /*
   * トークンを設定
   */
  public static function setToken($user_id, $token)
  {
    DB::table('user_company')
            ->where('user_company_id', $user_id)
            ->update(['token' => $token]);
  }

  public static function checkToken($user_id,$token){
    return DB::table('user_company')
            ->select('user_company_id')
            ->where('user_company_id', $user_id)
            ->where('token', $token)
            ->where('del_flag', 0)
            ->exists();

  }

  /*
 * トークン存在(重複)チェック
 */
  public static function checkDuplicationToken($token)
  {
    $user = DB::table('user_company')
            ->select('token')
            ->where('token', $token)
            ->get();

    return $user;
  }
  /*
 * ワンタイムトークン存在(重複)チェック
 */
  public static function checkDuplicationOneTimeToken($token)
  {
    $user = DB::table('user_company')
            ->select('one_time_token')
            ->where('one_time_token', $token)
            ->get();

    return $user;
  }

  /*
 * メールアドレスに紐付くトークンがあるかチェック
 */
  public static function checkOneTimeToken($email, $one_time_token)
  {
    $user_engineer = DB::table('user_company')
            ->select('user_company_id')
            ->where('email', $email)
            ->where('one_time_token', $one_time_token)
            ->where('del_flag', 0)
            ->get();

    if (count($user_engineer) == 0)
      return false;

    return $user_engineer[0];
  }

  /*
   * メールアドレスからユーザ情報を取得
   */
  public static function getUserByEmail($email)
  {
    $data = DB::table('user_company')
      ->select(DB::RAW('user_company_id, CONCAT(last_name, first_name) AS full_name'))
      ->where('del_flag', '0')
      ->where('email', $email)
      ->get();

    if($data) {
      return $data[0];
    }
    return false;
  }


  /*
 * ユーザcompanyidからユーザ情報を取得
 */
  public static function getCompanyIdByUserCompanyId($user_company_id)
  {
    $data = DB::table('user_company')
            ->select('company_id')
            ->where('del_flag', '0')
            ->where('user_company_id', $user_company_id)
            ->get();

    if(count($data) > 0){
      return $data[0]->company_id;
    }else{
      return false;
    }

  }
  /*
   * ワンタイムトークンを設定
   */
  public static function setOneTimeToken($user_company_id, $one_time_token)
  {
    DB::table('user_company')
            ->where('user_company_id', $user_company_id)
            ->update(['one_time_token' => $one_time_token]);
  }

  /*
   * 最終ログイン日時を更新
   */
  public static function setLastLoginDate($user_company_id)
  {
      DB::table('user_company')
          ->where('user_company_id', $user_company_id)
          ->update(['last_login_date' => DB::raw('CURRENT_TIMESTAMP')]);
  }

  public static function editUserCompanyInfo($user_company_id)
  {
    $select = "user_company.user_company_id
              ,CONCAT(user_company.last_name, user_company.first_name) AS full_name
              ,user_company.email
              ,user_company.password
              ,user_company.phone_number
              ,user_company.logo_image
              ,user_company.company_id";

    $company = DB::table('user_company')
      ->select(DB::raw($select))
      ->where('user_company.user_company_id', $user_company_id)
      ->first();

    return $company;
  }

  /*
   * 更新
   */
  public static function up($data){

    try{
      \DB::table('user_company')->where("user_company_id", $data['user_company_id'])
        ->update($data);
    }catch (\Exception $e) {
      throw $e;
    }
    return true;
  }

  /*
  * 追加
  */
  public static function insertUserCompany($data){

    try{
      \DB::table('user_company')->insert($data);
      return DB::getPdo()->lastInsertId();
    }catch (\Exception $e) {
      throw $e;
    }
  }

    /*
   * お気に入りした数のみ取得
   */
  public static function getFavoritesCount($search = array()){
    $select = '*';
    if(isset($search['worker_id'])) {
      $select .= ',CASE
          WHEN wf.worker_id IS NULL THEN 0
          ELSE 1
          END AS favorite
          ';
      $worker_id = $search['worker_id'];
    } else {
      $worker_id = 0;
    }
    if(isset($search['user_company_id'])) {
      $select .= ',CASE
          WHEN ucf.user_company_id IS NULL THEN 0
          ELSE 1
          END AS favorite
          ';
      $user_company_id = $search['user_company_id'];
    } else {
      $user_company_id = 0;
    }
    $data = DB::table('user_company AS u')->select(DB::RAW($select));

    if($worker_id) {
      $data = $data->leftjoin('worker_favorite AS wf', function ($join) use ($worker_id) {
              $join->on('wf.target_id', '=', 'u.user_company_id')->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
            });
      // お気に入りしているエージェント取得
      if(array_key_exists("favoriteListFlag",$search) && $search['favoriteListFlag']){
        $data = $data ->where('wf.worker_id', '=', $worker_id)->where('wf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
      }
    } elseif ($user_company_id) {
      $data = $data->leftjoin('user_company_favorite AS ucf', function ($join) use ($user_company_id) {
              $join->on('ucf.target_id', '=', 'u.user_company_id')->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
            });
      // お気に入りしているエージェント取得
      if(array_key_exists("favoriteListFlag",$search) && $search['favoriteListFlag']){
        $data = $data ->where('ucf.user_company_id', '=', $user_company_id)->where('ucf.target_type', '=', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY']);
      }
    }

    return $data->count();
  }

  /*
   * 特定のworkerにオファーしているエージェント情報取得
   */
  public static function offeredUserCompanyList($worker_id, $limit = null, $search = [])
  {
    $select = '
       u.user_company_id
      ,u.age
      ,u.sex
      ,u.last_name
      ,u.first_name
      ,CONCAT(u.last_name, u.first_name) AS full_name
      ,u.logo_image AS user_company_logo_image
      ,c.company_id
      ,c.company_name
      ,c.logo_image AS company_logo_image
      ,DATE_FORMAT(o.create_date, "%Y-%m-%d") AS offered_date
    ';

    $data = DB::table('user_company AS u')
      ->select(DB::RAW($select))
      ->leftjoin('company AS c', 'c.company_id', "=", "u.company_id")
      ->leftjoin('offer_to_worker AS o', 'o.user_company_id', "=", "u.user_company_id")
      ->where('o.worker_id', $worker_id)
      ->where('c.del_flag', '0')
      ->where('o.del_flag', '0')
      ->orderby('o.create_date', 'DESC');

    $data = $data->groupBy('u.user_company_id');

    return $data->get();
  }

  /*
   * トータルエージェント数取得
   */
  public static function totalCount()
  {
    $select = '
      count(*) as total
    ';

    $data = DB::table('user_company AS u')
      ->select(DB::RAW($select))
      ->where('del_flag', '0');

    $data = $data->get();
    return $data[0]->total;
  }

  /*
   * 企業のアカウント全てを一括編集
   */
  public static function upCompanyAccounts($data)
  {
    try{
      \DB::table('user_company')->where("company_id", $data['company_id'])
        ->update($data);
    }catch (\Exception $e) {
      throw $e;
    }
    return true;
  }
}
