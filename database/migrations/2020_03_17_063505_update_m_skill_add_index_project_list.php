<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMSkillAddIndexProjectList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_skill', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_skill` 
            ADD INDEX `search_select_idx`(`skill_id`, `skill_name`, `display_order`);
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
        Schema::table('m_skill', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_skill` 
            DROP INDEX `search_select_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
