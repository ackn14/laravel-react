<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_job extends Model
{

  protected $table = 'm_job';
  protected $guarded = ['job_id'];
  public $timestamps = false;

  public static function get()
  {
    $select = "m_job.job_id
                 ,m_job.job_category_id
                 ,m_job.job_name
                 ,m_job.display_order
                 ";

    $jobs = DB::table('m_job')
            ->select(DB::raw($select))
            ->orderByRaw('m_job.display_order')
            ->get();

    return $jobs;
  }

  public static function popularityJobGet(){
    $select = "m_job.job_id
                 ,m_job.job_category_id
                 ,m_job.job_name
                 ,m_job.display_order
                 ";

    $jobs = DB::table('m_job')
            ->select(DB::raw($select))
            ->whereIn('m_job.job_id',['100018','100005','600002','100004','100015'])
            ->orderByRaw('m_job.display_order DESC')
            ->get();

    return $jobs;
  }

  public static function getJobName($job_id)
  {
    $select = "
                 m_job.job_name
                 ";

    $job = DB::table('m_job')
            ->select(DB::raw($select))
            ->where('job_id', $job_id)
            ->get();

    if (count($job) == 0) {
      return "";
    }

    return $job[0]->job_name;

  }

  public static function getJobId($job_name)
  {
    $select = "
                 m_job.job_id
                 ";

    $job = DB::table('m_job')
            ->select(DB::raw($select))
            ->where('job_name', $job_name)
            ->get();

    if (count($job) == 0) {
      return "";
    }

    return $job[0]->job_id;

  }


  public static function checkExistence($job_id)
  {
    $ret = true;
    $jobs = DB::table('m_job')
            ->where('job_id', $job_id);


    $jobs->exists() ? $ret = true : $ret = '0000000';

    return $ret;
  }

  public static function getWithoutUnknown()
  {
    $select = "m_job.job_id
                 ,m_job.job_category_id
                 ,m_job.job_name
                 ,m_job.display_order
                 ";

    $jobs = DB::table('m_job')
            ->select(DB::raw($select))
            ->whereNotIn('job_category_id', ['99999999999'])
            ->orWhere('job_id', '0000000')
            ->orderByRaw('m_job.display_order')
            ->get();

    return $jobs;
  }

  public static function getWithoutUnknown4searchSelectList()
  {
    $select = "m_job.job_id
                 ,m_job.job_name
                 ";

    $jobs = DB::table('m_job')
            ->select(DB::raw($select))
            ->where('job_id', '0000000')
            ->orWhere('job_category_id', '!=', '99999999999')
            ->orderByRaw('m_job.display_order')
            ->get();

    return $jobs;
  }

  public static function getArrayDataWithoutUnknown(){
    $jobs = self::getWithoutUnknown();
    $arrJobs = array();
    foreach($jobs as $val){
      $arrJobs[$val->job_id] = $val->job_name;
    }

    return $arrJobs;
  }


}
