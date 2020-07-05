<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMRegionAddIndexProjectList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_region', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_region` 
            ADD INDEX `id_name_order_idx`(`region_id`, `region_name`, `display_order`);
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
        Schema::table('m_region', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `m_region` 
            DROP INDEX `id_name_order_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
