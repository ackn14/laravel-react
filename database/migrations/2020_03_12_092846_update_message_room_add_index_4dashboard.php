<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMessageRoomAddIndex4dashboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('message_room', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `message_room` 
            DROP INDEX `uc_company`,
            ADD INDEX `uc_company`(`user_company_id`, `company_id`);
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
        Schema::table('message_room', function(Blueprint $blueprint) {
          $sql = '
            ALTER TABLE `message_room` 
            DROP INDEX `uc_company`;
          ';

          DB::connection()->getPdo()->exec($sql);
        });
    }
}
