<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCompanyMatchingScoreToWorker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_company_matching_score_to_worker', function (Blueprint $table) {

            $sql = "

            CREATE TABLE `user_company_matching_score_to_worker` (
                `user_company_id` int(11) unsigned NOT NULL COMMENT '担当者ID',
                `worker_id` int(11) unsigned NOT NULL COMMENT '人材ID',
                `matching_score` float unsigned NOT NULL COMMENT 'マッチングスコア',
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時刻',
                PRIMARY KEY (`user_company_id`,`worker_id`),
                KEY `user_company_matching_score_to_worker_worker_id_referenced` (`worker_id`),
                CONSTRAINT `user_company_matching_score_to_worker_worker_id_referenced` FOREIGN KEY (`worker_id`) REFERENCES `worker` (`worker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                KEY `user_company_matching_score_to_worker_project_id_referenced` (`user_company_id`),
                CONSTRAINT `user_company_matching_score_to_worker_project_id_referenced` FOREIGN KEY (`user_company_id`) REFERENCES `user_company` (`user_company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
