<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectSkillAddIndexTopPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_skill', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `project_skill` 
            ADD INDEX `project_priority_skill_idx`(`project_id`, `priority`, `skill_id`);
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
        Schema::table('project_skill', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `project_skill` 
            DROP INDEX `project_priority_skill_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
