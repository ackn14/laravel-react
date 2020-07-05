<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class worker_favorite extends Model
{
  protected $table = 'worker_favorite';
  protected $fillable = ['worker_id', 'target_type', 'target_id'];
  public $timestamps = false;

  public static function getFavoriteProject($worker_id)
  {
    $select = "project.project_id AS project_id
              ,project.title
              ,project.project_manager_id AS project_manager_id
              ,project.cover_image AS project_image
              ,uc.logo_image AS user_company_logo_image
              ,DATE_FORMAT(project.release_date,'%Y/%m/%d') as release_date_display
              ,DATE_FORMAT(project.work_start_date,'%Y/%m/%d') AS work_start_date_display
              ,job.job_category_id
              ";

    $data = DB::table('worker_favorite AS wf')
          ->select(DB::raw($select))
          ->leftjoin('project', 'wf.target_id', '=', 'project.project_id')
          ->leftjoin('m_job AS job', 'job.job_id', "=", "project.job_id")
          ->leftjoin('user_company AS uc', 'uc.user_company_id', "=", "project.project_manager_id")
          ->where('wf.worker_id', $worker_id)
          ->where('wf.target_type', config('const.FAVORITE_TARGET_TYPE')['PROJECT'])
          ->where('project.release_flag', 1)
          ->where('project.del_flag', 0)
          ->orderBy('wf.update_date', 'desc');

    return $data->get();
  }
  
  public static function getFavoriteAgent($worker_id)
  {
    $select = "user_company.user_company_id AS user_company_id
              ,CONCAT(user_company.last_name, user_company.first_name) AS full_name
              ,user_company.logo_image AS user_company_image
              ,DATE_FORMAT(user_company.create_date,'%Y年%m月%d日') as create_date
              ";
    
    $data = DB::table('worker_favorite AS wf')
      ->select(DB::raw($select))
      ->leftjoin('user_company', 'wf.target_id', '=', 'user_company.user_company_id')
      ->where('wf.worker_id', $worker_id)
      ->where('wf.target_type', config('const.FAVORITE_TARGET_TYPE')['USER_COMPANY'])
      ->where('user_company.del_flag', 0)
      ->orderBy('wf.update_date', 'desc');
    
    return $data->get();
  }

  public static function getFavoriteWorker(){

  }

  /*
   * ダッシュボードお気に入り数(案件への)グラフデータ
  */
  public static function getCountMonthlyFavoriteForProject($company_id, $month_ago = null){
    $select = '
        COUNT(*) AS count
    ';

    $data = DB::table('worker_favorite AS wf')
            ->select(DB::RAW($select))
            ->leftjoin('project', 'wf.target_id', '=', 'project.project_id')
            ->where('wf.target_type', config('const.FAVORITE_TARGET_TYPE')['PROJECT'])
            ->where('project.company_id', $company_id)
            ->groupby('project.company_id')
    ;

    if(isset($month_ago) && $month_ago > 0) {
      $data = $data->whereRaw('
          wf.update_date
          BETWEEN DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . -$month_ago . ' MONTH), "%Y-%m-01")
          AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . (-$month_ago + 1) . ' MONTH), "%Y-%m-01")
          ');
    } else {
      $data = $data->whereRaw('
          wf.update_date
          BETWEEN DATE_FORMAT(CURDATE(), "%Y-%m-01")
          AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . 1 . ' MONTH), "%Y-%m-01")
          ');
    }

    $data = $data->get();

    if(isset($data[0])) {
      return $data[0]->count;
    } else {
      return 0;
    }
  }

  /*
   * ダッシュボードお気に入り数(案件への)グラフデータ
  */
  public static function getCountMonthlyFavoriteForAgent($user_company_id, $month_ago = null){
    $select = '
        COUNT(*) AS count
    ';

    $data = DB::table('worker_favorite')
            ->select(DB::RAW($select))
            ->where('target_type', config('const.FAVORITE_TARGET_TYPE')['PROJECT'])
            ->where('target_id', $user_company_id)
            ->groupby('target_id')
    ;

    if(isset($month_ago) && $month_ago > 0) {
      $data = $data->whereRaw('
          update_date
          BETWEEN DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . -$month_ago . ' MONTH), "%Y-%m-01")
          AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . (-$month_ago + 1) . ' MONTH), "%Y-%m-01")
          ');
    } else {
      $data = $data->whereRaw('
          update_date
          BETWEEN DATE_FORMAT(CURDATE(), "%Y-%m-01")
          AND DATE_FORMAT(ADDDATE( CURDATE(), INTERVAL ' . 1 . ' MONTH), "%Y-%m-01")
          ');
    }

    $data = $data->get();

    if(isset($data[0])) {
      return $data[0]->count;
    } else {
      return 0;
    }
  }

  public static function insertFavorite($data)
  {
    try{
      DB::table('worker_favorite')->insert([
      'worker_id' => $data['worker_id'],
      'target_type' => $data['target_type'],
      'target_id' => $data['target_id'],
    ]);
    }catch(\Exception $e){
      throw $e;
    }
    return true;
  }

  public static function deleteFavorite($data)
  {
    try{
      \DB::table('worker_favorite')
            ->where('worker_id', $data['worker_id'])
            ->where('target_type', $data['target_type'])
            ->where('target_id', $data['target_id'])->delete();
    }catch(\Exception $e){
      throw $e;
    }
    return true;
  }

  public static function getFavoriteProjectId($worker_id)
  {
    $select = "wf.target_id AS project_id";

    $data = DB::table('worker_favorite AS wf')
          ->select(DB::raw($select))
          ->leftjoin('project', 'wf.target_id', '=', 'project.project_id')
          ->where('wf.worker_id', $worker_id)
          ->where('wf.target_type', config('const.FAVORITE_TARGET_TYPE')['PROJECT'])
          ->orderBy('wf.update_date', 'desc')
          ->get();

    return $data;
  }

  public static function existsFavorite($worker_id, $target_type, $target_id)
  {
    $select = "wf.*";
    $data = DB::table('worker_favorite AS wf')
          ->select(DB::raw($select))
          ->where('wf.worker_id', $worker_id)
          ->where('wf.target_type', $target_type)
          ->where('wf.target_id', $target_id);
    
    return $data->exists() ? $data->get() : false;
  }
}