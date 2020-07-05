<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worker', function (Blueprint $table) {

            $sql = "

          CREATE TABLE `worker` (
            `worker_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `worker_type` TINYINT(4),
            `user_engineer_id` INT(11),
            `last_name` VARCHAR(255),
            `first_name` VARCHAR(255),
            `last_name_ruby` VARCHAR(255),
            `first_name_ruby` VARCHAR(255),
            `initial_name` VARCHAR(10),
            `age` TINYINT(4),
            `birthday` DATE,
            `sex` TINYINT(4),
            `phone_number` VARCHAR(255),
            `email` VARCHAR(255),
            `company_from` VARCHAR(255),
            `prefecture_id` VARCHAR(11),
            `city_id` VARCHAR(11),
            `address` VARCHAR(255),
            `nationality` TINYINT(4) NULL DEFAULT 0,
            `desired_contract_type` VARCHAR(11),
            `skill_management` VARCHAR(11),
            `skill_english` VARCHAR(11),
            `cover_image` VARCHAR(255) NULL DEFAULT NULL,
            `logo_image` VARCHAR(255) NULL DEFAULT NULL,
            `resume` VARCHAR(255) NULL DEFAULT NULL,
            `other_resume` VARCHAR(255) NULL DEFAULT NULL,
            `movie` VARCHAR(255) NULL DEFAULT NULL,
            `supervisor_id` INT(11) UNSIGNED NULL DEFAULT NULL,
            `supervisor_comment` TEXT NULL,
            `self_introduction` TEXT NULL,
            `educational_background` VARCHAR(255),
            `educational_background_detail` VARCHAR(255),
            `graduate_date` DATE,
            `priority` TINYINT(4),
            `nearest_station` VARCHAR(255),
            `current_annual_salary` INT(11) UNSIGNED,
            `desired_annual_salary` INT(11) UNSIGNED,
            `operation_date` DATE,
            `release_flag` TINYINT(4) NULL DEFAULT 0,
            `del_flag` TINYINT(4) NULL DEFAULT 0,
            `last_update_user_id` INT(11) UNSIGNED,
            `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`worker_id`));

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
