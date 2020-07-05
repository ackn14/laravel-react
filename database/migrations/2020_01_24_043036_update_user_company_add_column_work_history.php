<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserCompanyAddColumnWorkHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('user_company_work_history');
      
      Schema::table('user_company', function (Blueprint $table) {
    
        $sql = "

          ALTER TABLE `user_company`
            ADD COLUMN `final_employment_name` VARCHAR(50) NULL COMMENT '最終職歴会社名' AFTER `graduate_date`,
            ADD COLUMN `final_employment_department` VARCHAR(50) NULL COMMENT '最終職歴部署名' AFTER `final_employment_name`,
            ADD COLUMN `final_employment_content` TEXT COMMENT '最終職歴業務内容' AFTER `final_employment_department`,
            ADD COLUMN `final_employment_start_date` DATE NULL COMMENT '最終職歴開始日' AFTER `final_employment_content`,
            ADD COLUMN `final_employment_end_date` DATE NULL COMMENT '最終職歴終了日' AFTER `final_employment_start_date`
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
