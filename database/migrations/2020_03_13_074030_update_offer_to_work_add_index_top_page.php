<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOfferToWorkAddIndexTopPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offer_to_worker', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `offer_to_worker` 
            ADD INDEX `del_flag_idx`(`del_flag`),
            ADD INDEX `worker_create_idx`(`worker_id`, `create_date`);
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
        Schema::table('offer_to_worker', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `offer_to_worker` 
            DROP INDEX `del_flag_idx`,
            DROP INDEX `worker_create_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
