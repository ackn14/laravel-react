<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class worker_previews extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'worker_previews';
    protected $primaryKey = ['worker_id'];
    public $timestamps = false;

    // 最初にページを開いた時にDB挿入
    public static function insertWorkerPreviews($workerPreview){
        DB::table('worker_previews')
        ->insert([
            'worker_id' => $workerPreview['worker_id'],
            'last_viewed_user_type' => $workerPreview['last_viewed_user_type'],
            'last_viewed_user_id' => $workerPreview['last_viewed_user_id'],
            'previews' => DB::raw('previews + 1'),
        ]);
        return DB::getPdo()->lastInsertId();
    }

    //  プレビュー数・最終閲覧者更新
    public static function updateWorkerPreviews($worker_id, $workerPreview){
        try{
            \DB::table('worker_previews')->where("worker_id", $worker_id)
                ->update([
                    'last_viewed_user_type' => $workerPreview['last_viewed_user_type'],
                    'last_viewed_user_id' => $workerPreview['last_viewed_user_id'],
                    'previews' => DB::raw('previews + 1'),
                ]);
        }catch (\Exception $e) {
            throw $e;
        }
        return true;
    }

    // workerのpreview数のみ取得する
    public static function getWorkerPreviews($worker_id) {
        $select = 'wp.previews';
        $data = DB::table('worker_previews AS wp')
            ->select(DB::RAW($select))
            ->where('wp.worker_id', $worker_id)
            ->first();
        
        return $data ? $data->previews : 0;
    }
}