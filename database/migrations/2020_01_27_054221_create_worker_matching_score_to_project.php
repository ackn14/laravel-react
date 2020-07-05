<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerMatchingScoreToProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_matching_score_to_project', function (Blueprint $table) {

            $sql = "

            CREATE TABLE `worker_matching_score_to_project` (
                `worker_id` int(11) unsigned NOT NULL COMMENT '人材ID',
                `project_id` int(11) unsigned NOT NULL COMMENT '案件ID',
                `matching_score` float unsigned NOT NULL COMMENT 'マッチングスコア',
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時刻',
                PRIMARY KEY (`worker_id`,`project_id`),
                KEY `worker_matching_score_to_project_worker_id_referenced` (`worker_id`),
                CONSTRAINT `worker_matching_score_to_project_worker_id_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                KEY `worker_matching_score_to_project_project_id_referenced` (`project_id`),
                CONSTRAINT `worker_matching_score_to_project_project_id_referenced` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
