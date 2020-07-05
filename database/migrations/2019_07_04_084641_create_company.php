<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompany extends Migration
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
          CREATE TABLE `company` (
            `company_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `business_type` VARCHAR(11) NOT NULL,
            `company_name` VARCHAR(255) NOT NULL,
            `prefecture_id` VARCHAR(11),
            `city_id` VARCHAR(11),
            `address` VARCHAR(255),
            `postal_code` VARCHAR(30),
            `hp_url` VARCHAR(255),
            `rep_name` VARCHAR(255),
            `rep_name_ruby` VARCHAR(255),
            `rep_dep_name` VARCHAR(255),
            `rep_email` VARCHAR(255),
            `rep_phone_number` VARCHAR(255),
            `establishment_date` VARCHAR(255),
            `employees_number` VARCHAR(255),
            `capital` VARCHAR(255),
            `sales` VARCHAR(255),
            `company_caption` TEXT,
            `cover_image` VARCHAR(255) NULL DEFAULT NULL,
            `logo_image` VARCHAR(255) NULL DEFAULT NULL,
            `company_name_release_flag` TINYINT(4) NULL DEFAULT 0,
            `release_flag` TINYINT(4) NULL DEFAULT 0,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`company_id`));

          ALTER TABLE `company`
          ADD INDEX `city_id_company_referenced_idx` (`city_id` ASC),
          ADD INDEX `prefecture_id_company_referenced_idx` (`prefecture_id` ASC);

          ALTER TABLE `company`
          ADD CONSTRAINT `prefecture_id_company_referenced`
            FOREIGN KEY (`prefecture_id`)
            REFERENCES `m_prefecture` (`prefecture_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          ADD CONSTRAINT `city_id_company_referenced`
            FOREIGN KEY (`city_id`)
            REFERENCES `m_city` (`city_id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;
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
