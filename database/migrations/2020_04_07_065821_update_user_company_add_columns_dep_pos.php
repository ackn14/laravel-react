<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserCompanyAddColumnsDepPos extends Migration
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
          ADD COLUMN `department` VARCHAR(255) NULL COMMENT '部署' AFTER `phone_number`,
          ADD COLUMN `position` VARCHAR(255) NULL COMMENT '役職' AFTER `department`;

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
