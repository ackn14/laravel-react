<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProjectAndWorkerTableAddColumnUserCompanyId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
            ALTER TABLE `project` ADD `project_manager_id` INT(11) UNSIGNED NULL COMMENT '案件担当者' AFTER `company_id`;
          ";
      DB::connection()->getPdo()->exec($sql);
      
      $sql = "
            ALTER TABLE `worker` ADD `worker_manager_id` INT(11) UNSIGNED NULL COMMENT '人材担当' AFTER `user_engineer_id`;
          ";
      DB::connection()->getPdo()->exec($sql);

      Schema::table('project', function (Blueprint $table) {
        $table->foreign('project_manager_id')->references('user_company_id')->on('user_company');
      });

      Schema::table('worker', function (Blueprint $table) {
        $table->foreign('worker_manager_id')->references('user_company_id')->on('user_company');
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
