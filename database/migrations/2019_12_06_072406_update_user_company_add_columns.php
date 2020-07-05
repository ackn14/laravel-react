<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserCompanyAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('user_company', function (Blueprint $table) {
    
        $sql = "

          ALTER TABLE `user_company`
            ADD COLUMN `birthday` DATE NULL AFTER `phone_number`,
            ADD COLUMN `sex` TINYINT(4) NULL AFTER `birthday`,
            ADD COLUMN `catch_phrase` VARCHAR(255) AFTER `sex`,
            ADD COLUMN `self_introduction` TEXT NULL AFTER `catch_phrase`;

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
