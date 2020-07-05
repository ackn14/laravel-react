<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWorkerAddIndex4dashboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `worker` 
            DROP INDEX `del_release_idx`,
            DROP INDEX `user_engineer_idx`,
            ADD INDEX `del_release_idx`(`del_flag`, `release_flag`, `worker_id`, `create_date`),
            ADD INDEX `user_engineer_idx`(`user_engineer_id`);
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
        Schema::table('worker', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `worker` 
            DROP INDEX `del_release_idx`,
            DROP INDEX `user_engineer_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
