<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompanyAddColumnsBilling extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('company', function (Blueprint $table) {
    
        $sql = "

          ALTER TABLE `company`
          ADD COLUMN `industry` VARCHAR(11) NULL COMMENT '業界' AFTER `business_type`,
          ADD COLUMN `company_name_ruby` VARCHAR(255) NULL COMMENT '企業名（フリガナ）' AFTER `company_name`,
          ADD COLUMN `address2` VARCHAR(255) NULL COMMENT '建物以降住所' AFTER `address`,
          ADD COLUMN `rep_position` VARCHAR(255) NULL COMMENT '企業代表者役職' AFTER `rep_dep_name`,
          ADD COLUMN `billing_prefecture_id` VARCHAR(11) NULL COMMENT '請求先都道府県ID' AFTER `postal_code`,
          ADD COLUMN `billing_city_id` VARCHAR(11) NULL COMMENT '請求先市区町村ID' AFTER `billing_prefecture_id`,
          ADD COLUMN `billing_address` VARCHAR(255) NULL COMMENT '請求先市区町村以降住所' AFTER `billing_city_id`,
          ADD COLUMN `billing_address2` VARCHAR(255) NULL COMMENT '請求先建物以降住所' AFTER `billing_address`,
          ADD COLUMN `billing_postal_code` VARCHAR(30) NULL COMMENT '請求先郵便番号' AFTER `billing_address2`,
          ADD COLUMN `billing_name` VARCHAR(255) NULL COMMENT '請求先担当氏名' AFTER `billing_postal_code`,
          ADD COLUMN `billing_department` VARCHAR(255) NULL COMMENT '請求先部署' AFTER `billing_name`,
          ADD COLUMN `billing_position` VARCHAR(255) NULL COMMENT '請求先役職' AFTER `billing_department`,
          ADD COLUMN `billing_address_same_flag` TINYINT(4) DEFAULT 0 COMMENT '請求先と所在地の同一性フラグ' AFTER `billing_position`,
          ADD COLUMN `movie_url` VARCHAR(255) NULL COMMENT '企業紹介動画URL' AFTER `hp_url`,
          ADD COLUMN `company_document` VARCHAR(255) NULL COMMENT '説明資料格納パス' AFTER `company_caption`;

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
