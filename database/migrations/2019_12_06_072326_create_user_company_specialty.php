<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCompanySpecialty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('user_company_specialty', function (Blueprint $table) {
    
        $sql = "

          CREATE TABLE `user_company_specialty` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_company_id` INT(11) UNSIGNED NOT NULL,
            `specialty_id` VARCHAR(255) NOT NULL,
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`,`user_company_id`,`specialty_id`),
            CONSTRAINT `user_company_id_user_company_specialty_referenced`
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
