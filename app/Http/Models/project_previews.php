<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class project_previews extends Model implements AuthenticatableContract
{	
    use Authenticatable;

    protected $table = 'project_previews';
    protected $primaryKey = ['project_id'];
    public $timestamps = false;

    // 最初にページを開いた時にDB挿入
        public static function insertProjectPreviews($projectPreview){
            DB::table('project_previews')
            ->insert([
                'project_id' => $projectPreview['project_id'],
                'last_viewed_user_type' => $projectPreview['last_viewed_user_type'],
                'last_viewed_user_id' => $projectPreview['last_viewed_user_id'],
                'previews' => DB::raw('previews + 1'),
            ]);
            return DB::getPdo()->lastInsertId();
        }

        //  プレビュー数・最終閲覧者更新
        public static function updateProjectPreviews($project_id, $projectPreview){
            try{
                \DB::table('project_previews')->where("project_id", $project_id)
                    ->update([
                        'last_viewed_user_type' => $projectPreview['last_viewed_user_type'],
                        'last_viewed_user_id' => $projectPreview['last_viewed_user_id'],
                        'previews' => DB::raw('previews + 1'),
                    ]);
            }catch (\Exception $e) {
                throw $e;
            }
            return true;

    }
}