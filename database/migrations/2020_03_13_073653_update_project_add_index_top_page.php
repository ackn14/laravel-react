<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectAddIndexTopPage extends Migration
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
            ADD INDEX `del_release_idx`(`del_flag`, `release_flag`, `create_date`),
            ADD INDEX `view_flags_idx`(`del_flag`, `release_flag`, `recruitment_end_flag`),
            ADD INDEX `del_company_idx`(`del_flag`, `company_id`);
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
            DROP INDEX `del_release_idx`,
            DROP INDEX `view_flags_idx`,
            DROP INDEX `del_company_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
