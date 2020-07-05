<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class business_talk_status extends Model
{
  static $business_talk_status_count = null;
  static $business_talk_status_disp_count = null;
  protected $table = 'business_talk_status';
  protected $guarded = ['business_talk_status_id'];
  public $timestamps = false;

  public static function get($search,$company_id)
  {
    $select = "    business_talk_status.business_talk_status_id
                  ,business_talk_status.phase
                  ,DATE_FORMAT(business_talk_status.proposal_date,'%m/%d') as display_proposal_date
                  ,CASE
                    WHEN completion_date THEN DATE_FORMAT(business_talk_status.completion_date,'%m/%d')
                    ELSE NULL
                  END as display_completion_date
                  ,business_talk_status.proposal_date
                  ,business_talk_status.completion_date
                  ,project.project_id
                  ,project.title
                  ,worker.worker_id
                  ,CONCAT(worker.last_name,worker.first_name) as worker_name
                  ,project_manager.last_name as project_manager_name
                  ,worker_manager.last_name as worker_manager_name
                  ,m_code_business_talk_status.display_name as phase_name
                  ,business_talk_status.money
                  ,business_talk_status.profit
                  ,business_talk_status.note
                  ,business_talk_status.accuracy
                  ,business_talk_status.lost_flag
                  ,business_talk_status.priority
                  ,business_talk_status.color_label
                  ,m_code_color_label.col_1 AS color_label_code
              ";

    $query = DB::table('business_talk_status')
            ->select(DB::raw($select))
            ->leftjoin('project', 'project.project_id', '=', 'business_talk_status.project_id')
            ->join('worker', 'worker.worker_id', '=', 'business_talk_status.worker_id')
            ->leftjoin('user_company as project_manager', 'project.project_manager_id', '=', 'project_manager.user_company_id')
            ->leftjoin('user_company as worker_manager', 'worker.worker_manager_id', '=', 'worker_manager.user_company_id')
            ->leftjoin('m_code AS m_code_business_talk_status', function ($join) {
              $join->on("m_code_business_talk_status.code", "=", "business_talk_status.phase")
                      ->where('m_code_business_talk_status.category', '=', config('const.CATEGORY')['BUSINESS_TALK_STATUS']);
            })
            ->leftjoin('m_code AS m_code_color_label', function ($join) {
              $join->on("m_code_color_label.code", "=", "business_talk_status.color_label")
                      ->where('m_code_color_label.category', '=', config('const.CATEGORY')['COLOR_LABEL']);
            })
            ->where('business_talk_status.del_flag',0)
            ->where('business_talk_status.company_id',$company_id)
    ;

    if(array_key_exists('phase', $search) && $search['phase']){
      $query = $query->where('business_talk_status.phase' , '=', $search['phase']);
    }

    if(array_key_exists('completion_date', $search) && $search['completion_date']){
      $query = $query->where('business_talk_status.completion_date' , '=', $search['completion_date']);
      $search['sort'] = 'phase';
    }

    if(array_key_exists('freeWord', $search) && $search['freeWord']){
      $query = $query->where(function ($query) use ($search) {
        $query->orWhere('worker.last_name', 'like', '%' . $search['freeWord'] . '%')
                ->orWhere('worker.first_name', 'like', '%' . $search['freeWord'] . '%')
                ->orWhere('worker.initial_name', 'like', '%' . $search['freeWord'] . '%');
      });
      $search['sort'] = 'phase';
    }

    if(array_key_exists('manager_id', $search) && $search['manager_id']){
      $query = $query
            ->where('project.project_manager_id' , '=', $search['manager_id'])
            ->orWhere('worker.worker_manager_id' , '=', $search['manager_id']);
      $search['sort'] = 'phase';
    }

    switch ($search['sort']){
      case 'completion_date' :
        $query = $query->orderByRaw('business_talk_status.completion_date ' . $search['order']);
        break;
      case 'title' :
        $query = $query->orderByRaw('project.title ' . $search['order']);
        break;
      case 'worker_name' :
        $query = $query->orderByRaw('worker_name ' . $search['order']);
        break;
      case 'phase' :
        $query = $query
              ->orderBy('business_talk_status.lost_flag', 'asc')
              ->orderByRaw('business_talk_status.phase ' . $search['order']);
        break;
      case 'project_manager_name' :
        $query = $query->orderByRaw('project_manager_name ' . $search['order']);
        break;
      case 'worker_manager_name' :
        $query = $query->orderByRaw('worker_manager_name ' . $search['order']);
        break;
      default:
        $query = $query->orderByRaw('business_talk_status.update_date desc');
    }

    //全体の合計数を取得
    self::$business_talk_status_count = $query->count();
    $query = $query->paginate(20);

    self::$business_talk_status_disp_count = $query->count();

    return $query;
  }

  // sales/dashboardのグラフ用、SalesLogic::calcGraphDataからアクセス
  public static function getGraphData($company_id, $search){
    $monthly_select = '
          DATE_FORMAT(bts.completion_date, "%Y%m") AS completion_month
          ,CAST(DATE_FORMAT(bts.completion_date, "%m") AS UNSIGNED) AS view_month
          ,SUM(bts.money)/10000 AS money_sum
          ,SUM(bts.profit)/10000 AS profit_sum
          ,COUNT(DISTINCT bts.business_talk_status_id) AS match_count
          ';


    $monthly_data = DB::table('business_talk_status AS bts')
          ->select(DB::RAW($monthly_select))
          ->where('bts.del_flag', 0)
          ->where('bts.lost_flag', 0)
          ->where('bts.phase', 9)
          ->where('bts.company_id', $company_id)
          ->where('bts.completion_date', '!=', '0000-00-00')
    ;

    $daily_select = '
          bts.proposal_date
          ,SUM(bts.profit)/10000 AS profit_sum
          ,COUNT(DISTINCT bts.business_talk_status_id) AS proposal_count
          ';

    $daily_data = DB::table('business_talk_status AS bts')
          ->select(DB::RAW($daily_select))
          ->where('bts.del_flag', 0)
          ->where('bts.company_id', $company_id)
          ->where('bts.phase', '>', 1);

    $daily_profit = DB::table('business_talk_status AS bts')
          ->select(DB::RAW($daily_select))
          ->where('bts.del_flag', 0)
          ->where('bts.company_id', $company_id)
          ->where('bts.phase', '=', 9);

    $bppp_select = '
          case w.belongs_company_id when 1 then TRUE else false end AS bppp
          ,SUM(bts.money)/10000 AS bppp_money
          ';

    $bppp_data = DB::table('business_talk_status AS bts')
          ->select(DB::RAW($bppp_select))
          ->join('worker AS w', 'w.worker_id', '=', 'bts.worker_id')
          ->where('bts.del_flag', 0)
          ->where('bts.lost_flag', 0)
          ->where('bts.phase', 9)
          ->where('bts.company_id', $company_id);

    // 絞り込み
    if($search["user_company_id"]){
      $monthly_data = $monthly_data
            ->join('project', 'bts.project_id', '=', 'project.project_id')
            ->where('project.project_manager_id', $search["user_company_id"]);

      $daily_data = $daily_data
            ->join('project', 'bts.project_id', '=', 'project.project_id')
            ->where('project.project_manager_id', $search["user_company_id"]);

      $daily_profit = $daily_profit
            ->join('project', 'bts.project_id', '=', 'project.project_id')
            ->where('project.project_manager_id', $search["user_company_id"]);

      $bppp_data = $bppp_data
            ->join('project', 'bts.project_id', '=', 'project.project_id')
            ->where('project.project_manager_id', $search["user_company_id"]);
    }

    if($search["base_month"]){
      $monthly_data = $monthly_data
            ->whereRaw("PERIOD_DIFF(DATE_FORMAT(bts.completion_date, '%Y%m'), ".$search["base_year"] .$search["base_month"].") between -5 and 0");

      $bppp_data = $bppp_data
            ->whereRaw("DATE_FORMAT(bts.completion_date, '%Y-%m') = '".$search["base_year"]."-".$search["base_month"]."'");
    }else{
      $monthly_data = $monthly_data
            ->whereRaw("PERIOD_DIFF(DATE_FORMAT(bts.completion_date, '%Y%m'), DATE_FORMAT(NOW(), '%Y%m')) between -5 and 0");
    }

    $daily_profit = $daily_profit
          ->whereRaw("bts.completion_date = CURRENT_DATE()");

    $monthly_data = $monthly_data
          ->groupby('completion_month');

    $daily_data = $daily_data
          ->whereRaw("DATEDIFF(bts.proposal_date, CURRENT_DATE()) between -19 and 0")
          ->groupby('bts.proposal_date');

    $bppp_data = $bppp_data
          ->groupBy('bppp');


    $data['monthly'] = $monthly_data->get()->toArray();
    $data['daily'] = $daily_data->get()->toArray();
    $data['profit'] = $daily_profit->get()->toArray();
    $data['bppp'] = $bppp_data->get()->toArray();

    return $data;
  }

  public static function getTopAgentData($company_id, $search){
    $monthly_select = '
          uc.user_company_id
          ,CONCAT(uc.last_name, uc.first_name) AS full_name
          ,uc.logo_image
          ,SUM(bts.money)/10000 AS money_sum
          ,SUM(bts.profit)/10000 AS profit_sum
          ,COUNT(DISTINCT bts.business_talk_status_id) AS match_count
          ';
    $monthly_data = DB::table('business_talk_status AS bts')
          ->select(DB::RAW($monthly_select))
          ->join('project', 'bts.project_id', 'project.project_id')
          ->join('user_company AS uc', 'project.project_manager_id', 'uc.user_company_id')
          ->where('bts.del_flag', 0)
          ->where('bts.lost_flag', 0)
          ->where('bts.phase', 9)
          ->where('bts.company_id', $company_id);

    $daily_select = '
          uc.user_company_id
          ,CONCAT(uc.last_name, uc.first_name) AS full_name
          ,uc.logo_image
          ,COUNT(DISTINCT bts.business_talk_status_id) AS offer_count';

    $daily_data = DB::table('business_talk_status AS bts')
          ->select(DB::RAW($daily_select))
          ->join('project', 'bts.project_id', 'project.project_id')
          ->join('user_company AS uc', 'project.project_manager_id', 'uc.user_company_id')
          ->where('bts.del_flag', 0)
          ->where('bts.phase', '>', 1)
          ->where('bts.company_id', $company_id);

    $half_yearly_select = '
          uc.user_company_id
          ,CONCAT(uc.last_name, uc.first_name) AS full_name
          ,uc.logo_image
          ,SUM(bts.money)/10000 AS money_sum';

    $half_yearly_data = DB::table('business_talk_status AS bts')
          ->select(DB::RAW($half_yearly_select))
          ->join('project', 'bts.project_id', 'project.project_id')
          ->join('user_company AS uc', 'project.project_manager_id', 'uc.user_company_id')
          ->where('bts.del_flag', 0)
          ->where('bts.lost_flag', 0)
          ->where('bts.phase', 9)
          ->where('bts.company_id', $company_id);

    if($search["base_month"]){
      $monthly_data = $monthly_data
            ->whereRaw("DATE_FORMAT(bts.completion_date, '%Y-%m') = '".$search["base_year"]."-".$search["base_month"]."'");

      $half_yearly_data = $half_yearly_data
            ->whereRaw("PERIOD_DIFF(DATE_FORMAT(bts.completion_date, '%Y-%m'), '".$search["base_year"]."-".$search["base_month"]."') between 0 and 5");
    }else{
      $half_yearly_data = $half_yearly_data
            ->whereRaw("PERIOD_DIFF(DATE_FORMAT(bts.completion_date, '%Y-%m'), DATE_FORMAT(NOW(), '%Y-%m')) between 0 and 5");

      $monthly_data = $monthly_data
            ->whereRaw("DATE_FORMAT(bts.completion_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')");
    }

    $half_yearly_data = $half_yearly_data
          ->groupby('uc.user_company_id')
          ->orderby('money_sum', 'desc')
          ->limit(1)
          ->get()->toArray();

    $monthly_data = $monthly_data
          ->groupby('uc.user_company_id');

    $monthly_sales_data = $monthly_data
          ->orderby('money_sum', 'desc')
          ->limit(1)
          ->get()->toArray();

    $monthly_match_count_data = $monthly_data
          ->orderby('match_count', 'desc')
          ->limit(1)
          ->get()->toArray();

    $monthly_profit_data = $monthly_data
          ->orderby('profit_sum', 'desc')
          ->limit(1)
          ->get()->toArray();

    $daily_data = $daily_data
          ->whereRaw("DATEDIFF(bts.proposal_date, CURRENT_DATE()) between -9 and 0")
          ->groupby('uc.user_company_id')
          ->orderby('offer_count', 'desc')
          ->limit(1)
          ->get()->toArray();

    if($half_yearly_data) {
      $data['monthly_sales'] = $half_yearly_data[0];
    }else{
      $data['monthly_sales'] = array('user_company_id' => "", 'full_name'=> '', 'logo_image' => "");
    }
    if($monthly_sales_data) {
      $data['this_month_sales'] = $monthly_sales_data[0];
    }else{
      $data['this_month_sales'] = array('user_company_id' => "", 'full_name'=> '', 'logo_image' => "");
    }
    if($monthly_profit_data) {
      $data['this_month_profit'] = $monthly_profit_data[0];
    }else{
      $data['this_month_profit'] = array('user_company_id' => "", 'full_name'=> '', 'logo_image' => "");
    }
    if($monthly_match_count_data) {
      $data['this_month_match_number'] = $monthly_match_count_data[0];
    }else{
      $data['this_month_match_number'] = array('user_company_id' => "", 'full_name'=> '', 'logo_image' => "");
    }
    if($daily_data) {
      $data['offer_number'] = $daily_data[0];
    }else{
      $data['offer_number'] = array('user_company_id' => "", 'full_name'=> '', 'logo_image' => "");
    }

    return $data;
  }

  public static function getMonthlyRankingAgentData($company_id, $limit = null){
    $select = "
          uc.user_company_id
          ,CONCAT(uc.last_name, uc.first_name) AS full_name
          ,uc.logo_image
          ,COUNT(DISTINCT CASE WHEN bts.phase = 1 THEN bts.business_talk_status_id END) AS phase_count_1
          ,COUNT(DISTINCT CASE WHEN bts.phase = 2 THEN bts.business_talk_status_id END) AS phase_count_2
          ,COUNT(DISTINCT CASE WHEN bts.phase = 3 THEN bts.business_talk_status_id END) AS phase_count_3
          ,COUNT(DISTINCT CASE WHEN bts.phase = 4 THEN bts.business_talk_status_id END) AS phase_count_4
          ,COUNT(DISTINCT CASE WHEN bts.phase = 5 THEN bts.business_talk_status_id END) AS phase_count_5
          ,COUNT(DISTINCT CASE WHEN bts.phase = 6 THEN bts.business_talk_status_id END) AS phase_count_6
          ,COUNT(DISTINCT CASE WHEN bts.phase = 7 THEN bts.business_talk_status_id END) AS phase_count_7
          ,COUNT(DISTINCT CASE WHEN bts.phase = 8 THEN bts.business_talk_status_id END) AS phase_count_8
          ,COUNT(DISTINCT CASE WHEN bts.phase = 9 THEN bts.business_talk_status_id END) AS phase_count_9
          ,SUM(CASE WHEN bts.phase = 9 THEN bts.profit ELSE 0 END) AS profit_sum
          ,SUM(CASE WHEN bts.phase = 9 THEN bts.money ELSE 0 END) AS money_sum
          ";

    $data = DB::table('user_company AS uc')
          ->select(DB::RAW($select))
          // ->leftjoin('project AS p', 'uc.user_company_id', 'p.project_manager_id')
          ->leftjoin('worker AS w', 'uc.user_company_id', 'w.worker_manager_id')
          ->leftjoin('business_talk_status AS bts', function($query) {
            $query->on('w.worker_id', '=', 'bts.worker_id')
              ->whereRaw("DATE_FORMAT(bts.create_date, '%Y-%m-%d') BETWEEN DATE_FORMAT(curdate(), '%Y-%m-01') AND DATE_FORMAT(LAST_DAY(curdate()), '%Y-%m-%d')")
              ->where('bts.del_flag', 0)
              ->where('bts.lost_flag', 0)
              ->where('w.del_flag', 0);
          })
          ->where('uc.company_id', $company_id)
          ->where('uc.agent_flag', 1)
          ->groupBy('uc.user_company_id')
          ->orderBy('profit_sum', 'DESC');
    if($limit) $data = $data->limit($limit);

    return $data->get();
  }

  public static function upsert($data, $company_id, $business_talk_status_id = null){
    $record = \DB::table('business_talk_status')->select("business_talk_status_id")
            ->where('business_talk_status_id', $business_talk_status_id)
            ->where('company_id', $company_id);

    if ($record->exists()) {
      $data['business_talk_status_id'] = $record->get()[0]->business_talk_status_id;
      $record->update($data);
      return $data['business_talk_status_id'];
    } else {
      return $record->insertGetId($data);
      //return $record->project_id;

    }
  }

  public static function updatePhase($business_talk_status_id, $company_id, $data){
    $record = \DB::table('business_talk_status')->select("business_talk_status_id")
            ->where('business_talk_status_id', $business_talk_status_id)
            ->where('company_id', $company_id);

    if ($record->exists()) {
      $record->update(['phase' => $data['phase'], 'lost_flag' => $data['lost_flag']]);
      return $business_talk_status_id;
    } else {
      return false;
      //return $record->project_id;

    }
  }

  /*
   * 担当の案件、人材から商談取得
   */
  public static function getManageList($company_id, $user_company_id, $search = []){
    try {
      // 処理
      $select = "
        bts.business_talk_status_id
        ,bts.phase
        ,bts.money
        ,bts.profit
        ,bts.note
        ,bts.accuracy
        ,bts.lost_flag
        ,bts.priority
        ,bts.color_label
        ,color_label.col_1 AS color_label_code
        ,p.project_id
        ,p.title
        ,w.worker_id
        ,CONCAT(w.last_name, w.first_name) AS worker_name
        ,w.initial_name
        ,DATE_FORMAT(bts.proposal_date,'%m/%d') as display_proposal_date
        ,CASE
          WHEN completion_date THEN DATE_FORMAT(bts.completion_date,'%m/%d')
          ELSE NULL
        END as display_completion_date
        ,bts.proposal_date
        ,bts.completion_date
      ";
      
      $data = DB::table('business_talk_status AS bts')
              ->select(DB::RAW($select))
              ->leftjoin('project AS p', 'p.project_id', 'bts.project_id')
              ->leftjoin('worker AS w', 'w.worker_id', 'bts.worker_id')
              ->leftjoin('m_code AS color_label', function($loin) {
                $loin->on('color_label.code', '=', 'bts.color_label')->where('color_label.category', '=', config('const.CATEGORY')['COLOR_LABEL']);
              })
              ->where('bts.company_id', $company_id)
              ->where('bts.del_flag', 0)
              ->where('w.del_flag', 0)
              ->where(function($where) {
                $where->orWhere('p.del_flag', 0)->orWhereNull('p.del_flag');
              })
              ->where(function($query) use($user_company_id) {
                $query->orWhere('p.project_manager_id', $user_company_id)
                ->orWhere('w.worker_manager_id', $user_company_id);
              });

    if(array_key_exists('completion_date', $search) && $search['completion_date']){
      $data = $data->where('bts.completion_date' , '=', $search['completion_date']);
    }

      return $data->get();
              
    } catch (\Exception $e) {
      echo $e->getMessage();
      // 例外処理
      return false;
    }
  }

  /*
   * 案件、人材IDから商談取得
   */
  public static function getOne($company_id, $project_id, $worker_id){
    try {
      // 処理
      $select = "
        bts.*
        ,p.title
        ,CONCAT(w.last_name, w.first_name) AS worker_name
        ,w.initial_name
      ";
      
      $data = DB::table('business_talk_status AS bts')
              ->select(DB::RAW($select))
              ->leftjoin('project AS p', 'p.project_id', 'bts.project_id')
              ->leftjoin('worker AS w', 'w.worker_id', 'bts.worker_id')
              ->where('bts.company_id', $company_id)
              ->where('bts.project_id', $project_id)
              ->where('bts.worker_id', $worker_id);

      if($data->exists()) {
        return $data->first();
      } else {
        return false;
      }
    } catch (\Exception $e) {
      echo $e->getMessage();
      // 例外処理
      return false;
    }
  }

  /*
   * ロストフラグ更新機能
   */
  public static function updateLostFlag($business_talk_status_id,$company_id, $data){
    try {
      // 処理
      DB::table('business_talk_status')
              ->where('company_id', $company_id)
              ->where('business_talk_status_id', $business_talk_status_id)
              ->update(['lost_flag' => $data['lost_flag']]);
      return true;
    } catch (\Exception $e) {
      echo $e->getMessage();
      // 例外処理
      return false;
    }
  }

  /*
   * 削除機能
   */
  public static function del($business_talk_status_id,$company_id){
    try {
      // 処理
      DB::table('business_talk_status')
              ->where('company_id', $company_id)
              ->where('business_talk_status_id', $business_talk_status_id)
              ->update(['del_flag' => 1]);
      return true;
    } catch (\Exception $e) {
      echo $e->getMessage();
      // 例外処理
      return false;
    }
  }
}
