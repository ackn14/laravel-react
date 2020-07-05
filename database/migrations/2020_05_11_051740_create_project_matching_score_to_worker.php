<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectMatchingScoreToWorker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_matching_score_to_worker', function (Blueprint $table) {

            $sql = "

            CREATE TABLE `project_matching_score_to_worker` (
                `project_id` int(11) unsigned NOT NULL COMMENT '案件ID',
                `worker_id` int(11) unsigned NOT NULL COMMENT '人材ID',
                `matching_score` float unsigned NOT NULL COMMENT 'マッチングスコア',
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時刻',
                PRIMARY KEY (`project_id`,`worker_id`),
                KEY `project_matching_score_to_worker_worker_id_referenced` (`worker_id`),
                CONSTRAINT `project_matching_score_to_worker_worker_id_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                KEY `project_matching_score_to_worker_project_id_referenced` (`project_id`),
                CONSTRAINT `project_matching_score_to_worker_project_id_referenced` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
        Schema::dropIfExists('project_matching_score_to_worker');
    }
}
