<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWorkerWorkHistoryRenameColumnBusinessType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('worker_work_history', function (Blueprint $table) {
        $sql = "
          ALTER TABLE `worker_work_history`
          CHANGE COLUMN `business_type` `industry` varchar(50) DEFAULT NULL COMMENT '業界';
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
