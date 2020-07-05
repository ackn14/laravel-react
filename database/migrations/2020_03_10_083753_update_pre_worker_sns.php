<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePreWorkerSns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_worker_sns', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `pre_worker_sns`
            DROP COLUMN `follower_account`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });

        Schema::table('pre_worker_sns', function(Blueprint $blueprint) {
            $sql = '
                ALTER TABLE pre_worker_sns CHANGE COLUMN follow_account sns_account varchar(255);
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
        //
    }
}
