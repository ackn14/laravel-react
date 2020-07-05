<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMJobAddIndexProjectList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_job', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_job` 
            ADD INDEX `search_select_idx`(`job_id`, `job_category_id`, `job_name`, `display_order`);
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
        Schema::table('m_job', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_job` 
            DROP INDEX `search_select_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
