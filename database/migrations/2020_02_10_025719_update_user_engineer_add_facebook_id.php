<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserEngineerAddFacebookId extends Migration
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
            ALTER TABLE `user_engineer` ADD `facebook_id` VARCHAR(255) NULL DEFAULT NULL COMMENT 'FACEBOOKID' AFTER `google_id`;
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
