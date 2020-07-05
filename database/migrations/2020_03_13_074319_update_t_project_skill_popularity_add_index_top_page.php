<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTProjectSkillPopularityAddIndexTopPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_project_skill_popularity', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `t_project_skill_popularity` 
            ADD INDEX `popularity_idx`(`popularity`);
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
        Schema::table('t_project_skill_popularity', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `t_project_skill_popularity` 
            DROP INDEX `popularity_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
