<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProject extends Migration
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

          CREATE TABLE `project` (
            `project_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) NOT NULL,
            `company_id` INT(11) UNSIGNED NOT NULL,
            `project_management_no` VARCHAR(50),
            `cover_image` VARCHAR(255) NULL DEFAULT NULL,
            `job_id` VARCHAR(11),
            `position` VARCHAR(11),
            `prefecture_id` VARCHAR(11),
            `city_id` VARCHAR(11),
            `nearest_station` VARCHAR(255),
            `pay_rate_min` VARCHAR(11),
            `pay_rate_max` VARCHAR(11),
            `monthly_income` INT(11),
            `contract_type` VARCHAR(11),
            `project_outline` TEXT NULL,
            `salary` TEXT NULL,
            `welfare` TEXT NULL,
            `vacation` TEXT NULL,
            `working_time` TEXT NULL,
            `selection_process` TEXT NULL,
            `desired_personality` TEXT NULL,
            `age_min` TINYINT(4) NULL,
            `age_max` TINYINT(4) NULL,
            `skill_management` VARCHAR(11),
            `skill_english` VARCHAR(11),
            `recruitment_number` INT(11) NULL,
            `latitude` VARCHAR(15) NULL DEFAULT NULL,
            `longitude` VARCHAR(15) NULL DEFAULT NULL,
            `inexperience_ok` TINYINT(4) NULL,
            `posting_end_date` DATE NULL,
            `release_date` DATE NULL,
            `pickup_flag` TINYINT(4) NULL DEFAULT 0,
            `release_flag` TINYINT(4) NULL DEFAULT 0,
            `recruitment_end_flag` TINYINT(4) NULL DEFAULT 0,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`project_id`));

            ALTER TABLE `project`
            ADD INDEX `job_id_project_referenced_idx` (`job_id` ASC),
            ADD INDEX `prefecture_id_project_referenced_idx` (`prefecture_id` ASC),
            ADD INDEX `city_id_project_referenced_idx` (`city_id` ASC),
            ADD INDEX `company_id_project_referenced_idx` (`company_id` ASC);

            ALTER TABLE `project`
            ADD CONSTRAINT `job_id_project_referenced`
              FOREIGN KEY (`job_id`)
              REFERENCES `m_job` (`job_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `prefecture_id_project_referenced`
              FOREIGN KEY (`prefecture_id`)
              REFERENCES `m_prefecture` (`prefecture_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `city_id_project_referenced`
              FOREIGN KEY (`city_id`)
              REFERENCES `m_city` (`city_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION,
            ADD CONSTRAINT `company_id_project_referenced`
              FOREIGN KEY (`company_id`)
              REFERENCES `company` (`company_id`)
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
