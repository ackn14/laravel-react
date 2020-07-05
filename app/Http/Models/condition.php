<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class condition extends Model
{
    protected $table = 'search_project_condition';
    //table名取得
    protected $fillable = ['user_company_id', 'category', 'code'];
    //
    public static function getConditionData()
    {
        $select = "search_project_condition.user_engineer_id,
                    search_project_condition.category,
                    search_project_condition.code";

        $data = DB::table('search_project_condition')
                ->select(DB::RAW($select))
                ->where('search_project_condition.user_engineer_id')
                ->where('search_project_condition.category')
                ->where('search_project_condition.code')
                ->get();
                
        if(count($data) != 0){
            // return $data[0];
            return $data;
        }else{
            return null;
        }
        $timestamps = false;
    }
}
