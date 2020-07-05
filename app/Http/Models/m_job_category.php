<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class m_job_category extends Model
{

  protected $table = 'm_job_category';
  protected $guarded = ['job_category_id'];
  public $timestamps = false;

  public static function get()
  {
    $select = "
                  m_job_category.job_category_id
                 ,m_job_category.job_category_name 
                 ,m_job.job_id
                 ,m_job.job_name
                 ";

    $jobs = DB::table('m_job_category')
            ->select(DB::raw($select))
            ->leftjoin('m_job', 'm_job.job_category_id', "=", "m_job_category.job_category_id")
            ->whereNotIn('m_job_category.job_category_id', ['99999999999'])
            ->orWhere('m_job.job_id', '0000000')
            ->orderByRaw('m_job_category.display_order asc, m_job.job_category_id asc')
            ->get();

    return $jobs;
  }

  public static function getJobIdName()
  {
    $select = "
                 m_job.job_id
                 ,m_job.job_name
                 ,m_job_category.job_category_name 
                 ";

    $jobs = DB::table('m_job_category')
            ->select(DB::raw($select))
            ->leftjoin('m_job', 'm_job.job_category_id', "=", "m_job_category.job_category_id")
            ->where('m_job.job_id', '0000000')
            ->orWhere('m_job.job_category_id', '!=', '99999999999')
            ->orderByRaw('m_job_category.display_order asc, m_job.job_category_id asc')
            ->get();

    return $jobs;
  }
}
