<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeProjectAddSesColumns extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    $sql = "
            ALTER TABLE `project` ADD `project_category` VARCHAR(255) NULL DEFAULT NULL COMMENT '案件カテゴリ' AFTER `pay_rate_max`, 
            ADD `monthly_income_min` INT(11) NULL DEFAULT NULL COMMENT '最低単価' AFTER `project_category`, 
            ADD `monthly_income_max` INT(11) NULL DEFAULT NULL COMMENT '最高単価' AFTER `monthly_income_min`, 
            ADD `settlement_time` VARCHAR(255) NULL DEFAULT NULL COMMENT '精算基準時間' AFTER `monthly_income_max`,
            ADD `contract_period` VARCHAR(255) NULL DEFAULT NULL COMMENT '契約期間' AFTER `settlement_time`, 
            ADD `recruitment_restrictions` VARCHAR(255) NULL DEFAULT NULL COMMENT '募集制限' AFTER `contract_period`, 
            ADD `number_of_interviews` TINYINT(4) NULL DEFAULT NULL COMMENT '面談回数' AFTER `recruitment_restrictions`;

        ";
    DB::connection()->getPdo()->exec($sql);
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
