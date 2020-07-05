<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeWorkerDesiredWorkingplaceAddColumnPriority extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "
            ALTER TABLE `worker_desired_workingplace` ADD `priority` TINYINT(4) NULL DEFAULT NULL COMMENT '0:第1希望 1:第2希望' AFTER `prefecture_id`;
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
