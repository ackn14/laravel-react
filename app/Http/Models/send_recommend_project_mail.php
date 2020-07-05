<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class send_recommend_project_mail extends Model
{

  protected $table = 'send_recommend_project_mail';
  protected $guarded = ['project_id', 'create_date'];
  public $timestamps = false;


  /*
   * insert(但し未送信データがある場合は追加しない)
   */
  public static function insert($data)
  {
    $record = \DB::table('send_recommend_project_mail')
            ->where('project_id', $data['project_id'])
            ->where('send_flag', '0');

    if (!$record->exists()) $record->insert($data);
  }


  /*
   * 送信フラグ更新
   */
  public static function updSendFlag($project_id)
  {
    $data = DB::table('send_recommend_project_mail')
            ->where('project_id', $project_id)
            ->update(['send_flag' => 1]);
  }

  public static function getFirstUnsentMail()
  {

    $select = '
         project.project_id
        ,project.title
        ,project.job_id
        ,project.cover_image
        ,project.salary
        ,project.welfare
        ,project.vacation
        ,project.working_time_from
        ,project.working_time_to
        ,project.selection_process
        ,project.nearest_station
        ,project.monthly_income
        ,monthly_income.display_name AS monthly_income_name
        ,project.project_outline
        ,project.contract_type
        ,project.desired_personality
        ,project.address
        ,project.postal_code
        ,project.prefecture_id
        ,project.city_id
        ,project.latitude
        ,project.longitude
        ,DATE_FORMAT(project.release_date,\'%Y年%m月%d日\') as release_date 
        ,pre.prefecture_name
        ,job.job_name
        ,position.display_name AS position
        ,skill_management.display_name AS skill_management
        ,skill_english.display_name AS skill_english
        ,company.company_name
        ,GROUP_CONCAT(DISTINCT project_feature.project_feature_id) AS project_feature
        ,GROUP_CONCAT(DISTINCT project_skill.skill_id) AS skill
        ,GROUP_CONCAT(DISTINCT m_skill.skill_name) AS skill_name
      ';

    $record = \DB::table('send_recommend_project_mail')
            ->select(DB::RAW($select))
            ->join('project','project.project_id', '=', 'send_recommend_project_mail.project_id')
            ->leftjoin('company', 'company.company_id', '=', 'project.company_id')
            ->leftjoin('project_feature', 'project_feature.project_id', '=', 'project.project_id')
            ->leftjoin('project_skill', 'project_skill.project_id', '=', 'project.project_id')
            ->leftjoin('m_skill', 'm_skill.skill_id', '=', 'project_skill.skill_id')
            ->leftjoin('m_code AS position', function ($join) {
              $join->on("position.code", "=", "project.position")->where('position.category', '=', config('const.CATEGORY')['POSITION']);
            })
            ->leftjoin('m_prefecture AS pre', 'pre.prefecture_id', "=", "project.prefecture_id")
            ->leftjoin('m_job AS job', 'job.job_id', "=", "project.job_id")
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
            ->leftjoin('m_code AS contract_type', function ($join) {
              $join->on("contract_type.code", "=", "project.contract_type")
                      ->where('contract_type.category', '=', config('const.CATEGORY')['CONTRACT_TYPE']);
            })
            ->leftjoin('m_code AS m_code_business_type', function ($join) {
              $join->on('m_code_business_type.code', "=", "company.business_type")
                      ->where("m_code_business_type.category", "=", config('const.CATEGORY')['BUSINESS_TYPE']);
            })
            ->where('project.recruitment_end_flag', 0)
            ->where('send_recommend_project_mail.send_flag', 0)
            ->groupby('project.project_id')
            ->orderby('send_recommend_project_mail.create_date', 'asc')
            ->limit(1);

    if ($record->exists()) {
      $record = $record->get();
      return  $record[0];
    }
    return null;
  }
}

