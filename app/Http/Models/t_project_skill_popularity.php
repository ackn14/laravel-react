<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class t_project_skill_popularity extends Model
{
  protected $table = 't_project_skill_popularity';
  protected $guarded = [];
  public $timestamps = false;
  
  public static function updatePopularity($limit = 20)
  {
    $db = DB::table('t_project_skill_popularity')->delete();
    
    $sql = '
      INSERT INTO
        `t_project_skill_popularity`(`skill_id`, `popularity`)
      SELECT
        skill.skill_id,
        RANK() OVER (ORDER BY skill.count ASC) AS `rank`
      FROM
        (
        SELECT
          s1.skill_id AS skill_id,
          COUNT(s1.skill_id) AS count
        FROM
          project_skill As s1
        GROUP BY
          s1.skill_id
        ) AS skill
      ORDER BY `rank` ASC
      LIMIT ?;
    ';
    
    DB::insert($sql, [$limit]);
  }

  public static function get($limit = null)
  {
    $data = DB::table('t_project_skill_popularity AS sp')
      ->select(DB::RAW('sp.skill_id, sp.popularity, s.skill_name'))
      ->leftjoin('m_skill AS s', 's.skill_id', '=', 'sp.skill_id')
      ->orderby('sp.popularity', 'ASC');
    
    if($limit) {
      $data = $data->limit($limit);
    }

    return $data->get();
  }
  
}
