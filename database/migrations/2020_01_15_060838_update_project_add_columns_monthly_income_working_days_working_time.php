<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectAddColumnsMonthlyIncomeWorkingDaysWorkingTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('project', function (Blueprint $table) {
    
        $sql = "

          ALTER TABLE `project`
            DROP COLUMN `working_time`,
            ADD COLUMN `monthly_income` VARCHAR(255) NULL COMMENT '月額単価' AFTER `monthly_income_max` ,
            ADD COLUMN `working_days` VARCHAR(255) NULL COMMENT '稼働日数' AFTER `contract_period`,
            ADD COLUMN `working_system` VARCHAR(255) NULL COMMENT '勤務体制' AFTER `working_days`,
            ADD COLUMN `working_time_from` TIME NULL COMMENT '勤務開始時間' AFTER `desired_personality`,
            ADD COLUMN `working_time_to` TIME NULL COMMENT '勤務終了時間' AFTER `working_time_from`,
            ADD COLUMN `work_start_date` DATE NULL COMMENT '稼働開始予定日' AFTER `inexperience_ok`
            ;

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
