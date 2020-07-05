<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectAddIndexProjectList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `project` 
            ADD INDEX `search_select_engineer_all_idx`(`job_id`, `prefecture_id`, `del_flag`, `release_flag`),
            ADD INDEX `search_select_engineer_job_idx`(`job_id`, `del_flag`, `release_flag`),
            ADD INDEX `search_select_engineer_prefecture_idx`(`prefecture_id`, `del_flag`, `release_flag`),
            ADD INDEX `search_select_company_all_idx`(`job_id`, `prefecture_id`, `del_flag`, `company_id`),
            ADD INDEX `search_select_company_job_idx`(`job_id`, `del_flag`, `company_id`),
            ADD INDEX `search_select_company_prefecture_idx`(`prefecture_id`, `del_flag`, `company_id`);
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
        Schema::table('project', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `project` 
            DROP INDEX `search_select_engineer_all_idx`,
            DROP INDEX `search_select_engineer_job_idx`,
            DROP INDEX `search_select_engineer_prefecture_idx`,
            DROP INDEX `search_select_company_all_idx`,
            DROP INDEX `search_select_company_job_idx`,
            DROP INDEX `search_select_company_prefecture_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
