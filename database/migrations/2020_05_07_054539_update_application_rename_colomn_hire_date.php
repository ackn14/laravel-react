<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicationRenameColomnHireDate extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('application', function (Blueprint $table) {
      $sql = "
        ALTER TABLE `application`
        CHANGE COLUMN `joining_date` `hire_date` DATE DEFAULT NULL COMMENT '入社日';
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
  }
}
