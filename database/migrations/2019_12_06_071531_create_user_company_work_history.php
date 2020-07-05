<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCompanyWorkHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('user_company_work_history', function (Blueprint $table) {
    
        $sql = "

          CREATE TABLE `user_company_work_history` (
            `user_company_id` INT(11) UNSIGNED NOT NULL,
            `company_name` VARCHAR(50) NOT NULL comment '企業名',
            `employment_status` VARCHAR(50) comment '雇用形態',
            `position` VARCHAR(50) comment 'ポジション',
            `job` VARCHAR(50) comment '職種',
            `department` VARCHAR(50) comment '部署名',
            `work_content` TEXT NULL comment '仕事内容',
            `start_date` DATE comment '就業年月日',
            `end_date` DATE comment '退職年月日',
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`user_company_id`),
            CONSTRAINT `user_company_id_user_company_work_history_referenced`
              FOREIGN KEY (`user_company_id`)
              REFERENCES `user_company` (`user_company_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION
              );
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
