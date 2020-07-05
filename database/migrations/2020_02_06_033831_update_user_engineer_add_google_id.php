<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserEngineerAddGoogleId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_engineer', function (Blueprint $table) {
            $sql = "
            ALTER TABLE `user_engineer` ADD `google_id` VARCHAR(255) NULL DEFAULT NULL COMMENT 'GOOGLEID' AFTER `line_id`;
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
