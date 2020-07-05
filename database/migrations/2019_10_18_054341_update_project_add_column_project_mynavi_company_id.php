<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectAddColumnProjectMynaviCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "
        ALTER TABLE `project` ADD `project_mynavi_company_id` INT(11) UNSIGNED NULL COMMENT 'マイナビ案件のうちENGERユーザでない企業ID' AFTER `project_management_no`;
        
        ALTER TABLE `project`
            ADD INDEX `project_mynavi_company_id_project_referenced_idx` (`project_mynavi_company_id` ASC);

        ALTER TABLE `project`
            ADD CONSTRAINT `project_mynavi_company_id_project_referenced`
              FOREIGN KEY (`project_mynavi_company_id`)
              REFERENCES `company` (`company_id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION
        ";
            DB::connection()->getPdo()->exec($sql);
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
