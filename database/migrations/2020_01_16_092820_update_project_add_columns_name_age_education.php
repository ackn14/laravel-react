<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectAddColumnsNameAgeEducation extends Migration
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
             ADD COLUMN `last_name` VARCHAR(255) NULL COMMENT '姓' AFTER `company_id`
            ,ADD COLUMN `first_name` VARCHAR(255) NULL COMMENT '名' AFTER `last_name`
            ,ADD COLUMN `last_name_ruby` VARCHAR(255) NULL COMMENT '姓（ふりがな）' AFTER `first_name`
            ,ADD COLUMN `first_name_ruby` VARCHAR(255) NULL COMMENT '名（ふりがな）' AFTER `last_name_ruby`
            ,ADD COLUMN `age` TINYINT(4) NULL COMMENT '年齢' AFTER `birthday`
            ,ADD COLUMN `school_name` VARCHAR(255) NULL COMMENT '学校名' AFTER `self_introduction`
            ,ADD COLUMN `final_education` VARCHAR(255) NULL COMMENT '最終学歴' AFTER `school_name`
            ,ADD COLUMN `educational_background_detail` VARCHAR(255) NULL COMMENT '学科専攻' AFTER `final_education`
            ,ADD COLUMN `graduate_date` DATE NULL COMMENT '卒業年月日' AFTER `educational_background_detail`
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
