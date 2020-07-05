<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserCompanyMatchingScoreToWorkerAddColumnMailSend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_company_matching_score_to_worker', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `user_company_matching_score_to_worker` 
            ADD `mail_send_flag` TINYINT(1) NOT NULL DEFAULT 0 AFTER `matching_score`,
            ADD INDEX `mail_send_idx`(`user_company_id`, `mail_send_flag`, `matching_score`, `update_date`);
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
        Schema::table('user_company_matching_score_to_worker', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `user_company_matching_score_to_worker` 
            DROP COLUMN `mail_send_flag`,
            DROP INDEX `mail_send_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
