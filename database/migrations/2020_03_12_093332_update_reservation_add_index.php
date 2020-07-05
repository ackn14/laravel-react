<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReservationAddIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservation', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `reservation` 
            ADD INDEX `flag_date_idx`(`company_id`, `del_flag`, `cancel_flag`, `reservation_date`);
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
        Schema::table('reservation', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `reservation` 
            DROP INDEX `flag_date_idx`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
