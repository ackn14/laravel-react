<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWorkerRenameColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // 担当者コメントカラム追加
      Schema::table('worker', function (Blueprint $table) {
        $sql = "
            ALTER TABLE `worker`
            CHANGE COLUMN `current_annual_salary` `current_monthly_income` VARCHAR(255),
            CHANGE COLUMN `desired_annual_salary` `desired_monthly_income` VARCHAR(255);
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
