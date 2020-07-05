<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerFavoriteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_company_favorite', function (Blueprint $table) {

            $sql = "

            CREATE TABLE `worker_favorite` (
                `worker_id` int(11) unsigned NOT NULL COMMENT '人材ID',
                `target_type` tinyint(4) unsigned NOT NULL COMMENT '対象タイプ 0:案件,1:エージェント',
                `target_id` int(11) unsigned NOT NULL COMMENT '対象ID',
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時刻',
                PRIMARY KEY (`worker_id`,`target_type`,`target_id`),
                KEY `worker_favorite_worker_id_referenced` (`worker_id`),
                CONSTRAINT `worker_favorite_worker_id_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
              ) ENGINE=InnoDB;

              ";

            DB::connection()->getPdo()->exec($sql);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 
    }
}
