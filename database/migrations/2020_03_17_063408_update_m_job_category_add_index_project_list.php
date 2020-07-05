<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMJobCategoryAddIndexProjectList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_job_category', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_job_category` 
            ADD INDEX `id_name_disp_idx`(`job_category_id`, `job_category_name`, `display_order`);
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
        Schema::table('m_job_category', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_job_category` 
            DROP INDEX `id_name_disp_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
