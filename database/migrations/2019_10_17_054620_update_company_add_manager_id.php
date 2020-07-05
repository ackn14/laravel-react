<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCompanyAddManagerId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      $sql = "
            ALTER TABLE `company` ADD `company_manager_id` INT(11) UNSIGNED NULL COMMENT '企業担当者' AFTER `company_id`;
          ";
      DB::connection()->getPdo()->exec($sql);

      Schema::table('company', function (Blueprint $table) {
        $table->foreign('company_manager_id')->references('user_company_id')->on('user_company');
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
