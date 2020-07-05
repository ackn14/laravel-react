<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectAddIndex4dashboard extends Migration
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
            DROP INDEX `company_del_release_idx`,
            ADD INDEX `company_del_release_idx`(`company_id`, `del_flag`, `release_flag`);
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
            DROP INDEX `company_del_release_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
