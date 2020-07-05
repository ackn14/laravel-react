<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWorkerMatchingScoreToProjectAddColumnMailSend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker_matching_score_to_project', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `worker_matching_score_to_project` 
            ADD `mail_send_flag` TINYINT(1) NOT NULL DEFAULT 0 AFTER `matching_score`,
            ADD INDEX `mail_send_idx`(`worker_id`, `mail_send_flag`, `matching_score`, `update_date`);
          ';
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
        Schema::table('worker_matching_score_to_project', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `worker_matching_score_to_project` 
            DROP COLUMN `mail_send_flag`,
            DROP INDEX `mail_send_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
