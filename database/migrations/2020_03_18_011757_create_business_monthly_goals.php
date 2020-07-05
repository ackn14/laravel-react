<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessMonthlyGoals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_monthly_goals', function (Blueprint $table) {
          $sql = "
            CREATE TABLE `business_monthly_goals` (
              `company_id` int(11) unsigned NOT NULL COMMENT '企業ID',
              `user_company_id` int(11) unsigned COMMENT '営業ID',
              `target_month` int(11) unsigned NOT NULL COMMENT '対象年月(YYYYMM)',
              `sales` int(11) unsigned COMMENT '売上',
              `matching` int(11) unsigned COMMENT 'マッチング数',
              `del_flag` tinyint DEFAULT '0',
              `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
              `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              UNIQUE KEY `user_company_id_target_month` (`target_month`,`user_company_id`),
              KEY `user_company_id_business_monthly_goals_referenced` (`user_company_id`),
              CONSTRAINT `user_company_id_business_monthly_goals_referenced` FOREIGN KEY (`user_company_id`) REFERENCES `user_company` (`user_company_id`),
              KEY `company_id_business_monthly_goals_referenced` (`company_id`),
              CONSTRAINT `company_id_business_monthly_goals_referenced` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`)
              ) ENGINE=InnoDB;
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
