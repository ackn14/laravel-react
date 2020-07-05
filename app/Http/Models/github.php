<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class github extends Model
{
    protected $table = 'github';
    //table名取得
    protected $fillable = ['id'];
    //
    public static function upsert($data)
    {
      try {
        $record = \DB::table('github')->select("worker_id")
                ->where('worker_id', $data['worker_id']);

        if ($record->exists()) {
          $record->update($data);
          return $data['worker_id'];
        } else {
          return $record->insertGetId($data);
        }
      } catch (\Exception $e) {
        logger()->error($e->getMessage());
      }

    }
}
