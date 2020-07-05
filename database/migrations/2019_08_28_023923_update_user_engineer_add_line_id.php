<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserEngineerAddLineId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('company', function (Blueprint $table) {

        $sql = "
              ALTER TABLE `user_engineer` ADD `line_id` VARCHAR(255) NULL DEFAULT NULL COMMENT 'LINEID' AFTER `logo_image`;
          ";

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
