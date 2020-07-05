<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMCodeAddIndexProjectList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_code', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_code` 
            ADD INDEX `search_select_idx`(`category`, `display_order`);
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
        Schema::table('m_code', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_code` 
            DROP INDEX `search_select_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
