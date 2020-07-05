<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEngineer extends Migration
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
          CREATE TABLE `user_engineer` (
            `user_engineer_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_engineer_name` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `token` VARCHAR(50) NULL DEFAULT NULL,
            `last_name` VARCHAR(255),
            `first_name` VARCHAR(255),
            `last_name_ruby` VARCHAR(255),
            `first_name_ruby` VARCHAR(255),
            `phone_number` VARCHAR(255),
            `logo_image` VARCHAR(255) NULL DEFAULT NULL,
            `one_time_token` VARCHAR(255),
            `last_login_date` DATETIME NULL DEFAULT NULL,
            `remember_token` VARCHAR(255),
            `account_suspended_flag` TINYINT(4) NULL DEFAULT 0,
            `authenticated_flag` TINYINT(4) NULL DEFAULT 0,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`user_engineer_id`),
            UNIQUE (`email`));
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
