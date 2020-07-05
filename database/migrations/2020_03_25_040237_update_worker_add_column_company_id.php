<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWorkerAddColumnCompanyId extends Migration
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

          ALTER TABLE `worker`
            ADD COLUMN `belongs_company_id` INT(11) UNSIGNED NULL COMMENT '所属企業ID' AFTER `worker_manager_id`
            ;

          ";
    
        DB::connection()->getPdo()->exec($sql);
    
      });
  
      Schema::table('worker', function (Blueprint $table) {
        $table->foreign('belongs_company_id')->references('company_id')->on('company');
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
