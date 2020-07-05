<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferAddIndexTopPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `offer` 
            ADD INDEX `del_flag_idx`(`del_flag`),
            ADD INDEX `project_worker_del_idx`(`project_id`, `worker_id`, `del_flag`);
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
        Schema::table('offer', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `offer` 
            DROP INDEX `del_flag_idx`,
            DROP INDEX `project_worker_del_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
