<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProjectAddColomunProjectCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('project', function (Blueprint $table) {
        $sql = '
            ALTER TABLE `project` DROP FOREIGN KEY `project_mynavi_company_id_project_referenced`;
            
            ALTER TABLE `project` DROP COLUMN `project_mynavi_company_id`;

            ALTER TABLE `project`
            ADD COLUMN `project_company_id` INT UNSIGNED COMMENT "案件元企業ID" AFTER `company_id`;
            
            ALTER TABLE `project`
            CONSTRAINT `project_company_id_foreign` FOREIGN KEY (`project_company_id`) REFERENCES `company` (`company_id`);
          ';
  
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
