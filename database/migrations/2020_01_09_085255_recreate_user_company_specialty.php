<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateUserCompanySpecialty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_company_specialty');


        Schema::table('user_company_specialty', function (Blueprint $table) {

            $sql = "
            CREATE TABLE `user_company_specialty` (
                `user_company_id` int(11) unsigned NOT NULL COMMENT '企業担当者ID',
                `specialty_id` varchar(11) NOT NULL COMMENT '企業担当者ID',
                `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新時刻',
                PRIMARY KEY (`user_company_id`,`specialty_id`),
                CONSTRAINT `user_company_id_user_company_specialty_referenced` FOREIGN KEY (`user_company_id`) REFERENCES `user_company` (`user_company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                CONSTRAINT `specialty_id_user_company_specialty_referenced` FOREIGN KEY (`specialty_id`) REFERENCES `m_job` (`job_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
                UNIQUE KEY `user_company_id_specialty_id_unique` (`user_company_id`,`specialty_id`)
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
