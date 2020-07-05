<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_code extends Model
{

  protected $table = 'm_code';
  protected $guarded = ['category'];
  public $timestamps = false;

  const CONDITION_CATEGORY = ['job', 'desired_job', 'business_type', 'prefecture', 'skill', 'monthly_income', 'contract_type', 'another_feature'];

  public static function get($category)
  {
    $select = "m_code.category
               ,m_code.code
               ,m_code.display_order
               ,m_code.display_name
               ,m_code.col_1
               ,m_code.col_2
               ,m_code.col_3
               ,m_code.col_4
               ,m_code.col_5
               ";

    $code = DB::table('m_code')
          ->select(DB::raw($select))
          ->where('category', $category)
          ->orderBy('display_order', 'ASC')
          ->get();

    return $code;
  }

  public static function getAll()
  {
    $select = "m_code.category
               ,m_code.code
               ,m_code.display_order
               ,m_code.display_name
               ,m_code.col_1
               ,m_code.col_2
               ,m_code.col_3
               ,m_code.col_4
               ,m_code.col_5
               ";

    $code = DB::table('m_code')
          ->select(DB::raw($select))
          ->where('category', '<>', 'contract_type')
          ->orWhereIn('code', ['1', '2', '5','6', '7'])
          ->orderBy('category', 'ASC')
          ->orderBy('display_order', 'ASC')
          ->get();

    return $code;
  }

  public static function getContractTypeForSignUp()
  {
    $select = "m_code.category
               ,m_code.code
               ,m_code.display_order
               ,m_code.display_name
               ,m_code.col_1
               ,m_code.col_2
               ,m_code.col_3
               ,m_code.col_4
               ,m_code.col_5
               ";

    $code = DB::table('m_code')
          ->select(DB::raw($select))
          ->where('category', 'contract_type')
          ->whereIn('code', ['1', '2', '5','6', '7'])
          ->get();

    return $code;
  }

  public static function getContractType4searchSelectList()
  {
    $select = "m_code.code
               ,m_code.display_name
               ";

    $code = DB::table('m_code')
          ->select(DB::raw($select))
          ->where('category', 'contract_type')
          ->whereIn('code', ['1', '2', '5','6', '7'])
          ->get();

    return $code;
  }

  public static function getBusinessType()
  {
    $select = "m_code.category
                 ,m_code.code
                 ,m_code.display_order
                 ,m_code.display_name
                 ,m_code.col_1
                 ,m_code.col_2
                 ,m_code.col_3
                 ,m_code.col_4
                 ,m_code.col_5
                 ";

    $code = DB::table('m_code')
            ->select(DB::raw($select))
            ->where('category', 'business_type')
            ->get();

    return $code;
  }

  public static function getBusinessTypeArrayData()
  {
    $data = self::getBusinessType();


    foreach($data as $val){
      $arr[$val->code] = $val->display_name;
    }

    return $arr;
  }

  public static function getAnnualIncomeMax()
  {
    $select = "m_code.category
                 ,m_code.code
                 ,m_code.display_order
                 ,m_code.display_name
                 ,m_code.col_1
                 ,m_code.col_2
                 ,m_code.col_3
                 ,m_code.col_4
                 ,m_code.col_5
                 ";

    $code = DB::table('m_code')
            ->select(DB::raw($select))
            ->where('category', 'annual_income_max')
            ->get();

    return $code;
  }

  public static function getAnnualIncomeMin()
  {
    $select = "m_code.category
                 ,m_code.code
                 ,m_code.display_order
                 ,m_code.display_name
                 ,m_code.col_1
                 ,m_code.col_2
                 ,m_code.col_3
                 ,m_code.col_4
                 ,m_code.col_5
                 ";

    $code = DB::table('m_code')
            ->select(DB::raw($select))
            ->where('category', 'annual_income_min')
            ->get();

    return $code;
  }

  public static function getExSkill()
  {
    $select = "m_code.category
             ,m_code.code
             ,m_code.display_order
             ,m_code.display_name
             ,m_code.col_1
             ,m_code.col_2
             ,m_code.col_3
             ,m_code.col_4
             ,m_code.col_5
             ";

    $code = DB::table('m_code')
        ->select(DB::raw($select))
        ->where('category', 'ex_skill')
        ->get();

    return $code;
  }

  public static function getMonthlyIncome()
  {
    $select = "m_code.category
            ,m_code.code
            ,m_code.display_order
            ,m_code.display_name
            ,m_code.col_1
            ,m_code.col_2
            ,m_code.col_3
            ,m_code.col_4
            ,m_code.col_5
            ";

    $code = DB::table('m_code')
        ->select(DB::raw($select))
        ->where('category', 'monthly_income')
        ->orderBy('display_order', 'ASC')
        ->get();

    return $code;
  }

  public static function getMonthlyIncome4searchSelectList()
  {
    $select = "m_code.code
            ,m_code.display_name
            ";

    $code = DB::table('m_code')
        ->select(DB::raw($select))
        ->where('category', 'monthly_income')
        ->orderBy('display_order', 'ASC')
        ->get();

    return $code;
  }

  public static function getBusinessTypeByCode($code)
  {
    $select = "m_code.category
              ,m_code.code
              ,m_code.display_order
              ,m_code.display_name
              ,m_code.col_1
              ,m_code.col_2
              ,m_code.col_3
              ,m_code.col_4
              ,m_code.col_5
              ";
    $business_type = DB::table('m_code')
        ->select(DB::raw($select))
        ->where('code', $code)
        ->get();

    return $business_type;
  }

  public static function getContractTypeByCode($code)
  {
    $select = "m_code.category
             ,m_code.code
             ,m_code.display_order
             ,m_code.display_name
             ,m_code.col_1
             ,m_code.col_2
             ,m_code.col_3
             ,m_code.col_4
             ,m_code.col_5
             ";

    $code = DB::table('m_code')
        ->select(DB::raw($select))
        ->where('category', 'contract_type')
        ->where('code', $code)
        ->whereIn('code', ['1', '2', '5','6', '7'])
        ->get();

    return $code;
  }

  public static function getMonthlyIncomeByCode($code)
  {
    $select = "m_code.category
            ,m_code.code
            ,m_code.display_order
            ,m_code.display_name
            ,m_code.col_1
            ,m_code.col_2
            ,m_code.col_3
            ,m_code.col_4
            ,m_code.col_5
            ";

    $code = DB::table('m_code')
        ->select(DB::raw($select))
        ->where('category', 'monthly_income')
        ->where('code', $code)
        ->first();

    return $code;
  }

  public static function getBusinessTalkStatus()
  {
    $select = "m_code.category
                 ,m_code.code
                 ,m_code.display_order
                 ,m_code.display_name
                 ,m_code.col_1
                 ,m_code.col_2
                 ,m_code.col_3
                 ,m_code.col_4
                 ,m_code.col_5
                 ";

    $code = DB::table('m_code')
            ->select(DB::raw($select))
            ->where('category', 'business_talk_status')
            ->get();

    return $code;
  }

  public static function getContractPeriod()
  {
    $select = "m_code.category
                 ,m_code.code
                 ,m_code.display_order
                 ,m_code.display_name
                 ,m_code.col_1
                 ,m_code.col_2
                 ,m_code.col_3
                 ,m_code.col_4
                 ,m_code.col_5
                 ";

    $code = DB::table('m_code')
            ->select(DB::raw($select))
            ->where('category', 'contract_period')
            ->get();

    return $code;
  }

  public static function getDaysAWeek()
  {
    $select = "m_code.category
                 ,m_code.code
                 ,m_code.display_order
                 ,m_code.display_name
                 ,m_code.col_1
                 ,m_code.col_2
                 ,m_code.col_3
                 ,m_code.col_4
                 ,m_code.col_5
                 ";

    $code = DB::table('m_code')
            ->select(DB::raw($select))
            ->where('category', 'days_a_week')
            ->get();

    return $code;
  }
}
