<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReCreateTableUserCompanyQualification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::dropIfExists('user_company_qualification');
      
      Schema::table('user_company_qualification', function (Blueprint $table) {
    
        $sql = "

          CREATE TABLE `user_company_qualification` (
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `user_company_id` INT(11) UNSIGNED NOT NULL,
            `qualification_name` VARCHAR(100) NOT NULL comment '資格名',
            `certified_date` DATE DEFAULT NULL comment '資格取得年月日',
            `update_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            CONSTRAINT `user_company_id_user_company_qualification_referenced`
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
