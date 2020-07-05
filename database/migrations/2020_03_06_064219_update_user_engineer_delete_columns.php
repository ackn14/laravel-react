<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserEngineerDeleteColumns extends Migration
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

          ALTER TABLE `user_engineer`
          DROP COLUMN `last_name`,
          DROP COLUMN `first_name`,
          DROP COLUMN `last_name_ruby`,
          DROP COLUMN `first_name_ruby`,
          DROP COLUMN `phone_number`,
          DROP COLUMN `logo_image`;

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
